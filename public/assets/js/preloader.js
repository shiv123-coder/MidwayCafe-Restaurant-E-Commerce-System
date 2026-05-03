(function () {
    var loaderNode = document.querySelector('[data-app-preloader]');
    if (!loaderNode) {
        return;
    }

    var root = document.documentElement;
    var body = document.body;
    var minVisibleMs = 300;
    var exitDurationMs = 520;
    var startedAt = Date.now();
    var pendingRequests = 0;
    var appMounted = false;
    var finished = false;
    var dotsTimer = null;

    function parseImportMetaProd() {
        try {
            return Boolean(Function('return import.meta && import.meta.env && import.meta.env.PROD')());
        } catch (error) {
            return undefined;
        }
    }

    function parseNodeEnv() {
        var nodeEnv =
            (typeof process !== 'undefined' && process && process.env && process.env.NODE_ENV) ||
            body.getAttribute('data-app-env') ||
            '';
        return String(nodeEnv).toLowerCase();
    }

    function isLocalHost(hostname) {
        return hostname === 'localhost' || hostname === '127.0.0.1' || hostname === '[::1]';
    }

    function shouldEnableLoader() {
        var hostname = window.location.hostname;
        if (isLocalHost(hostname)) {
            return false;
        }

        var nodeEnv = parseNodeEnv();
        var importMetaProd = parseImportMetaProd();
        var explicitProd = nodeEnv === 'production' || importMetaProd === true;

        if (nodeEnv === 'development' || importMetaProd === false) {
            return false;
        }

        return explicitProd;
    }

    function trackPromise(promiseLike) {
        if (!promiseLike || typeof promiseLike.then !== 'function') {
            return promiseLike;
        }

        pendingRequests += 1;

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
            var originalOpen = XMLHttpRequest.prototype.open;
            var originalSend = XMLHttpRequest.prototype.send;

            XMLHttpRequest.prototype.open = function () {
                this.__loaderTracked = false;
                return originalOpen.apply(this, arguments);
            };

            XMLHttpRequest.prototype.send = function () {
                if (!this.__loaderTracked) {
                    this.__loaderTracked = true;
                    pendingRequests += 1;

                    var clearPending = function () {
                        pendingRequests = Math.max(0, pendingRequests - 1);
                        tryFinish();
                    };

                    this.addEventListener('loadend', clearPending, { once: true });
                    this.addEventListener('error', clearPending, { once: true });
                    this.addEventListener('abort', clearPending, { once: true });
                    this.addEventListener('timeout', clearPending, { once: true });
                }

                return originalSend.apply(this, arguments);
            };
        }
    }

    function startLoadingDots() {
        var dotsNode = loaderNode.querySelector('[data-preloader-dots]');
        if (!dotsNode) {
            return;
        }

        var frames = ['', '.', '..', '...'];
        var index = 0;
        dotsNode.textContent = frames[index];
        dotsTimer = window.setInterval(function () {
            index = (index + 1) % frames.length;
            dotsNode.textContent = frames[index];
        }, 420);
    }

    function stopLoadingDots() {
        if (dotsTimer) {
            window.clearInterval(dotsTimer);
            dotsTimer = null;
        }
    }

    function finishLoader() {
        if (finished) {
            return;
        }

        finished = true;
        stopLoadingDots();
        loaderNode.classList.add('app-preloader--hidden');
        body.classList.remove('preloader-active');
        body.classList.add('preloader-finished');

        window.setTimeout(function () {
            if (loaderNode && loaderNode.parentNode) {
                loaderNode.parentNode.removeChild(loaderNode);
            }
        }, exitDurationMs + 40);
    }

    function tryFinish() {
        if (finished || !appMounted || pendingRequests > 0) {
            return;
        }

        var elapsed = Date.now() - startedAt;
        var waitMs = Math.max(0, minVisibleMs - elapsed);

        window.setTimeout(function () {
            requestAnimationFrame(function () {
                finishLoader();
            });
        }, waitMs);
    }

    function setAppMounted() {
        appMounted = true;
        tryFinish();
    }

    if (!shouldEnableLoader()) {
        loaderNode.parentNode.removeChild(loaderNode);
        body.classList.remove('preloader-active');
        body.classList.add('preloader-finished');
        return;
    }

    body.classList.add('preloader-active');
    body.classList.remove('preloader-finished');

    var bodyChildren = body.children;
    for (var i = 0; i < bodyChildren.length; i += 1) {
        if (bodyChildren[i] !== loaderNode) {
            bodyChildren[i].classList.add('preloader-content-target');
        }
    }

    patchFetchAndXhr();
    startLoadingDots();

    window.AppLoader = window.AppLoader || {};
    window.AppLoader.trackPromise = trackPromise;
    window.AppLoader.markAppMounted = setAppMounted;
    window.AppLoader.getPending = function () { return pendingRequests; };

    if (document.readyState === 'complete') {
        setAppMounted();
    } else {
        window.addEventListener('load', setAppMounted, { once: true });
    }
})();
