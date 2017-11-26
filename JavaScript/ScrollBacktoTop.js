$(document).ready(function(){
    var scrollTrigger = 1000, // px
        backToTop = function () {
            var scrollTop = $(window).scrollTop();
            if (scrollTop > scrollTrigger) {

                $('#back-to-top').addClass('show');
                $('#arrow-up').addClass('fa-arrow-up');
                $('#arrow-up').addClass('fa-lg');

            } else {
                $('#back-to-top').removeClass('show');
                $('#arrow-up').removeClass('fa-arrow-up');
                $('#arrow-up').removeClass('fa-lg');
            }
        };
    backToTop();
    $(window).on('scroll', function () {
        backToTop();
    });

    $('#back-to-top').on('click', function (event) {
        event.preventDefault();
        $('html').animate({
            scrollTop: 0
        }, 800);
    });
})