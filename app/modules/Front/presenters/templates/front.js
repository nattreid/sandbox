$(document).ready(function () {
    $.nette.init();

    $("a[href*='#']").click(function () {
        var href = $.attr(this, 'href');
        var id = href.substr(href.indexOf('#') + 1);
        if (id) {
            $('html, body').animate({
                scrollTop: $('[id="' + id + '"]').offset().top
            }, 500);
        }

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