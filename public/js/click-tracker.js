(function () {
    if (!window.CLICKMAP_SITE_TOKEN) {
        console.warn('[Clickmap] Не указан токен сайта (window.CLICKMAP_SITE_TOKEN)');
        return;
    }

    const API_URL = window.CLICKMAP_API_URL;
    const SITE_TOKEN = window.CLICKMAP_SITE_TOKEN;

    function formatDateForMySQL(date) {
        const pad = (n) => n.toString().padStart(2, '0');
        return date.getFullYear() + '-' +
            pad(date.getMonth() + 1) + '-' +
            pad(date.getDate()) + ' ' +
            pad(date.getHours()) + ':' +
            pad(date.getMinutes()) + ':' +
            pad(date.getSeconds());
    }

    function sendClick(data) {
        fetch(API_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        }).catch(() => {});
    }

    document.addEventListener('click', function (e) {
        const now = formatDateForMySQL(new Date());

        const pageX = e.pageX;
        const pageY = e.pageY;

        const docW = document.documentElement.scrollWidth;
        const docH = document.documentElement.scrollHeight;

        let target = '';
        if (e.target && e.target.tagName) {
            target = e.target.tagName.toLowerCase();
            if (e.target.className) {
                target += '.' + e.target.className.toString().replace(/\s+/g, '.');
            }
        }

        const payload = {
            site_token: SITE_TOKEN,
            url: location.href,
            timestamp: now,
            page_x: pageX,
            page_y: pageY,
            pct_x: +(pageX / docW).toFixed(5),
            pct_y: +(pageY / docH).toFixed(5),
            target: target,
            user_agent: navigator.userAgent
        };

        sendClick(payload);
    });

    console.log('[Clickmap] Трекер кликов запущен для токена:', SITE_TOKEN);
})();
