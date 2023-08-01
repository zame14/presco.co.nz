jQuery(function($) {
    setTimeout(function () {
        $(".banner-content-wrapper").addClass('ani-show');
    }, 200);
    // home image grid
    // set container height to height of image
    var h = $(".quick-links-wrapper .img1 img").height();
    $(".quick-links-wrapper").css('height', h+'px');

    if($(document.width() >= 768)) {
        // create hover affect
        $(".quick-links-wrapper .inner-wrapper",this).hover(function() {
            $(this).toggleClass('slide-up');
        });
    }
    var waypoint = new Waypoint({
        element: document.getElementById('page-wrapper'),
        handler: function () {
            $("#presco-menu-wrapper").toggleClass('fixed');
        },
        offset: -100
    });
    gallerySlick = $(".gallery-images").slick({
        dots:false,
        speed: 300,
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        nextArrow: '<i class="fa fa-angle-right"></i>',
        prevArrow: '<i class="fa fa-angle-left"></i>',
        infinite: true,
        fade: true,
        cssEase: 'linear',
        adaptiveHeight: true
    });
});