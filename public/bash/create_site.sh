#!/bin/bash

# ==========================
#      FUNCTIONS
# ==========================
check_service() {
    if ! systemctl is-active --quiet "$1"; then
        echo "ERROR: Service $1 is not running"
        exit "$2"
    fi
}

gen_pass() {
    PASS_LEN=$(perl -le 'print int(rand(6))+9')
    START_LEN=$(perl -le 'print int(rand(8))+1')
    END_LEN=$((PASS_LEN - START_LEN))
    NUMERIC_CHAR=$(perl -le 'print int(rand(10))')
    PASS_START=$(perl -le "print map+(A..Z,a..z,0..9)[rand 62],0..$START_LEN")
    PASS_END=$(perl -le "print map+(A..Z,a..z,0..9)[rand 62],0..$END_LEN")
    PASS=${PASS_START}${NUMERIC_CHAR}${PASS_END}
    echo "$PASS"
}

create_user() {
    if ! id "$USER" &>/dev/null; then
        useradd --shell /sbin/nologin --home "/home/$USER" --no-create-home "$USER" || {
            echo "ERROR: Failed to create user $USER"
            exit 103
        }
    fi
}

create_ftp() {
    FTP_PASS=$(gen_pass)
    pure-pw useradd "$USER" -u "$USER" -g "$USER" -d "$WEB_ROOT" <<EOF
${FTP_PASS}
${FTP_PASS}
EOF
    if [ $? -ne 0 ]; then
        echo "ERROR: Failed to create FTP user $USER"
        exit 104
    fi
    pure-pw mkdb
    echo "FTP User Created: $USER with password $FTP_PASS"
}

check_service() {
    if ! systemctl is-active --quiet "$1"; then
        echo "ERROR: Service $1 is not running"
        exit "$2"
    fi
}

gen_pass() {
    PASS_LEN=$(perl -le 'print int(rand(6))+9')
    START_LEN=$(perl -le 'print int(rand(8))+1')
    END_LEN=$((PASS_LEN - START_LEN))
    NUMERIC_CHAR=$(perl -le 'print int(rand(10))')
    PASS_START=$(perl -le "print map+(A..Z,a..z,0..9)[rand 62],0..$START_LEN")
    PASS_END=$(perl -le "print map+(A..Z,a..z,0..9)[rand 62],0..$END_LEN")
    PASS=${PASS_START}${NUMERIC_CHAR}${PASS_END}
    echo "$PASS"
}

create_user() {
    if ! id "$USER" &>/dev/null; then
        useradd --shell /sbin/nologin --home "/home/$USER" --no-create-home "$USER" || {
            echo "ERROR: Failed to create user $USER"
            exit 103
        }
    fi
}

create_ftp() {
    FTP_PASS=$(gen_pass)
    pure-pw useradd "$USER" -u "$USER" -g "$USER" -d "$WEB_ROOT" <<EOF
${FTP_PASS}
${FTP_PASS}
EOF
    if [ $? -ne 0 ]; then
        echo "ERROR: Failed to create FTP user $USER"
        exit 104
    fi
    pure-pw mkdb
    echo "FTP User Created: $USER with password $FTP_PASS"
}

