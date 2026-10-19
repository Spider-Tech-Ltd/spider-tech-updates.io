/**
 * Owl Carousel Initialization Helper
 * Spider Technologies Limited
 */
$(document).ready(function() {
    if (typeof $.fn.owlCarousel !== 'function') return;

    if ($('.owl-one').length) {
        $('.owl-one').owlCarousel({
            loop: true, 
            margin: 27,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: false,
            responsive: {
                0: { items: 1 },
                480: { items: 1 },
                640: { items: 2 },
                990: { items: 3 },
                1140: { items: 3 }
            }
        });
    }

    if ($('.owl-two').length) {
        $('.owl-two').owlCarousel({
            loop: true,
            margin: 30,
            responsive: {
                0: { items: 1 },
                480: { items: 1 },
                640: { items: 2 },
                800: { items: 3 },
                1140: { items: 3 }
            }
        });
    }

    if ($('.owl-three').length) {
        $('.owl-three').owlCarousel({
            loop: true,
            margin: 20,
            responsive: {
                0: { items: 1 },
                400: { items: 2 },
                640: { items: 4 },
                800: { items: 5 },
                1000: { items: 6 }
            }
        });
    }

    if ($('.owl-four').length) {
        $('.owl-four').owlCarousel({
            loop: true,
            margin: 28,
            responsive: {
                0: { items: 1 },
                480: { items: 1 },
                640: { items: 1 },
                768: { items: 2 },
                990: { items: 2 },
                1140: { items: 2 }
            }
        });
    }

    if ($('.owl-five').length) {
        $('.owl-five').owlCarousel({
            loop: true,
            margin: 30,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: false,
            responsive: {
                0: { items: 1 },
                480: { items: 1 },
                640: { items: 2 },
                768: { items: 2 },
                1140: { items: 3 }
            }
        });
    }

    if ($('.owl-six').length) {
        $('.owl-six').owlCarousel({
            loop: true,
            margin: 20,
            responsive: {
                0: { items: 1 },
                400: { items: 2 },
                640: { items: 4 },
                800: { items: 4 },
                1000: { items: 5 }
            }
        });
    }

    if ($('.owl-seven').length) {
        $('.owl-seven').owlCarousel({
            loop: true,
            margin: 0,
            autoplay: true,
            autoplayTimeout: 3500,
            autoplayHoverPause: false,
            responsive: {
                320: { items: 1 },
                1000: { items: 1 }
            }
        });
    }

    if ($('.owl-eight').length) {
        $('.owl-eight').owlCarousel({
            loop: true,
            margin: 0,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: false,
            responsive: {
                0: { items: 1 },
                480: { items: 1 },
                640: { items: 1 },
                768: { items: 2 },
                1140: { items: 2 }
            }
        });
    }
});