#!/bin/bash

DOMAIN="$1"
INPUT_IMAGE="/binhchay/images/logo.png"
OUTPUT_IMAGE="/binhchay/images/sspaps-1.png"
TEXT_SIZE=40
X_POS=350
Y_POS=600
TEXT_WIDTH=$(convert -font Arial-Bold -pointsize $TEXT_SIZE label:"$DOMAIN" \
    -format "%w" info:)

# ==========================
#      UPDATE LOGO AND INSERT LOGO
# ==========================

convert "$INPUT_IMAGE" \
    -region 500x500 -blur 0x8 \
    "temp.png"

if [[ -z "$TEXT_WIDTH" ]]; then
    echo "Lỗi: Không thể lấy chiều rộng chữ. Dùng giá trị mặc định là 200."
    TEXT_WIDTH=200
fi

convert "temp.png" -font Arial-Bold -pointsize $TEXT_SIZE -fill black \
    -annotate +$X_POS+$Y_POS "$DOMAIN" \
    -fill black -stroke black -strokewidth 3 \
    -draw "line $X_POS,$((Y_POS + 5)) $((X_POS + TEXT_WIDTH)),$((Y_POS + 5))" \
    "$OUTPUT_IMAGE"

rm temp.png

echo "Ảnh đã được chỉnh sửa thành công và lưu tại $OUTPUT_IMAGE"