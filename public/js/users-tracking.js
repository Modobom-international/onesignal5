/*!
  * This is users tracking behavior script
  * Copyright 2025 Modobom
  * Licensed under MIT
  */

!function (e) {
    "use strict";

    const userEvents = [];
    const throttleDelay = 1000;
    const userUUID = getUserUUID();

    var mouseMovements = 0;
    var keyPresses = 0;
    var lastInteractionTime = Date.now();
    var userStartTime = new Date().getTime();
    var throttleTimeout = null;
    var heatmapData = {};

    document.addEventListener('click', throttle((event) => {
        const target = event.target;
        let eventData = {
            x: event.clientX,
            y: event.clientY,
            target: target.tagName,
            href: '',
            isInternalLink: false,
            isLassoButton: false,
            lassoButtonLink: ''
        };

        if (target.tagName === 'A' && target.href.includes(window.location.hostname)) {
            eventData.href = target.href;
            eventData.isInternalLink = true;
            recordEvent('internal_link_click', eventData);
        } else if (target.tagName === 'A' && target.classList.contains('lasso-button')) {
            eventData.href = target.href;
            eventData.isLassoButton = true;
            recordEvent('lasso_button_click', eventData);
        } else {
            recordEvent('click', eventData);
        }
    }, throttleDelay));

    document.addEventListener('mousemove', throttle((event) => {
        const x = event.clientX;
        const y = event.clientY;
        const key = `${x},${y}`;

        if (!heatmapData[key]) {
            heatmapData[key] = 0;
        }

        heatmapData[key]++;
        mouseMovements++;

        recordEvent('mousemove', { x, y, mouseMovements });
    }, throttleDelay));

    document.addEventListener('scroll', throttle(() => {
        const scrollTop = window.scrollY;
        const scrollLeft = window.scrollX;

        recordEvent('scroll', { scrollTop, scrollLeft });
    }, throttleDelay));

    document.addEventListener('input', (event) => {
        recordEvent('input', {
            target: event.target.tagName,
            value: event.target.value
        });
    }, throttleDelay);

    document.addEventListener('keydown', throttle((event) => {
        recordEvent('keydown', {
            target: event.target.tagName,
            value: event.target.value
        });
        keyPresses++;
    }, throttleDelay));

    window.addEventListener('resize', function () {
        recordEvent('resize', {
            width: window.innerWidth,
            height: window.innerHeight,
        });
    }, throttleDelay);

    window.addEventListener('beforeunload', function () {
        let userEndTime = new Date().getTime();
        let userTotalTime = userEndTime - userStartTime;

        recordEvent('beforeunload', {
            start: userStartTime,
            end: userEndTime,
            total: userTotalTime,
            heatmapData: heatmapData,
        });
    }, throttleDelay);

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
            mode: 'no-cors',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify(data),
        }).catch(error => console.error('Error:', error));
    }

    function recordEvent(eventName, eventData) {
        const event = {
            eventName: eventName,
            eventData: eventData,
            timestamp: new Date().toISOString(),
            user: getUserInfo(),
            domain: window.location.hostname,
            uuid: userUUID
        };
        userEvents.push(event);
        if (!isBot()) {
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

    function throttle(func, delay) {
        return function (...args) {
            if (!throttleTimeout) {
                throttleTimeout = setTimeout(() => {
                    func(...args);
                    throttleTimeout = null;
                }, delay);
            }
        };
    }

    function generateUUID() {
        const template = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx';
        return template.replace(/[xy]/g, function (c) {
            const r = Math.random() * 16 | 0;
            const v = c === 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
    }

    function getUserUUID() {
        let uuid = localStorage.getItem('userUUID');
        if (!uuid) {
            uuid = generateUUID();
            localStorage.setItem('userUUID', uuid);
        }
        return uuid;
    }
}(this);