save_user_config() {
    cat >"$USER_DIR/.${DOMAIN}.conf" <<END
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

# ==========================
#      CONFIG VARIABLES
# ==========================
DOMAIN="$1"
PHP_VERSION="7.4"

USER=${DOMAIN//[-._]/}
USER=$(echo "$USER" | cut -c 1-7)
USER="${USER}$(perl -le "print map+(A..Z,a..z,0..9)[rand 62],0..3")"

PREFIX=$(
    tr </dev/urandom -dc '[:lower:]' | head -c3
    echo
)
DB_USER=$(echo "${USER}"_"${PREFIX}" | tr '[:upper:]' '[:lower:]')
DB_NAME=$(echo "${PREFIX}"_"${USER}" | tr '[:upper:]' '[:lower:]')
DB_PASS=$(gen_pass)

PHP_FPM_CONF="/etc/php-fpm.d/$DOMAIN.conf"
NGINX_CONF="/etc/nginx/conf.d/$DOMAIN.conf"
WEB_ROOT="/home/$DOMAIN/public_html"
LOG_DOMAIN_DIR="/home/$DOMAIN/logs"
USER_DIR="/home/$USER/public_html"

LOG_DIR="/home/$USER/logs"
TMP_DIR="/home/$USER/tmp"
SESSION_PATH="/home/$USER/php/session"
JSON_OUTPUT="/binhchay/output/$DOMAIN.json"
LOGO_PATH="/home/$DOMAIN/public_html/wp-content/uploads/2025/02/"

PLUGIN_DIR="$WEB_ROOT/wp-content/plugins/"
THEME_DIR="$WEB_ROOT/wp-content/themes/"
PLUGIN_SOURCE_DIR="/binhchay/plugins/"
THEME_SOURCE_DIR="/binhchay/themes/"
FILE_PATH_UPDATE_THEME="/binhchay/theme_update.txt"

SOCKET_PATH="/var/run/php-fpm/$USER.sock"

WEBSITE_TILE=$(echo "$DOMAIN" | sed -E 's/[-._]/ /g' | awk '{for(i=1;i<=NF;i++) $i=toupper(substr($i,1,1)) tolower(substr($i,2))}1')
ADMIN_PASSWORD=$(gen_pass)

INFO_FILE="/home/DBinfo.txt"
CURRENT_TIME=$(date +"%Y-%m-%d %H:%M:%S")

# ==========================
#      CHECK ENVIRONMENT
# ==========================
check_service "nginx" 101
check_service "mariadb" 102

# ==========================
#      CREATE USER & DIRS
# ==========================

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
cat >"$PHP_FPM_CONF" <<EOF
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

# ==========================
#      CONFIGURE NGINX
# ==========================
cat >"$NGINX_CONF" <<EOF
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
nginx -t && systemctl reload nginx

# ==========================
#      INSTALL WORDPRESS
# ==========================
cd "$WEB_ROOT"
wp core download --allow-root
wp config create --dbname="$DB_NAME" --dbuser="$DB_USER" --dbpass="$DB_PASS" --allow-root
wp core install --url="https://$DOMAIN" --title="$WEBSITE_TILE" --admin_user="admin" --admin_password="$ADMIN_PASSWORD" --admin_email="binhchay.modobom@gmail.com" --allow-root
wp post create --post_type="blocks" --post_title="Footer" --post_content="[section bg=\"811\" bg_size=\"thumbnail\" bg_color=\"rgb(0,0,0)\" bg_overlay=\"rgba(8, 7, 7, 0.99)\"][row style=\"collapse\"][col span__sm=\"12\"]<p style=\"text-align: center;\"><span style=\"font-size: 14.4px; color: #ffffff;\">Copyright © 2024 $DOMAIN</span></p><div class=\"copyright\"><p style=\"text-align: center;\"><span style=\"color: #ffffff;\">This Website Provides You With A Link To Download Games/Apps. We Do Not Directly Create Products Nor Do Business On Products (Games, Apps).</span></p><p style=\"text-align: center;\"><span style=\"color: #ffffff;\"><a style=\"color: #ffffff;\" href=\"/introduction/\"><b>Introduction</b></a> | <a style=\"color: #ffffff;\" href=\"/privacy-policy/\"><b>Privacy Policy</b></a> | <a style=\"color: #ffffff;\" href=\"/terms-conditions/\"><b>Terms – Conditions</b></a> | <a style=\"color: #ffffff;\" href=\"/installation-uninstallation-instructions/\"><strong>Installation/Uninstallation Instructions</strong></a> | <a style=\"color: #ffffff;\" href=\"/contact-us/\"><b>Contact Us</b></a> |</span></p></div>[/col][/row][/section]" --post_status="publish" --post_name="footer" --post_author=2 --ping_status="closed" --comment_status="closed" --post_date="$(date +"%Y-%m-%d %H:%M:%S")" --post_date_gmt="$(date -u +"%Y-%m-%d %H:%M:%S")" --guid="https://$DOMAIN/?post_type=blocks&p=219" --allow-root
chown -R "$USER:$USER" "$WEB_ROOT"

grep -q "define('FORCE_SSL_ADMIN', true);" "$WEB_ROOT/wp-config.php" || sed -i "/\/\* That's all, stop editing! Happy publishing. \*\//i\define('FORCE_SSL_ADMIN', true);\n\$_SERVER['HTTPS'] = 'on';" "$WEB_ROOT/wp-config.php"

cat >"/home/$DOMAIN/public_html/robots.txt" <<END
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
#      INSTALL THEME
# ==========================
if [[ -d "$THEME_SOURCE_DIR" ]]; then
    for THEME_ZIP in "$THEME_SOURCE_DIR"/*.zip; do
        if [[ -f "$THEME_ZIP" ]]; then
            unzip -o "$THEME_ZIP" -d "$THEME_DIR"
        fi
    done

    wp theme activate bds --allow-root
    chown -R "$USER:$USER" "$THEME_DIR"
fi

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

chown -R "$USER" "$WEB_ROOT/"

# ==========================
#      READ FILE AND UPDATE THEME
# ==========================

if [[ -f "$FILE_PATH_UPDATE_THEME" ]]; then
    FILE_CONTENT=$(cat "$FILE_PATH_UPDATE_THEME")
    CONTENT=$(echo "$FILE_CONTENT" | sed "s/oneapponline.com/$DOMAIN/g")

    echo "Nội dung file đã sửa (serialized): $CONTENT"

    PHP_ARRAY=$(php -r "echo json_encode(unserialize('$CONTENT'));" 2>/dev/null)

    wp option update theme_mods_bds "$PHP_ARRAY" --format=json --allow-root || {
        echo "ERROR: Failed to update theme_mods_bds with WP-CLI"
        exit 1
    }

    wp cache flush --allow-root

    THEME_MODS_SERIALIZED=$(mysql -u "$DB_USER" -p"$DB_PASS" -D "$DB_NAME" -N -e "SELECT option_value FROM wp_options WHERE option_name = 'theme_mods_bds';")
    echo "Giá trị serialized từ database: $THEME_MODS_SERIALIZED"

    if [ "$THEME_MODS_SERIALIZED" = "$CONTENT" ]; then
        echo "Giá trị khớp với nội dung file!"
    else
        echo "Giá trị không khớp với nội dung file!"
        echo "Debug: CONTENT length: ${#CONTENT}, THEME_MODS length: ${#THEME_MODS_SERIALIZED}"
    fi

    THEME_MODS=$(wp option get theme_mods_bds --allow-root --format=json)
    echo "Giá trị của theme_mods_bds từ WP-CLI: $THEME_MODS"

    echo "Cập nhật dữ liệu thành công vào wp_options!"
else
    echo "File $FILE_PATH_UPDATE_THEME không tồn tại!"
fi

mkdir -p /home/$DOMAIN/public_html/wp-content/uploads/2025/02/
wp cache flush --allow-root
service php-fpm restart
service nginx restart
service varnish restart

# ==========================
#      SAVE TO DBinfo.txt
# ==========================
echo -e "\n\nBan đa them domain thanh cong. Hay luu lai thong tin de su dung" >>"$INFO_FILE"
echo "$CURRENT_TIME" >>"$INFO_FILE"
echo "---------------------------------------------------------------" >>"$INFO_FILE"
echo "* Domain                     : $DOMAIN" >>"$INFO_FILE"
echo "* DB_Name                    : $DB_NAME" >>"$INFO_FILE"
echo "* DB_User                    : $DB_USER" >>"$INFO_FILE"
echo "* DB_Password                : $DB_PASS" >>"$INFO_FILE"
echo "* Username (FTP)             : $USER" >>"$INFO_FILE"
echo "* Password (FTP)             : $user_pass" >>"$INFO_FILE"
echo "* FTP Host                   : 139.162.44.151" >>"$INFO_FILE"
echo "* FTP Port                   : 21" >>"$INFO_FILE"
echo "* Public_html                : $WEB_ROOT" >>"$INFO_FILE"
echo "* User dang nhap wp-admin    : admin" >>"$INFO_FILE"
echo "* Mat khau dang nhap wp-admin: $ADMIN_PASSWORD" >>"$INFO_FILE"
echo "---------------------------------------------------------------" >>"$INFO_FILE"

# ==========================
#      PRINT JSON OUTPUT
# ==========================

cat <<EOF >"$JSON_OUTPUT"
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
