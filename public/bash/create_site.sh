#!/bin/bash

# ==========================
#      CONFIG VARIABLES
# ==========================
DOMAIN="$1"
PHP_VERSION="7.4"

USER=${DOMAIN//[-._]/}
USER=$(echo "$USER" | cut -c 1-7)
USER="${USER}$(perl -le "print map+(A..Z,a..z,0-9)[rand 62],0..3")"

DB_NAME="wp_${USER}"
DB_USER="db_${USER}"
DB_PASS=$(openssl rand -base64 12)

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
if ! id "$USER" &>/dev/null; then
    useradd --shell /bin/false "$USER"
fi
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
wp core install --url="https://$DOMAIN" --title="My Site" --admin_user="admin" --admin_password="AdminPass123!" --admin_email="binhchay.modobom@gmail.com" --allow-root
chown -R "$USER:$USER" "$WEB_ROOT"

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

echo "SUCCESS"
exit 0
