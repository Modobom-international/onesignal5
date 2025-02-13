#!/bin/bash

# ==========================
#      CONFIG VARIABLES
# ==========================
DOMAIN="$1"
PHP_VERSION="7.4"

USER=${DOMAIN//[-._]/}
USER=$(echo "$USER" | cut -c 1-7)
USER="${USER}$(perl -le "print map+(A..Z,a..z,0-9)[rand 62],0..3")"

PHP_FPM_CONF="/etc/php/$PHP_VERSION/fpm/pool.d/$DOMAIN.conf"
NGINX_CONF="/etc/nginx/sites-available/$DOMAIN"
WEB_ROOT="/home/$DOMAIN/public_html"
USER_DIR="/home/$USER/public_html"

SOCKET_PATH="/run/php/php$PHP_VERSION-fpm-$USER.sock"
LOG_DIR="/home/$USER/logs"
TMP_DIR="/home/$USER/tmp"
SESSION_PATH="/home/$USER/php/session"

PLUGIN_DIR="$WEB_ROOT/wp-content/plugins/"
PLUGIN_SOURCE_DIR="/binhchay/plugins/"

PREFIX_DB=$(< /dev/urandom tr -dc '[:lower:]' | head -c"${1:-3}";echo;)
DB_USER=$(echo "${USER}"_"${PREFIX_DB}" | tr '[:upper:]' '[:lower:]')
DB_NAME=$(echo "${PREFIX_DB}"_"${USER}" | tr '[:upper:]' '[:lower:]')
DB_PASS=$(openssl rand -base64 12)

WEBSITE_TILE=$(echo "$DOMAIN" | sed -E 's/[-._]/ /g' | awk '{for(i=1;i<=NF;i++) $i=toupper(substr($i,1,1)) tolower(substr($i,2))}1')
ADMIN_PASSWORD=$(openssl rand -base64 12 | tr -dc 'A-Za-z0-9!@#$%^&*()_+={}[]')

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
check_service "php$PHP_VERSION-fpm" 103

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
    "db_name": "${db_name}",
    "db_user": "${db_user}",
    "db_password": "${db_pass}",
    "public_html": "${WEB_ROOT}",
    "php_version": "${PHP_VERSION}"
}
END
    chmod 600 "$USER_DIR/.${DOMAIN}.conf"
}

create_user
create_ftp
save_user_config

mkdir -p "$WEB_ROOT" "$LOG_DIR" "$TMP_DIR" "$SESSION_PATH" "$PLUGIN_DIR" "$USER_DIR"
chown -R "$USER:$USER" "$WEB_ROOT"
chmod 750 "$WEB_ROOT"

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
user = $USER
group = $USER
listen = $SOCKET_PATH
listen.owner = www-data
listen.group = www-data
listen.mode = 0660
pm = ondemand
pm.max_children = 10
pm.process_idle_timeout = 20s
pm.max_requests = 500
php_admin_value[error_log] = $LOG_DIR/php-error.log
php_admin_flag[log_errors] = on
php_value[session.save_path] = $SESSION_PATH
php_admin_value[open_basedir] = $WEB_ROOT:/usr/share/php
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
    error_log /home/${USER}/logs/error.log;
    root /home/${USER}/public_html;
    index index.php index.html index.htm;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location ~ \.php\$ {
        try_files \$uri =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)\$;
        fastcgi_index index.php;
        include /etc/nginx/fastcgi_params;
        include /etc/nginx/extra/nginx_limits.conf;
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
        if (-f \$request_filename) {
            fastcgi_pass php-${USER};
        }
    }

    include /etc/nginx/extra/staticfiles.conf;
    include /etc/nginx/extra/security.conf;
}
EOF
ln -s "$NGINX_CONF" /etc/nginx/sites-enabled/
nginx -t && systemctl reload nginx

# ==========================
#      INSTALL WORDPRESS
# ==========================
cd "$WEB_ROOT"
wp core download --allow-root
wp config create --dbname="$DB_NAME" --dbuser="$DB_USER" --dbpass="$DB_PASS" --allow-root
wp core install --url="https://$DOMAIN" --title="$WEBSITE_TILE" --admin_user="admin" --admin_password="$ADMIN_PASSWORD" --admin_email="binhchay.modobom@gmail.com" --allow-root
chown -R "$USER:$USER" "$WEB_ROOT"

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

# ==========================
#      OUTPUT JSON RESULT
# ==========================
echo "{"
echo "  \"domain\": \"${DOMAIN}\","  
echo "  \"username\": \"${USER}\","  
echo "  \"db_name\": \"${db_name}\","  
echo "  \"db_user\": \"${db_user}\","  
echo "  \"db_password\": \"${db_pass}\","  
echo "  \"public_html\": \"${WEB_ROOT}\","  
echo "  \"php_version\": \"${PHP_VERSION}\","  
echo "  \"ftp_user\": \"${USER}\","  
echo "  \"ftp_password\": \"${user_pass}\""
echo "}"

exit 0
