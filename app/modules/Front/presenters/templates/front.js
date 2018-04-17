$(document).ready(function () {
    $.nette.init();

    $('a[href^="#"]').click(function () {
        $('html, body').animate({
            scrollTop: $('[name="' + $.attr(this, 'href').substr(1) + '"]').offset().top
        }, 500);

        return false;
    });

    function flashMessage() {
        var time = 3000;
        $('.ipub-flash-messages .alert').each(function () {
            time += 1000;
            $(this).delay(time).fadeOut();
        });
    }

    flashMessage();
    $(document).ajaxComplete(function (event, request, settings) {
        flashMessage();
    });
});