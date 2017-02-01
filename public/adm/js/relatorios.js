$(document).ready(function () {
    $('#imprimirGastos').click(function(){
        $('#filtro').attr('action', 'relatorios/gastos/imprimir');
        $('#filtro').attr('target', '_blank');
        $('#filtro').submit();
        $('#filtro').attr('action', 'relatorios/gastos');
        $('#filtro').attr('target', '_self');
    });

    $('#imprimirPedidos').click(function(){
        $('#filtro').attr('action', 'relatorios/pedidos/imprimir');
        $('#filtro').attr('target', '_blank');
        $('#filtro').submit();
        $('#filtro').attr('action', 'relatorios/pedidos');
        $('#filtro').attr('target', '_self');
    });

    $(document).on('click', '.detalhesPedido', (function (e) {
        e.preventDefault();
        var id = $(this).attr('iid');
        $("#detalhesPedido"+id).modal();
    }));
});