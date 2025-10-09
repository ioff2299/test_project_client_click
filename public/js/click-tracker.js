(function () {
    if (!window.CLICKMAP_SITE_TOKEN) {
        console.warn('[Clickmap] Не указан токен сайта (window.CLICKMAP_SITE_TOKEN)');
        return;
    }

    const API_URL = window.CLICKMAP_API_URL;
    const SITE_TOKEN = window.CLICKMAP_SITE_TOKEN;
    const clickBuffer = [];
    let sent = false;
    function formatDateForMySQL(date) {
        const pad = (n) => n.toString().padStart(2, '0');
        return (
            date.getFullYear() + '-' +
            pad(date.getMonth() + 1) + '-' +
            pad(date.getDate()) + ' ' +
            pad(date.getHours()) + ':' +
            pad(date.getMinutes()) + ':' +
            pad(date.getSeconds())
        );
    }
    document.addEventListener('click', function (e) {
        const now = formatDateForMySQL(new Date());

        const clientX = e.clientX;
        const clientY = e.clientY;
        const scrollX = window.scrollX || window.pageXOffset;
        const scrollY = window.scrollY || window.pageYOffset;
        const absX = scrollX + clientX;
        const absY = scrollY + clientY;
        const docW = Math.max(
            document.body.scrollWidth,
            document.documentElement.scrollWidth,
            document.body.offsetWidth,
            document.documentElement.offsetWidth,
            document.documentElement.clientWidth
        );

        const docH = Math.max(
            document.body.scrollHeight,
            document.documentElement.scrollHeight,
            document.body.offsetHeight,
            document.documentElement.offsetHeight,
            document.documentElement.clientHeight
        );
        let target = e.target?.tagName?.toLowerCase() || '';
        if (e.target?.classList?.length) {
            target += '.' + Array.from(e.target.classList).join('.');
        }
        const clickData = {
            site_token: SITE_TOKEN,
            url: location.href,
            timestamp: now,
            page_x: absX,
            page_y: absY,
            pct_x: +(absX / docW).toFixed(5),
            pct_y: +(absY / docH).toFixed(5),
            target,
            user_agent: navigator.userAgent
        };

        clickBuffer.push(clickData);
    });

    async function sendClicksOnUnload() {
        if (sent || clickBuffer.length === 0) return;
        sent = true;

        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!csrf) {
            console.warn('[Clickmap] CSRF-токен не найден');
            return;
        }

        try {
            console.log(`[Clickmap] Отправка ${clickBuffer.length} кликов...`);
            await fetch(API_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf
                },
                body: JSON.stringify(clickBuffer),
                keepalive: true
            });
            clickBuffer.length = 0;
        } catch (err) {
            console.warn('[Clickmap] Ошибка при отправке кликов:', err);
        }
    }
    window.addEventListener('beforeunload', sendClicksOnUnload);
    console.log('[Clickmap] Трекер кликов запущен для токена:', SITE_TOKEN);
})();
