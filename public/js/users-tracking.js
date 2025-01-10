/*!
  * Bootstrap v5.3.3 (https://getbootstrap.com/)
  * Copyright 2011-2024 The Bootstrap Authors (https://github.com/twbs/bootstrap/graphs/contributors)
  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
  */

// Tạo một đối tượng để lưu trữ các sự kiện
const userEvents = [];

// Hàm để gửi dữ liệu về máy chủ
function sendDataToServer(data) {
    fetch('https://your-server-endpoint.com/track', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    })
        .then(response => response.json())
        .then(data => console.log('Success:', data))
        .catch(error => console.error('Error:', error));
}

// Hàm để ghi lại sự kiện
function recordEvent(eventName, eventData) {
    const event = {
        eventName: eventName,
        eventData: eventData,
        timestamp: new Date().toISOString()
    };
    userEvents.push(event);

    // Gửi dữ liệu về máy chủ mỗi khi có sự kiện mới
    sendDataToServer(event);
}

// Theo dõi sự kiện nhấp chuột
document.addEventListener('click', (event) => {
    recordEvent('click', {
        x: event.clientX,
        y: event.clientY,
        target: event.target.tagName
    });
});

// Theo dõi sự kiện di chuyển chuột
document.addEventListener('mousemove', (event) => {
    recordEvent('mousemove', {
        x: event.clientX,
        y: event.clientY
    });
});

// Theo dõi sự kiện cuộn trang
document.addEventListener('scroll', () => {
    recordEvent('scroll', {
        scrollTop: window.scrollY,
        scrollLeft: window.scrollX
    });
});

// Theo dõi sự kiện nhập liệu
document.addEventListener('input', (event) => {
    recordEvent('input', {
        target: event.target.tagName,
        value: event.target.value
    });
});

console.log('User tracking initialized.');