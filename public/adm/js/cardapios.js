$(document).ready(function () {
    $(document).on('click', '.detalhesCardapio', (function (e) {
        e.preventDefault();
        var id = $(this).attr('iid');
        $("#detalhesCardapio"+id).modal();
    }));

    $("#produtos").parent().css('clear', 'both');
});