/**
 * Company : Spider Technologies Limited
 * File    : custom.js
 * Version : 2.0 (Audit Hardened & Modernized)
 **/

(function ($) {
    "use strict";

    /* ==========================================
       1. Sticky Header Backward Compatibility
    ========================================== */
    $(window).scroll(function () {
        var scroll = $(window).scrollTop();
        if (scroll >= 100) {
            $(".header").addClass("sticky");
        } else {
            $(".header").removeClass("sticky");
        }
    });

    /* ==========================================
       2. Parallax (Safe Guarded)
    ========================================== */
    $(document).ready(function () {
        if (typeof $.fn.parallax === 'function') {
            var parallaxSelectors = [
                '#counter', '#client', '#services-counter',
                '#member', '#work-status', '#portfolio', '#services'
            ];
            parallaxSelectors.forEach(function (sel) {
                var $elem = $(sel);
                if ($elem.length) {
                    $elem.parallax("50%", 0.1);
                }
            });
        }
    });

    /* ==========================================
       3. SmartMenus (Safe Guarded)
    ========================================== */
    $(document).ready(function () {
        var $mainMenu = $('#main-menu');
        if (typeof $.fn.smartmenus === 'function' && $mainMenu.length) {
            $mainMenu.smartmenus({
                mainMenuSubOffsetX: -1,
                mainMenuSubOffsetY: 4,
                subMenusSubOffsetX: 6,
                subMenusSubOffsetY: -6
            });

            var $mainMenuState = $('#main-menu-state');
            if ($mainMenuState.length) {
                $mainMenuState.on('change', function () {
                    if (this.checked) {
                        $mainMenu.hide().slideDown(250, function () {
                            $mainMenu.css('display', '');
                        });
                    } else {
                        $mainMenu.show().slideUp(250, function () {
                            $mainMenu.css('display', '');
                        });
                    }
                });

                $(window).on('beforeunload unload', function () {
                    if ($mainMenuState[0].checked) {
                        $mainMenuState[0].click();
                    }
                });
            }

            $mainMenu.on('click.smapi', function (e, item) {
                var obj = $(this).data('smartmenus');
                if (obj && typeof obj.isCollapsible === 'function' && obj.isCollapsible()) {
                    var $sub = $(item).dataSM ? $(item).dataSM('sub') : null;
                    if ($sub && $sub.is(':visible')) {
                        obj.menuHide($sub);
                        return false;
                    }
                }
            });
        }

        // Navigation menu mobile dropdown helper
        if ($(window).width() < 992) {
            $('.navbar .dropdown-item').on('click', function (e) {
                var $el = $(this).children('.dropdown-toggle');
                var $parent = $el.offsetParent ? $el.offsetParent(".dropdown-menu") : null;
                $(this).parent("li").toggleClass('open');

                if ($parent && $parent.length && !$parent.parent().hasClass('navbar-nav')) {
                    if ($parent.hasClass('show')) {
                        $parent.removeClass('show');
                        $el.next().removeClass('show');
                        $el.next().css({ "top": -999, "left": -999 });
                    } else {
                        $parent.parent().find('.show').removeClass('show');
                        $parent.addClass('show');
                        $el.next().addClass('show');
                        $el.next().css({
                            "top": $el[0] ? $el[0].offsetTop : 0,
                            "left": $parent.outerWidth() - 4
                        });
                    }
                    e.preventDefault();
                    e.stopPropagation();
                }
            });

            $('.navbar .dropdown').on('hidden.bs.dropdown', function () {
                $(this).find('li.dropdown').removeClass('show open');
                $(this).find('ul.dropdown-menu').removeClass('show open');
            });
        }
    });

    /* ==========================================
       4. CounterUp (Safe Guarded)
    ========================================== */
    $(document).ready(function () {
        if (typeof $.fn.counterUp === 'function' && $('.counter').length) {
            $('.counter').counterUp({
                delay: 10,
                time: 1000
            });
        }
    });

    /* ==========================================
       5. Portfolio & Isotope (Safe Guarded)
    ========================================== */
    $(document).ready(function () {
        if (typeof $.fn.isotope === 'function' && typeof $.fn.imagesLoaded === 'function') {
            var $portfolio = $('#portfolio');
            if ($portfolio.length) {
                $portfolio.imagesLoaded(function () {
                    var $gallery = $('.portfolio-gallary');
                    if ($gallery.length) {
                        $gallery.isotope({
                            itemSelector: '.port-item',
                            percentPosition: true,
                            masonry: { columnWidth: '.port-item' }
                        });

                        $('.portfolio-sort ul li').on("click", function () {
                            $('.portfolio-sort ul li').removeClass('active');
                            $(this).addClass('active');
                            var selector = $(this).attr('data-filter');
                            $gallery.isotope({ filter: selector });
                            return false;
                        });
                    }
                });
            }

            var $blogIsotope = $('.blog-isotope');
            if ($blogIsotope.length) {
                $blogIsotope.imagesLoaded(function () {
                    $blogIsotope.isotope({
                        itemSelector: '.blog-iso-item',
                        percentPosition: true,
                        masonry: { columnWidth: '.blog-iso-item' }
                    });
                });
            }
        }
    });

})(jQuery);
