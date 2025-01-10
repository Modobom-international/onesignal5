/*!
  * This is users tracking behavior script
  * Copyright 2025 Modobom
  * Licensed under MIT
  */

const userEvents = [];

function sendDataToServer(data) {
    fetch('https://apkhype.com/users-tracking', {
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

function recordEvent(eventName, eventData) {
    const event = {
        eventName: eventName,
        eventData: eventData,
        timestamp: new Date().toISOString()
    };
    userEvents.push(event);
    sendDataToServer(event);
}

document.addEventListener('click', (event) => {
    recordEvent('click', {
        x: event.clientX,
        y: event.clientY,
        target: event.target.tagName
    });
});

document.addEventListener('mousemove', (event) => {
    recordEvent('mousemove', {
        x: event.clientX,
        y: event.clientY
    });
});

document.addEventListener('scroll', () => {
    recordEvent('scroll', {
        scrollTop: window.scrollY,
        scrollLeft: window.scrollX
    });
});

document.addEventListener('input', (event) => {
    recordEvent('input', {
        target: event.target.tagName,
        value: event.target.value
    });
});