#!/bin/bash

# ==========================
#      CONFIG VARIABLES
# ==========================
DOMAIN="$1"
PHP_VERSION="7.4"

USER=${DOMAIN//[-._]/}
USER=$(echo "$USER" | cut -c 1-7)
USER="${USER}$(perl -le "print map+(A..Z,a..z,0-9)[rand 62],0..3")"

PHP_FPM_CONF="/etc/php-fpm.d/$DOMAIN.conf"
NGINX_CONF="/etc/nginx/conf.d/$DOMAIN.conf"
WEB_ROOT="/home/$DOMAIN/public_html"
LOG_DOMAIN_DIR="/home/$DOMAIN/logs"
USER_DIR="/home/$USER/public_html"

LOG_DIR="/home/$USER/logs"
TMP_DIR="/home/$USER/tmp"
SESSION_PATH="/home/$USER/php/session"
JSON_OUTPUT="/binhchay/output/$DOMAIN.json"

PLUGIN_DIR="$WEB_ROOT/wp-content/plugins/"
PLUGIN_SOURCE_DIR="/binhchay/plugins/"

SOCKET_PATH="/var/run/php-fpm/$USER.sock"

PREFIX_DB=$(< /dev/urandom tr -dc '[:lower:]' | head -c3; echo)
DB_USER=$(echo "${USER}"_"${PREFIX_DB}" | tr '[:upper:]' '[:lower:]')
DB_NAME=$(echo "${PREFIX_DB}"_"${USER}" | tr '[:upper:]' '[:lower:]')
DB_PASS=$(openssl rand -base64 12)

WEBSITE_TILE=$(echo "$DOMAIN" | sed -E 's/[-._]/ /g' | awk '{for(i=1;i<=NF;i++) $i=toupper(substr($i,1,1)) tolower(substr($i,2))}1')
ADMIN_PASSWORD=$(openssl rand -base64 12 | tr -dc 'A-Za-z0-9!@#$%^&*()_+={}[]')

INFO_FILE="/home/DBinfo.txt"
CURRENT_TIME=$(date +"%Y-%m-%d %H:%M:%S")

# ==========================
#      CHECK ENVIRONMENT
# ==========================
check_service() {
    if ! systemctl is-active --quiet "$1"; then
        echo "ERROR: Service $1 is not running"
        exit "$2"
    fi
}

check_service "nginx" 101
check_service "mariadb" 102

# ==========================
#      CREATE USER & DIRS
# ==========================
create_user() {
    if ! id "$USER" &>/dev/null; then
        useradd --shell /sbin/nologin "$USER"
    fi
}

create_ftp() {
    user_pass=$(openssl rand -base64 12 | tr -dc 'A-Za-z0-9!@#$%^&*()_+={}[]')
    pure-pw useradd "$USER" -u "$USER" -g "$USER" -d "$WEB_ROOT" <<EOF
${user_pass}
${user_pass}
EOF
    pure-pw mkdb
    echo "FTP User Created: $USER with password $user_pass"
}

save_user_config() {
    cat > "$USER_DIR/.${DOMAIN}.conf" <<END
{
    "domain": "${DOMAIN}",
    "username": "${USER}",
    "user_pass": "${user_pass}",
    "db_name": "${DB_NAME}",
    "db_user": "${DB_USER}",
    "db_password": "${DB_PASS}",
    "public_html": "${WEB_ROOT}",
    "php_version": "${PHP_VERSION}"
}
END
    chmod 600 "$USER_DIR/.${DOMAIN}.conf"
}

mkdir -p "$USER_DIR"
mkdir -p "$LOG_DOMAIN_DIR"
mkdir -p "$WEB_ROOT" "$LOG_DIR" "$TMP_DIR" "$SESSION_PATH" "$PLUGIN_DIR" "$USER_DIR"

create_user
create_ftp
save_user_config

chown -R "$USER:$USER" "$WEB_ROOT"
chmod -R 755 "/home/$DOMAIN/public_html/"
chmod -R 755 "/home/$DOMAIN/logs/"

# ==========================
#      CREATE DATABASE
# ==========================
mysql -u root -e "
CREATE DATABASE IF NOT EXISTS $DB_NAME;
GRANT ALL PRIVILEGES ON $DB_NAME.* TO '$DB_USER'@'localhost' IDENTIFIED BY '$DB_PASS';
FLUSH PRIVILEGES;"

# ==========================
#      CONFIGURE PHP-FPM
# ==========================
cat > "$PHP_FPM_CONF" << EOF
[$USER]
listen = $SOCKET_PATH;
listen.allowed_clients = 127.0.0.1
listen.owner = $USER
listen.group = nginx
listen.mode = 0660
user = $USER
group = $USER
pm = ondemand
pm.max_children = 15
pm.process_idle_timeout = 20
pm.max_requests = 2000
;slowlog = /var/log/php-fpm/$DOMAIN-slow.log
chdir = /
env[TMP] = /home/$USER/tmp
env[TMPDIR] = /home/$USER/tmp
env[TEMP] = /home/$USER/tmp
php_admin_value[error_log] = /var/log/php-fpm/$DOMAIN-error.log
php_admin_flag[log_errors] = on
php_value[session.save_handler] = files
php_value[session.save_path]    = /home/$USER/php/session
php_value[soap.wsdl_cache_dir]  = /home/$USER/php/wsdlcache
php_admin_value[disable_functions] = exec,system,passthru,shell_exec,proc_close,proc_open,dl,popen,show_source,posix_kill,posix_mkfifo,posix_getpwuid,posix_setpgid,posix_setsid,posix_setuid,posix_setgid,posix_sete$
php_admin_value[upload_tmp_dir] = /home/$USER/tmp
php_admin_value[open_basedir] = /home/$DOMAIN/:/home/$USER/:/dev/urandom:/usr/share/php/:/dev/shm
security.limit_extensions = .php
EOF
systemctl reload php$PHP_VERSION-fpm

# ==========================
#      CONFIGURE NGINX
# ==========================
cat > "$NGINX_CONF" << EOF
upstream php-${USER} {
    server unix:$SOCKET_PATH;
}

server {
    listen 8080;
    server_name ${DOMAIN} www.${DOMAIN};
    error_log /home/${DOMAIN}/logs/error.log;
    root /home/${DOMAIN}/public_html;
    index index.php index.html index.htm;
    include /etc/nginx/rewrite/wordpress.conf;
    location ~ \.php$ {
        try_files \$uri =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_index index.php;
        include /etc/nginx/fastcgi_params;
        include /etc/nginx/extra/nginx_limits.conf;
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
        if (-f \$request_filename)
        {
            fastcgi_pass php-${USER};
        }
    }
    location = /wp-login.php {
        limit_req zone=two burst=3 nodelay;
        include /etc/nginx/fastcgi_params;
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
        fastcgi_pass php-${USER};
    }
    include /etc/nginx/extra/staticfiles.conf;
    include /etc/nginx/extra/security.conf;
    include /etc/nginx/wordpress/wordpress_secure.conf;
    include /etc/nginx/wordpress/disable_xmlrpc.conf;
}
EOF
if [ -L "/etc/nginx/sites-enabled/$DOMAIN" ]; then
    rm "/etc/nginx/sites-enabled/$DOMAIN"
fi
ln -s "$NGINX_CONF" "/etc/nginx/sites-enabled/"
nginx -t && systemctl reload nginx

# ==========================
#      INSTALL WORDPRESS
# ==========================
cd "$WEB_ROOT"
wp core download --allow-root
wp config create --dbname="$DB_NAME" --dbuser="$DB_USER" --dbpass="$DB_PASS" --allow-root
wp core install --url="https://$DOMAIN" --title="$WEBSITE_TILE" --admin_user="admin" --admin_password="$ADMIN_PASSWORD" --admin_email="binhchay.modobom@gmail.com" --allow-root
chown -R "$USER:$USER" "$WEB_ROOT"

echo "define('FORCE_SSL_ADMIN', true);" >> "$WEB_ROOT/wp-config.php"
echo "\$_SERVER['HTTPS'] = 'on';" >> "$WEB_ROOT/wp-config.php"

cat > "/home/$DOMAIN/public_html/robots.txt" <<END
User-agent: *
Disallow: /wp-admin/
Disallow: /wp-includes/
Disallow: /search?q=*
Disallow: *?replytocom
Disallow: */attachment/*
Disallow: /images/
Allow: /wp-admin/admin-ajax.php
Allow: /*.js$
Allow: /*.css$
END

# ==========================
#      INSTALL PLUGINS
# ==========================
if [[ -d "$PLUGIN_SOURCE_DIR" ]]; then
    for PLUGIN_ZIP in "$PLUGIN_SOURCE_DIR"/*.zip; do
        if [[ -f "$PLUGIN_ZIP" ]]; then
            unzip -o "$PLUGIN_ZIP" -d "$PLUGIN_DIR"
        fi
    done

    wp plugin activate --all --allow-root
    chown -R "$USER:$USER" "$PLUGIN_DIR"
fi

service php-fpm restart
service nginx restart
service varnish restart

# ==========================
#      SAVE TO DBinfo.txt
# ==========================
echo -e "\n\nBan đa them domain thanh cong. Hay luu lai thong tin de su dung" >> "$INFO_FILE"
echo "$CURRENT_TIME" >> "$INFO_FILE"
echo "---------------------------------------------------------------" >> "$INFO_FILE"
echo "* Domain                     : $DOMAIN" >> "$INFO_FILE"
echo "* DB_Name                    : $DB_NAME" >> "$INFO_FILE"
echo "* DB_User                    : $DB_USER" >> "$INFO_FILE"
echo "* DB_Password                : $DB_PASS" >> "$INFO_FILE"
echo "* Username (FTP)             : $USER" >> "$INFO_FILE"
echo "* Password (FTP)             : $user_pass" >> "$INFO_FILE"
echo "* FTP Host                   : 139.162.44.151" >> "$INFO_FILE"
echo "* FTP Port                   : 21" >> "$INFO_FILE"
echo "* Public_html                : $WEB_ROOT" >> "$INFO_FILE"
echo "* User dang nhap wp-admin    : admin" >> "$INFO_FILE"
echo "* Mat khau dang nhap wp-admin: $ADMIN_PASSWORD" >> "$INFO_FILE"
echo "---------------------------------------------------------------" >> "$INFO_FILE"

# ==========================
#      PRINT JSON OUTPUT
# ==========================

cat <<EOF > "$JSON_OUTPUT"
{
  "domain": "$DOMAIN",
  "username": "$USER",
  "db_name": "$DB_NAME",
  "db_user": "$DB_USER",
  "db_password": "$DB_PASS",
  "public_html": "$WEB_ROOT",
  "php_version": "$PHP_VERSION",
  "ftp_user": "$USER",
  "ftp_password": "$user_pass",
  "admin_username": "admin",
  "admin_password": "$ADMIN_PASSWORD"
}
EOF

exit 0
