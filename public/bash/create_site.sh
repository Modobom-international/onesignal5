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
    FTP_PASS=$(gen_pass)  # Đổi tên để tránh xung đột với biến toàn cục
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
    cat >"$USER_DIR/.${DOMAIN}.conf" <<END || {
        echo "ERROR: Failed to create config file $USER_DIR/.${DOMAIN}.conf"
        exit 105
    }
{
    "domain": "${DOMAIN}",
    "username": "${USER}",
    "user_pass": "${FTP_PASS}",
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
#      CHECK INPUT
# ==========================
if [ -z "$1" ]; then
    echo "ERROR: No domain provided. Usage: $0 <domain>"
    exit 100
fi

# ==========================
#      CONFIG VARIABLES
# ==========================
DOMAIN="$1"
PHP_VERSION="7.4"

# Tạo USER
USER=${DOMAIN//[-._]/}
USER=$(echo "$USER" | cut -c 1-7)
USER="${USER}$(perl -le "print map+(A..Z,a..z,0..9)[rand 62],0..3")"

# Tạo PREFIX, DB_USER, DB_NAME, DB_PASS
PREFIX=$(< /dev/urandom tr -dc '[:lower:]' | head -c3;echo;)
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
mkdir -p "$USER_DIR" "$LOG_DOMAIN_DIR" "$WEB_ROOT" "$LOG_DIR" "$TMP_DIR" "$SESSION_PATH" "$PLUGIN_DIR" "$USER_DIR" || {
    echo "ERROR: Failed to create directories"
    exit 106
}

create_user
FTP_PASS=""  # Khai báo trước để tránh lỗi undefined
create_ftp
save_user_config

chown -R "$USER:$USER" "$WEB_ROOT" || {
    echo "ERROR: Failed to chown $WEB_ROOT"
    exit 107
}
chmod -R 755 "/home/$DOMAIN/public_html/" "/home/$DOMAIN/logs/" || {
    echo "ERROR: Failed to chmod directories"
    exit 108
}

# ==========================
#      CREATE DATABASE
# ==========================
mysql -u root -e "
CREATE DATABASE IF NOT EXISTS $DB_NAME;
GRANT ALL PRIVILEGES ON $DB_NAME.* TO '$DB_USER'@'localhost' IDENTIFIED BY '$DB_PASS';
FLUSH PRIVILEGES;" || {
    echo "ERROR: Failed to create database or grant privileges"
    exit 109
}

# ==========================
#      CONFIGURE PHP-FPM
# ==========================
cat >"$PHP_FPM_CONF" <<EOF || {
    echo "ERROR: Failed to create $PHP_FPM_CONF"
    exit 110
}
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
service php-fpm restart || {
    echo "ERROR: Failed to restart php-fpm"
    exit 111
}

# ==========================
#      CONFIGURE NGINX
# ==========================
cat >"$NGINX_CONF" <<EOF || {
    echo "ERROR: Failed to create $NGINX_CONF"
    exit 112
}
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
nginx -t && systemctl reload nginx || {
    echo "ERROR: Failed to reload nginx"
    exit 113
}

# ==========================
#      INSTALL WORDPRESS
# ==========================
cd "$WEB_ROOT"
wp core download --allow-root || {
    echo "ERROR: Failed to download WordPress core"
    exit 114
}
wp config create --dbname="$DB_NAME" --dbuser="$DB_USER" --dbpass="$DB_PASS" --allow-root || {
    echo "ERROR: Failed to create WordPress config"
    exit 115
}
wp core install --url="https://$DOMAIN" --title="$WEBSITE_TILE" --admin_user="admin" --admin_password="$ADMIN_PASSWORD" --admin_email="binhchay.modobom@gmail.com" --allow-root || {
    echo "ERROR: Failed to install WordPress"
    exit 116
}
wp post create --post_type="blocks" --post_title="Footer" --post_content="[section bg=\"811\" bg_size=\"thumbnail\" bg_color=\"rgb(0,0,0)\" bg_overlay=\"rgba(8, 7, 7, 0.99)\"][row style=\"collapse\"][col span__sm=\"12\"]<p style=\"text-align: center;\"><span style=\"font-size: 14.4px; color: #ffffff;\">Copyright © 2024 $DOMAIN</span></p><div class=\"copyright\"><p style=\"text-align: center;\"><span style=\"color: #ffffff;\">This Website Provides You With A Link To Download Games/Apps. We Do Not Directly Create Products Nor Do Business On Products (Games, Apps).</span></p><p style=\"text-align: center;\"><span style=\"color: #ffffff;\"><a style=\"color: #ffffff;\" href=\"/introduction/\"><b>Introduction</b></a> | <a style=\"color: #ffffff;\" href=\"/privacy-policy/\"><b>Privacy Policy</b></a> | <a style=\"color: #ffffff;\" href=\"/terms-conditions/\"><b>Terms – Conditions</b></a> | <a style=\"color: #ffffff;\" href=\"/installation-uninstallation-instructions/\"><strong>Installation/Uninstallation Instructions</strong></a> | <a style=\"color: #ffffff;\" href=\"/contact-us/\"><b>Contact Us</b></a> |</span></p></div>[/col][/row][/section]" --post_status="publish" --post_name="footer" --post_author=2 --ping_status="closed" --comment_status="closed" --post_date="$(date +"%Y-%m-%d %H:%M:%S")" --post_date_gmt="$(date -u +"%Y-%m-%d %H:%M:%S")" --guid="https://$DOMAIN/?post_type=blocks&p=219" --allow-root || {
    echo "ERROR: Failed to create WordPress footer post"
    exit 117
}
chown -R "$USER:$USER" "$WEB_ROOT" || {
    echo "ERROR: Failed to chown $WEB_ROOT after WordPress install"
    exit 118
}

grep -q "define('FORCE_SSL_ADMIN', true);" "$WEB_ROOT/wp-config.php" || sed -i "/\/\* That's all, stop editing! Happy publishing. \*\//i\define('FORCE_SSL_ADMIN', true);\n\$_SERVER['HTTPS'] = 'on';" "$WEB_ROOT/wp-config.php" || {
    echo "ERROR: Failed to update wp-config.php"
    exit 119
}

cat >"/home/$DOMAIN/public_html/robots.txt" <<END || {
    echo "ERROR: Failed to create robots.txt"
    exit 120
}
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
            unzip -o "$THEME_ZIP" -d "$THEME_DIR" || {
                echo "ERROR: Failed to unzip theme $THEME_ZIP"
                exit 121
            }
        fi
    done

    wp theme activate bds --allow-root || {
        echo "ERROR: Failed to activate theme bds"
        exit 122
    }
    chown -R "$USER:$USER" "$THEME_DIR" || {
        echo "ERROR: Failed to chown $THEME_DIR"
        exit 123
    }
fi

# ==========================
#      INSTALL PLUGINS
# ==========================
if [[ -d "$PLUGIN_SOURCE_DIR" ]]; then
    for PLUGIN_ZIP in "$PLUGIN_SOURCE_DIR"/*.zip; do
        if [[ -f "$PLUGIN_ZIP" ]]; then
            unzip -o "$PLUGIN_ZIP" -d "$PLUGIN_DIR" || {
                echo "ERROR: Failed to unzip plugin $PLUGIN_ZIP"
                exit 124
            }
        fi
    done

    wp plugin activate --all --allow-root || {
        echo "ERROR: Failed to activate plugins"
        exit 125
    }
    chown -R "$USER:$USER" "$PLUGIN_DIR" || {
        echo "ERROR: Failed to chown $PLUGIN_DIR"
        exit 126
    }
fi

chown -R "$USER" "$WEB_ROOT/" || {
    echo "ERROR: Failed to chown $WEB_ROOT final"
    exit 127
}

# ==========================
#      READ FILE AND UPDATE THEME
# ==========================
if [[ -f "$FILE_PATH_UPDATE_THEME" ]]; then
    FILE_CONTENT=$(cat "$FILE_PATH_UPDATE_THEME")
    CONTENT=$(echo "$FILE_CONTENT" | sed "s/oneapponline.com/$DOMAIN/g")
    ESCAPED_CONTENT=$(echo "$CONTENT" | sed "s/'/\\\'/g")

    mysql -u "$DB_USER" -p"$DB_PASS" -D "$DB_NAME" -e "
    UPDATE wp_options
    SET option_value = '$ESCAPED_CONTENT'
    WHERE option_name = 'theme_mods_bds';" || {
        echo "ERROR: Failed to update wp_options"
        exit 128
    }

    echo "Cập nhật dữ liệu thành công vào wp_options!"
else
    echo "File $FILE_PATH_UPDATE_THEME không tồn tại!"
fi

mkdir -p "$LOGO_PATH" || {
    echo "ERROR: Failed to create $LOGO_PATH"
    exit 129
}
wp cache flush --allow-root || {
    echo "ERROR: Failed to flush WordPress cache"
    exit 130
}
service php-fpm restart || {
    echo "ERROR: Failed to restart php-fpm"
    exit 131
}
service nginx restart || {
    echo "ERROR: Failed to restart nginx"
    exit 132
}
service varnish restart || {
    echo "ERROR: Failed to restart varnish"
    exit 133
}

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
echo "* Password (FTP)             : $FTP_PASS" >>"$INFO_FILE"
echo "* FTP Host                   : 139.162.44.151" >>"$INFO_FILE"
echo "* FTP Port                   : 21" >>"$INFO_FILE"
echo "* Public_html                : $WEB_ROOT" >>"$INFO_FILE"
echo "* User dang nhap wp-admin    : admin" >>"$INFO_FILE"
echo "* Mat khau dang nhap wp-admin: $ADMIN_PASSWORD" >>"$INFO_FILE"
echo "---------------------------------------------------------------" >>"$INFO_FILE" || {
    echo "ERROR: Failed to write to $INFO_FILE"
    exit 134
}

# ==========================
#      PRINT JSON OUTPUT
# ==========================
cat <<EOF >"$JSON_OUTPUT" || {
    echo "ERROR: Failed to create $JSON_OUTPUT"
    exit 135
}
{
  "domain": "$DOMAIN",
  "username": "$USER",
  "db_name": "$DB_NAME",
  "db_user": "$DB_USER",
  "db_password": "$DB_PASS",
  "public_html": "$WEB_ROOT",
  "php_version": "$PHP_VERSION",
  "ftp_user": "$USER",
  "ftp_password": "$FTP_PASS",
  "admin_username": "admin",
  "admin_password": "$ADMIN_PASSWORD"
}
EOF

exit 0