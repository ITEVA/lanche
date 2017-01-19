$(document).ready(function() {

    $('a[name=modal]').click(function(e) {
        e.preventDefault();

        var id = $(this).attr('href');

        var maskHeight = $(document).height();
        var maskWidth = $(window).width();

        $('#mask').css({'width': maskWidth, 'height': maskHeight});

        $('#mask').fadeIn(200);
        $('#mask').fadeTo("fast", 1);

        //Get the window height and width
        var winH = $(window).height();
        var winW = $(window).width();

        $(id).css('top', 50);
        $(id).css('left', winW / 2 - $(id).width() / 2);

        $(id).fadeIn(200);

    });

    $('.window .close').click(function(e) {
        e.preventDefault();

        $('#mask').hide();
        $('.window').hide();
    });

    $('#mask').click(function() {
        $(this).hide();
        $('.window').hide();
    });

});