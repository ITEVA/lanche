$(document).ready(function () {
    $(document).on('click', '.detalhesPedido', (function (e) {
        e.preventDefault();
        var id = $(this).attr('iid');
        $("#detalhesPedido"+id).modal();
    }));
});