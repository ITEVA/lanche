$(document).ready(function () {
    $(".detalhesPedido").click(function () {
        var id = $(this).attr('iid');
        $("#detalhesPedido"+id).modal();
    });
});