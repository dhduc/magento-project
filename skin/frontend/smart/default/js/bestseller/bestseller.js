/**
 * @module SM_Bestseller
 */
jQuery.noConflict();
var $j = jQuery.noConflict();
$j(document).ready(function () {
    if ($j(".bestseller-slider").width() < 800) {
        $j(".bestseller-slider").slick({
            lazyload: 'ondemand',
            infinite: true,
            slidesToShow: 2,
            slidesToScroll: 2,
            dots: true,
            dotsClass: 'slick-dots',
            arrows: true,
            responsive: [
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    } else {
        $j(".bestseller-slider").slick({
            lazyload: 'ondemand',
            infinite: true,
            slidesToShow: 4,
            slidesToScroll: 2,
            dots: true,
            dotsClass: 'slick-dots',
            arrows: true,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 900,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 800,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    }
});