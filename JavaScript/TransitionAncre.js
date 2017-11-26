$(document).ready(function(){
	$('a.disabled').on('click', function (event) {
        event.preventDefault()
    })

    $('a').on('click', function () {

        if ($(this).attr('transition-js') === "true") {
            if ($(this).attr('href') !== undefined) {
                if ($(this).attr('href') !== "#") {
                    let target = $(this).attr('href');
                    /* le sélecteur $(html, body) permet de corriger un bug sur chrome
                    et safari (webkit) */
                    $('html, body')
                    // stop all animations in progress
                        .stop()
                        /* on fait maintenant l'animation vers le haut (scrollTop) vers
                         notre ancre target */
                        .animate({
                            scrollTop: $(target).offset().top
                        }, 1500);
                }
            }

        }
    })
}) 
