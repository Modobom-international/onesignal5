#!/bin/bash

# ==========================
#      CONFIG VARIABLES
# ==========================

DOMAIN=$1
USER_NAME=$2
DB_NAME=$3
DB_USER=$4

if [[ -z "$DOMAIN" || -z "$USER_NAME" || -z "$DB_NAME" || -z "$DB_USER" ]]; then
    echo "Cách sử dụng: bash delete_site.sh DOMAIN USER_NAME DB_NAME DB_USER"
    exit 1
fi

# ==========================
#      DELETE USER FTP
# ==========================
if id "$USER_NAME" &>/dev/null; then
    userdel -r "$USER_NAME"
    echo "Đã xóa user $USER_NAME và thư mục home của họ."
else
    echo "User $USER_NAME không tồn tại."
fi

# ==========================
#      DELETE DATABASE
# ==========================
if mysql -e "SHOW DATABASES LIKE '$DB_NAME'" | grep "$DB_NAME" >/dev/null; then
    mysql -e "DROP DATABASE $DB_NAME;"
    echo "Đã xóa database $DB_NAME."
else
    echo "Database $DB_NAME không tồn tại."
fi

# ==========================
#      DELETE USER DATABASE
# ==========================
if mysql -e "SELECT User FROM mysql.user WHERE User='$DB_USER'" | grep "$DB_USER" >/dev/null; then
    mysql -e "DROP USER '$DB_USER'@'localhost';"
    echo "Đã xóa database user $DB_USER."
else
    echo "Database user $DB_USER không tồn tại."
fi

# ==========================
#      DELETE PHP-FPM CONFIG
# ==========================
PHP_FPM_FILE="/etc/php-fpm.d/$DOMAIN.conf"
if [ -f "$PHP_FPM_FILE" ]; then
    rm -rf "$PHP_FPM_FILE"
    echo "Đã xóa file $PHP_FPM_FILE."
else
    echo "File $PHP_FPM_FILE không tồn tại."
fi

# ==========================
#      DELETE NGINX CONFIG
# ==========================
NGINX_FILE="/etc/nginx/conf.d/$DOMAIN.conf"
if [ -f "$NGINX_FILE" ]; then
    rm -rf "$NGINX_FILE"
    echo "Đã xóa file $NGINX_FILE."
else
    echo "File $NGINX_FILE không tồn tại."
fi

# ==========================
#      DELETE NGINX CONFIG
# ==========================
PUBLIC_ROOT="/home/$DOMAIN"
if [ -f "$PUBLIC_ROOT" ]; then
    rm -rf "$PUBLIC_ROOT"
    echo "Đã xóa file $PUBLIC_ROOT."
else
    echo "Thư mục $PUBLIC_ROOT không tồn tại."
fi

service nginx restart
service php-fpm restart

echo "Hoàn tất quá trình xóa."
exit 0
