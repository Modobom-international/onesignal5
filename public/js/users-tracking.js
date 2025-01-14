/*!
  * This is users tracking behavior script
  * Copyright 2025 Modobom
  * Licensed under MIT
  */

!function (e) {
    "use strict";
    const userUUID = getUserUUID();

    var mouseMovements = 0;
    var keyPresses = 0;
    var lastInteractionTime = Date.now();
    var userStartTime = new Date().getTime();
    var totalTimeOnsite = 0;
    var startTime = Date.now();

    function updateTimeOnsite() {
        const currentTime = Date.now();
        totalTimeOnsite += currentTime - startTime;
        startTime = currentTime;
    }

    window.addEventListener('focus', () => {
        startTime = Date.now();
    });

    window.addEventListener('blur', () => {
        updateTimeOnsite();
    });

    document.addEventListener('click', (event) => {
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
    });

    document.addEventListener('mousemove', (event) => {
        const x = event.clientX;
        const y = event.clientY;
        mouseMovements++;

        recordEvent('mousemove', { x, y, mouseMovements });
    });

    document.addEventListener('scroll', () => {
        const scrollTop = window.scrollY;
        const scrollLeft = window.scrollX;

        recordEvent('scroll', { scrollTop, scrollLeft });
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
        updateTimeOnsite();

        recordEvent('beforeunload', {
            start: userStartTime,
            end: userEndTime,
            total: totalTimeOnsite,
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
        }).catch(error => console.error('Error:', error));
    }

    function recordEvent(eventName, eventData) {
        const path = window.location.pathname + window.location.search;
        const timestamp = formatDate(new Date());
        const event = {
            eventName: eventName,
            eventData: eventData,
            timestamp: timestamp,
            user: getUserInfo(),
            domain: window.location.hostname,
            uuid: userUUID,
            path: path
        };

        if (!isBot()) {
            sendDataToServer(event);
        }
    }

    function checkURL() {
        const hostname = window.location.hostname;
        let url = '';
        if (hostname === 'localhost' || hostname === '127.0.0.1') {
            url = 'http://127.0.0.1:8000';
        } else {
            url = 'https://apkhype.com';
        }

        url += '/create-users-tracking';

        return url;
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

    function formatDate(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        const seconds = String(date.getSeconds()).padStart(2, '0');
        return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    }
}(this);

