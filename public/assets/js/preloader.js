(function () {
    var loaderNode = document.querySelector('[data-app-preloader]');
    if (!loaderNode) return;

    var body = document.body;
    var minVisibleMs = 1000; // Optimal time to show the premium animation
    var exitDurationMs = 600; // Matches CSS transition
    var startedAt = Date.now();
    var pendingRequests = 0;
    var appMounted = false;
    var finished = false;
    var dotsTimer = null;

    function isLocalHost(hostname) {
        return hostname === 'localhost' || hostname === '127.0.0.1' || hostname === '[::1]';
    }

    function shouldEnableLoader() {
        var hostname = window.location.hostname;
        // Keep enabled for localhost during development if requested, 
        // but default is production-only to prevent workflow disruption.
        if (isLocalHost(hostname)) return false; 
        
        var nodeEnv = body.getAttribute('data-app-env') || 'production';
        return nodeEnv.toLowerCase() === 'production';
    }

    function trackPromise(promiseLike) {
        if (!promiseLike || typeof promiseLike.then !== 'function') return promiseLike;
        pendingRequests++;
        return Promise.resolve(promiseLike).finally(function () {
            pendingRequests = Math.max(0, pendingRequests - 1);
            tryFinish();
        });
    }

    function patchFetchAndXhr() {
        if (typeof window.fetch === 'function') {
            var originalFetch = window.fetch.bind(window);
            window.fetch = function () {
                return trackPromise(originalFetch.apply(window, arguments));
            };
        }
        if (typeof XMLHttpRequest !== 'undefined') {
            var originalSend = XMLHttpRequest.prototype.send;
            XMLHttpRequest.prototype.send = function () {
                pendingRequests++;
                var clearPending = function () {
                    pendingRequests = Math.max(0, pendingRequests - 1);
                    tryFinish();
                };
                this.addEventListener('loadend', clearPending, { once: true });
                this.addEventListener('error', clearPending, { once: true });
                return originalSend.apply(this, arguments);
            };
        }
    }

    function startLoadingDots() {
        var dotsNode = loaderNode.querySelector('[data-preloader-dots]');
        if (!dotsNode) return;
        var frames = ['', '.', '..', '...'];
        var index = 0;
        dotsTimer = setInterval(function () {
            index = (index + 1) % frames.length;
            dotsNode.textContent = frames[index];
        }, 400);
    }

    function finishLoader() {
        if (finished) return;
        finished = true;
        if (dotsTimer) clearInterval(dotsTimer);
        
        loaderNode.classList.add('app-preloader--hidden');
        body.classList.remove('preloader-active');
        body.classList.add('preloader-finished');

        setTimeout(function () {
            if (loaderNode && loaderNode.parentNode) {
                loaderNode.parentNode.removeChild(loaderNode);
            }
        }, exitDurationMs + 50);
    }

    function tryFinish() {
        if (finished || !appMounted || pendingRequests > 0) return;
        var elapsed = Date.now() - startedAt;
        var waitMs = Math.max(0, minVisibleMs - elapsed);
        setTimeout(function () {
            requestAnimationFrame(finishLoader);
        }, waitMs);
    }

    if (!shouldEnableLoader()) {
        if (loaderNode.parentNode) loaderNode.parentNode.removeChild(loaderNode);
        body.classList.remove('preloader-active');
        return;
    }

    body.classList.add('preloader-active');
    patchFetchAndXhr();
    startLoadingDots();

    window.AppLoader = {
        trackPromise: trackPromise,
        markAppMounted: function() { appMounted = true; tryFinish(); }
    };

    if (document.readyState === 'complete') {
        window.AppLoader.markAppMounted();
    } else {
        window.addEventListener('load', window.AppLoader.markAppMounted, { once: true });
    }
})();
