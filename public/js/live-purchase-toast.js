(function () {
    'use strict';

    var settings = window.bankirLivePurchaseToast;
    var toast = document.getElementById('live-purchase-toast');

    if (!settings || !settings.enabled || !toast) {
        return;
    }

    var message = toast.querySelector('[data-toast-message]');
    var title = toast.querySelector('[data-toast-title]');
    var customer = toast.querySelector('[data-toast-customer]');
    var context = toast.querySelector('[data-toast-context]');
    var product = toast.querySelector('[data-toast-product]');
    var time = toast.querySelector('[data-toast-time]');
    var closeButton = toast.querySelector('[data-toast-close]');
    var requestTimer = null;
    var hideTimer = null;
    var requestInFlight = false;

    function hideToast() {
        toast.classList.remove('is-visible');
        toast.setAttribute('aria-hidden', 'true');

        window.setTimeout(function () {
            if (!toast.classList.contains('is-visible')) {
                toast.hidden = true;
            }
        }, 240);
    }

    function showToast(data) {
        if (!data || !data.name || !data.city || !data.type || !data.product_name) {
            return;
        }

        var isJobApplication = data.type === 'loker';

        title.textContent = data.title || (isJobApplication ? 'Lowongan Dilamar' : 'Pembelian terbaru');
        customer.textContent = data.name;
        context.textContent = isJobApplication
            ? ' dari ' + data.city + ' melamar lowongan '
            : ' dari ' + data.city + ' membeli ' + data.type + ' ';
        product.textContent = data.product_name;
        time.textContent = data.time_ago || '5 menit yang lalu';
        message.setAttribute('aria-label', data.message || (
            isJobApplication
                ? data.name + ' dari ' + data.city + ' melamar lowongan ' + data.product_name
                : data.name + ' dari ' + data.city + ' membeli ' + data.type + ' ' + data.product_name
        ));
        toast.hidden = false;
        toast.setAttribute('aria-hidden', 'false');

        window.requestAnimationFrame(function () {
            toast.classList.add('is-visible');
        });

        window.clearTimeout(hideTimer);
        hideTimer = window.setTimeout(hideToast, Math.max(1, settings.displaySeconds) * 1000);
    }

    function scheduleRequest(seconds) {
        window.clearTimeout(requestTimer);

        if (seconds === null || seconds === undefined || Number.isNaN(Number(seconds))) {
            return;
        }

        requestTimer = window.setTimeout(requestToast, Math.max(1, Number(seconds)) * 1000);
    }

    function requestToast() {
        if (requestInFlight) {
            return;
        }

        requestInFlight = true;

        fetch(settings.endpoint, {
            method: 'GET',
            credentials: 'same-origin',
            cache: 'no-store',
            headers: {
                Accept: 'application/json',
            },
        })
            .then(function (response) {
                if (!response.ok) {
                    throw new Error('Live purchase toast request failed.');
                }

                return response.json();
            })
            .then(function (payload) {
                if (payload.success && payload.data) {
                    showToast(payload.data);
                }

                scheduleRequest(payload.retry_after);
            })
            .catch(function () {
                scheduleRequest(settings.retrySeconds);
            })
            .finally(function () {
                requestInFlight = false;
            });
    }

    closeButton.addEventListener('click', hideToast);

    document.addEventListener('DOMContentLoaded', requestToast);
})();
