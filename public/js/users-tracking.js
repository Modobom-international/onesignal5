/*!
  * This is users tracking behavior script
  * Copyright 2025 Modobom
  * Licensed under MIT
  */

const userEvents = [];
var isBot = false;
var mouseMovements = 0;
var keyPresses = 0;
var lastInteractionTime = Date.now();
var userStartTime = new Date().getTime();

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

    mouseMovements++;
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

document.addEventListener('keydown', (event) => {
    recordEvent('keydown', {
        target: event.target.tagName,
        value: event.target.value
    });
    keyPresses++;
});

window.addEventListener('resize', function () {
    recordEvent('resize', {
        width: window.innerWidth,
        height: window.innerHeight,
    });
});

window.addEventListener('beforeunload', function () {
    let userEndTime = new Date().getTime();
    let userTotalTime = userEndTime - userStartTime;

    recordEvent('beforeunload', {
        start: userStartTime,
        end: userEndTime,
        total: userTotalTime,
    });
});

function getUserInfo() {
    const userInfo = {
        userAgent: navigator.userAgent,
        platform: navigator.platform,
        language: navigator.language,
        cookiesEnabled: navigator.cookieEnabled,
        screenWidth: window.screen.width,
        screenHeight: window.screen.height,
        timezone: Intl.DateTimeFormat().resolvedOptions().timeZone
    };

    return userInfo;
}

function isBot() {
    const currentTime = Date.now();
    const timeSinceLastInteraction = currentTime - lastInteractionTime;
    const userAgent = navigator.userAgent.toLowerCase();
    const botPatterns = [
        /bot/i,
        /spider/i,
        /crawler/i,
        /slurp/i,
        /googlebot/i,
        /bingbot/i,
        /yandexbot/i,
        /duckduckbot/i,
        /baiduspider/i,
        /facebot/i,
        /ia_archiver/i
    ];

    for (const pattern of botPatterns) {
        if (pattern.test(userAgent)) {
            return true;
        }
    }

    if (timeSinceLastInteraction < 100) {
        return true;
    }

    lastInteractionTime = currentTime;
    return false;
}

function sendDataToServer(data) {
    let url = checkURL();
    fetch(url, {
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
        timestamp: new Date().toISOString(),
        user: getUserInfo(),
        domain: window.location.hostname
    };
    userEvents.push(event);
    isBot = isBot();
    if (!isBot) {
        sendDataToServer(event);
    }
}

function checkURL() {
    const hostname = window.location.hostname;
    let url = '';
    if (hostname === 'localhost' || hostname === '127.0.0.1') {
        url = 'http://127.0.0.1:8000/api';
    } else {
        url = 'https://apkhype.com/api';
    }

    url += '/users-tracking';

    return url;
}