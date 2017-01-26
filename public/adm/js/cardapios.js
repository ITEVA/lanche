$(document).ready(function () {
    $(".detalhesCardapio").click(function () {
        var id = $(this).attr('iid');
        $("#detalhesCardapio"+id).modal();
    });

    $("#produtos").parent().css('clear', 'both');
});