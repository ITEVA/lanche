$(document).ready(function () {

    var hDevice = $(window).height() - 70;

    $('.conteudoPrincipal').css('min-height', hDevice + 'px');

    ativarMascaras();

    $('#editarLote').click(function (e) {
        e.preventDefault();
        $('#tipoRemocao').val('lote');
        enviarForm($(this).attr('href'));
    });

    $('#removerLote').click(function (e) {
        e.preventDefault();
        $('#tipoRemocao').val('lote');
        $('#alertRemover').modal();
    });

    $(document).on('click', '.removerRegistro', (function (e) {
        e.preventDefault();
        $('#tipoRemocao').val('unico');
        $('#ids').val($(this).attr('href'));
        $('#alertRemover').modal();
    }));

    $('#confirmarRemocao').click(function () {
        enviarForm($('#removerLote').attr('href'));
    });

});

function enviarForm(acao) {
    if ($('#tipoRemocao').val() === "lote") {
        $('#ids').val('');
        $('.tableflat').each(function () {
            if ($(this).is(":checked")) {
                var atual = $(this).attr('id').substring(3);
                if ($('#ids').val() !== "") $('#ids').val($('#ids').val() + "-");

                $('#ids').val($('#ids').val() + atual);
            }
        });
    }
    if ($('#ids').val() !== "") {
        $("#formSelecionados").attr("action", acao);
        $("#formSelecionados").submit();
    }else{

    }
}

function ativarMascaras(){
    $('.quantidade').mask('0,0');
    $('.quantidadeCardapio').mask('000');
    $('.date').mask('00/00/0000');
    $('.cpf').mask('000.000.000-00');
    $('.cnpj').mask('00.000.000/0000-00');
    $('.celular').mask('(00) 0 0000-0000');
    $('.fixo').mask('(00) 0000-0000');
    $('.cep').mask('00.000-000');
    $('.money').maskMoney({allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
}
