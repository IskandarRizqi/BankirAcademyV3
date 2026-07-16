(function () {
    'use strict';

    const navLeft = '<svg width="23" height="19" viewBox="0 0 23 19" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M8.3125 0.625244L0.499998 8.43778V10.6253L8.3125 18.4378L10.5313 16.2503L5.40625 11.094H22.8125V7.96903H5.40625L10.5625 2.81275L8.3125 0.625244Z" fill="currentColor"/></svg>';
    const navRight = '<svg width="23" height="18" viewBox="0 0 23 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.1875 17.8125L23 9.99996V7.81245L15.1875 -8.7738e-05L12.9687 2.18742L18.0937 7.3437H0.6875L0.6875 10.4687H18.0937L12.9375 15.625L15.1875 17.8125Z" fill="currentColor"/></svg>';

    function isRtl() {
        return $('html').attr('dir') === 'rtl';
    }

    function sliderTimeout() {
        return Number($('#slider_transition_time').val() || 5) * 1000;
    }

    function initCarousel(selector, options) {
        const $carousel = $(selector);

        if (!$carousel.length || !$carousel.children().length || typeof $carousel.owlCarousel !== 'function') {
            return;
        }

        $carousel.owlCarousel(options);
    }

    function updateHeaderHeight() {
        let headerHeight = $('.heading').outerHeight();

        if ($(window).width() > 991 && $(window).width() < 1200) {
            headerHeight -= 30;
        }

        document.documentElement.style.setProperty('--header-height', `${headerHeight}px`);
    }

    function setCookies(type = 0) {
        $('.theme_cookies').hide(500);
        const d = new Date();
        const items = type === 1 ? $('.cookie_type') : $('.cookie_type:checked');

        items.each(function () {
            document.cookie = $(this).val() + '_allow=1; expires=Thu, 21 Dec ' + (d.getFullYear() + 1) + ' 12:00:00 UTC';
        });

        document.cookie = 'allow=1; expires=Thu, 21 Dec ' + (d.getFullYear() + 1) + ' 12:00:00 UTC';
        $('#cookieSettingsModal').modal('hide');
    }

    function getCookie(cname) {
        const name = cname + '=';
        const ca = document.cookie.split(';');

        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];

            while (c.charAt(0) === ' ') {
                c = c.substring(1);
            }

            if (c.indexOf(name) === 0) {
                return c.substring(name.length, c.length);
            }
        }

        return '';
    }

    function checkCookie() {
        if (getCookie('allow') !== '') {
            $('.theme_cookies').hide();
            return;
        }

        $('.theme_cookies').show();
    }

    function displayCookieSettingDetails(element) {
        const cookieSettingElement = element.parentElement;
        const detailsElement = cookieSettingElement.parentElement.querySelector('.cookie-setting-details');

        detailsElement.classList.toggle('height-none');
    }

    function toggleAccordion(el) {
        const answer = el.nextElementSibling;
        const icon = el.querySelector('.accordion-icon');
        const isOpen = answer.style.display === 'block';

        answer.style.display = isOpen ? 'none' : 'block';
        icon.textContent = isOpen ? '+' : '-';
    }

    function initHeader() {
        $(document).on('click', '#showCateDrop', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $('#cateDropDown').fadeToggle('fast');
            $(this).find('i').toggleClass('ti-angle-down').toggleClass('ti-angle-up');
        });

        $(document).on('click', function (e) {
            if (!$(e.target).is('#cateDropDown *')) {
                $('#cateDropDown').fadeOut('fast');
                $('#showCateDrop').find('i').addClass('ti-angle-down').removeClass('ti-angle-up');
            }

            if ($('.mobile-search .heading-search-box').hasClass('mobile-visible') && !$(e.target).closest('.heading-search-box, #mobileSearchToggle').length) {
                $('.mobile-search .heading-search-box').removeClass('mobile-visible').hide('slow');
            }
        });

        $('.heading-category-dropdown ul li ul').hide();
        $('.heading-category-dropdown ul li').hover(
            function () {
                const parentOffset = $(this).offset();
                const parentWidth = $(this).outerWidth();
                const submenuWidth = $(this).find('ul').outerWidth();
                const scrollTop = $(window).scrollTop();
                const rtl = isRtl();
                const submenu = $(this).find('ul');

                submenu.css({
                    display: 'block',
                    top: parentOffset.top - scrollTop,
                    left: rtl ? parentOffset.left - submenuWidth : parentOffset.left + parentWidth,
                });

                if (rtl) {
                    const rightEdge = $(window).width() - (parentOffset.left - submenuWidth);

                    if (rightEdge < submenuWidth) {
                        submenu.css({
                            left: parentOffset.left + parentWidth,
                        });
                    }
                }
            },
            function () {
                const $submenu = $(this).find('ul');

                if ($submenu.length) {
                    $submenu.css({
                        display: 'none',
                        top: 0,
                        left: 0,
                    });
                }
            }
        );

        updateHeaderHeight();
        $(window).resize(function () {
            updateHeaderHeight();

            if (!($(window).width() >= 991 && $(window).width() <= 1200) && $(window).width() >= 767) {
                $('.mobile-search .heading-search-box').removeClass('mobile-visible').hide();
            }
        });

        $(document).on('click', '#mobileSearchToggle', function () {
            $('.mobile-search .heading-search-box').addClass('mobile-visible').fadeToggle('slow');
        });
    }

    function initSliders() {
        initCarousel('.category-slider', {
            loop: true,
            margin: 0,
            responsiveClass: true,
            nav: false,
            dots: false,
            autoplay: true,
            autoplayHoverPause: true,
            autoplayTimeout: sliderTimeout(),
            rtl: isRtl(),
            responsive: {
                300: { items: 2, nav: false },
                400: { items: 3, nav: false },
                500: { items: 4, nav: false },
                768: { items: 4, nav: false },
                1000: { items: 5, nav: false },
                1400: { items: 8, nav: false },
            },
        });

        initCarousel('.popular-course-carousel', {
            nav: true,
            navText: [navLeft, navRight],
            dots: true,
            items: 4,
            lazyLoad: true,
            autoplay: true,
            autoplayHoverPause: true,
            autoplayTimeout: sliderTimeout(),
            loop: true,
            margin: 24,
            stagePadding: 0,
            rtl: isRtl(),
            responsive: {
                0: { items: 1, nav: false },
                480: { items: 1, nav: false },
                768: { items: 2, nav: true },
                1200: { items: 3 },
                1400: { items: 4 },
            },
        });

        initCarousel('.clients-area-slider', {
            loop: false,
            margin: 40,
            nav: false,
            dots: false,
            autoplay: true,
            autoplayHoverPause: false,
            autoplayTimeout: sliderTimeout(),
            rtl: isRtl(),
            items: 50,
            autoWidth: true,
        });

        initCarousel('.testimonial-slider', {
            nav: true,
            navText: [navLeft, navRight],
            dots: true,
            items: 4,
            lazyLoad: true,
            autoplay: true,
            autoplayHoverPause: true,
            autoplayTimeout: sliderTimeout(),
            loop: true,
            margin: 24,
            stagePadding: 0,
            center: true,
            rtl: isRtl(),
            responsive: {
                0: { items: 1, nav: false },
                480: { items: 1, nav: false },
                768: { items: 2, nav: true },
                1200: { items: 3 },
            },
        });

        initCarousel('.team-slider', {
            nav: true,
            navText: [navLeft, navRight],
            dots: true,
            items: 4,
            lazyLoad: true,
            autoplay: true,
            autoplayHoverPause: true,
            autoplayTimeout: sliderTimeout(),
            loop: true,
            margin: 24,
            stagePadding: 0,
            rtl: isRtl(),
            responsive: {
                0: { items: 1, nav: false },
                480: { items: 1, nav: false },
                768: { items: 2, nav: true },
                1200: { items: 3 },
                1400: { items: 4 },
            },
        });
    }

    function initCart() {
        $('#cartView').on('click', '.remove_cart', function () {
            const id = $(this).data('id');
            const total = $('.notify_count').html();
            const url = 'https://infixlms.ischooll.com/home/removeItemAjax' + '/' + id;

            $(this).closest('.single_cart').hide();

            $.ajax({
                type: 'GET',
                url: url,
                success: function () {
                    let finalTotal = total - 1;

                    if (finalTotal < 0) {
                        finalTotal = 0;
                    }

                    $('.notify_count').html(finalTotal);
                },
            });
        });
    }

    function initPage() {
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('serviceworker.js', { scope: '.' })
                .then((r) => console.log('ServiceWorker registered:', r.scope))
                .catch((e) => console.log('ServiceWorker failed:', e));
        }

        if (window.WebFont) {
            WebFont.load({
                google: {
                    families: ['Source Sans Pro', 'Jost'],
                },
            });
        }

        initHeader();
        initSliders();
        initCart();
        checkCookie();

        $('#cookieSettingsModal').on('hidden.bs.modal', function () {
            $(this).attr('aria-hidden', 'true');
        });

        $(document).on('click', '.cookeSettingModalBtn', function () {
            $('#cookieSettingsModal').modal('show');
        });

        $(document).on('click', '.show_notify', function (e) {
            e.preventDefault();
            console.log('notify');
        });

        if (!$('#main-nav-for-chat').length) {
            $('#main-content').append('<div id="main-nav-for-chat" style="visibility: hidden;"></div>');
        }

        if (!$('#admin-visitor-area').length) {
            $('#main-content').append('<div id="admin-visitor-area" style="visibility: hidden;"></div>');
        }

        if ($.fn.Lazy) {
            $('.lazy').Lazy();
        }

        $('.ui-resizable-resizer').remove();
        $('.preloader').fadeOut('hide');
    }

    window.setCookies = setCookies;
    window.displayCookieSettingDetails = displayCookieSettingDetails;
    window.toggleAccordion = toggleAccordion;

    $(document).ready(initPage);
})();
