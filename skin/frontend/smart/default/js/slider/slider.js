/**
 * @module SM_Slider
 */
jQuery.noConflict();
var $j = jQuery.noConflict();
$j(document).ready(function () {

    $j(".slide-slider").slick({
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: true,
        dotsClass: 'slick-dots',
        arrows: true,
    });

});