/*!
  * This is users tracking behavior script
  * Copyright 2025 Modobom
  * Licensed under MIT
  */

(function () {
    "use strict";
    const userUUID = getUserUUID();
    const isMobile = window.innerWidth <= 768;

    let mouseMovements = 0;
    let keyPresses = 0;
    let lastInteractionTime = getCurrentTimeInGMT7();
    let userStartTime = getCurrentTimeInGMT7();
    let totalTimeOnsite = 0;
    let startTime = getCurrentTimeInGMT7();

    function updateTimeOnsite() {
        const currentTime = getCurrentTimeInGMT7();
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
            x: event.pageX,
            y: event.pageY,
            target: target.tagName,
            href: target.href || '',
            isInternalLink: target.href && target.href.includes(window.location.origin),
            isLassoButton: target.classList.contains('lasso-button'),
            lassoButtonLink: target.dataset.lassoLink || '',
            device: isMobile ? 'mobile' : 'desktop'
        };

        if (target.tagName === 'A' && target.href.includes(window.location.hostname)) {
            eventData.href = target.href;
            eventData.isInternalLink = true;
            recordEvent('internal_link_click', eventData);
        } else if (target.tagName === 'A' && target.classList.contains('lasso-button')) {
            eventData.href = target.href;
            eventData.isLassoButton = true;
            eventData.lassoButtonLink = true;
            recordEvent('lasso_button_click', eventData);
        } else {
            recordEvent('click', eventData);
        }
    });

    document.addEventListener('mousemove', (event) => {
        const x = event.pageX;
        const y = event.pageY;
        const device = isMobile ? 'mobile' : 'desktop';
        mouseMovements++;

        recordEvent('mousemove', { x, y, mouseMovements, device });
    });

    document.addEventListener('scroll', () => {
        const scrollTop = window.scrollY;
        const scrollLeft = window.scrollX;
        const device = isMobile ? 'mobile' : 'desktop';

        recordEvent('scroll', { scrollTop, scrollLeft, device });
    });

    document.addEventListener('input', (event) => {
        recordEvent('input', {
            target: event.target.tagName,
            value: event.target.value,
            device: isMobile ? 'mobile' : 'desktop'
        });
    });

    document.addEventListener('keydown', (event) => {
        recordEvent('keydown', {
            target: event.target.tagName,
            value: event.target.value,
            device: isMobile ? 'mobile' : 'desktop'
        });
        keyPresses++;
    });

    window.addEventListener('resize', function () {
        recordEvent('resize', {
            width: window.innerWidth,
            height: window.innerHeight,
            device: isMobile ? 'mobile' : 'desktop'
        });
    });

    window.addEventListener('beforeunload', function () {
        let userEndTime = getCurrentTimeInGMT7();
        updateTimeOnsite();

        recordEvent('beforeunload', {
            start: userStartTime,
            end: userEndTime,
            total: totalTimeOnsite,
            device: isMobile ? 'mobile' : 'desktop'
        });
    });

    window.addEventListener('message', function (event) {
        if (event.data === 'getHeight') {
            var height = document.body.scrollHeight;
            event.source.postMessage(height, event.origin);
        }
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
        const currentTime = getCurrentTimeInGMT7();
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
        const timestamp = formatDate();
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

    function formatDate() {
        const now = new Date();
        const utcTime = now.getTime() + (now.getTimezoneOffset() * 60000);
        const gmt7Time = new Date(utcTime + (7 * 60 * 60 * 1000));
        const year = gmt7Time.getFullYear();
        const month = String(gmt7Time.getMonth() + 1).padStart(2, '0');
        const day = String(gmt7Time.getDate()).padStart(2, '0');
        const hours = String(gmt7Time.getHours()).padStart(2, '0');
        const minutes = String(gmt7Time.getMinutes()).padStart(2, '0');
        const seconds = String(gmt7Time.getSeconds()).padStart(2, '0');
        return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    }

    function getCurrentTimeInGMT7() {
        const now = new Date();
        const utcTime = now.getTime() + (now.getTimezoneOffset() * 6000);
        const gmt7Time = new Date(utcTime + (7 * 60 * 60 * 1000));
        return gmt7Time.getTime();
    }
})();

