$(document).ready(function () {
    $(document).on('click', '.detalhesCardapio', (function (e) {
        e.preventDefault();
        var id = $(this).attr('iid');
        $("#detalhesCardapio"+id).modal();
    }));

    $("#produtos").parent().css('clear', 'both');

    $("#salvarPedido").click(function (e) {
        e.preventDefault();

        var cont = 0;
        $(".nomeProduto").each(function () {
            cont++;
        });
        if (cont == 0) {
            $("#erroSalvar").modal();
        } else {
            $('#formCardapio').submit();
        }
    });

    var urlAtual = window.location.href.split('/');

    if(urlAtual[4] === 'editar' || urlAtual[5] === 'editar') {
        $("#addTr").css("visibility", "visible");
        $(".totalPedido").css("visibility", "visible");
    }

    $('#addProduto').click(function () {
        $(".produto").each(function () {
            if ($(this).val() == $('#produtos').val() && $('#produtos').val() != '') {
                if($('.produtosPedidos').hasClass("tabelaProdutos") == false) {
                    $(".produtosPedidos").addClass('tabelaProdutos');
                    $("#addTr").css("visibility", "visible");
                    $(".totalPedido").css("visibility", "visible");
                }

                var id = $('#produtos').val();
                var nome =  $(this).attr('nomeE');
                var ctrl = 1;

                $(".produtosTabela").each(function () {
                    if(nome === $(this).find(".nomeProduto").html()) {
                        ctrl = 0;
                    }
                });

                if(ctrl) {
                    $("#addTr").append("<tr class='produtosTabela' iid='" + id + "' nomeProduto='" + nome + "'>" +
                        "<td><label class='nomeProduto'>" + $(this).attr('nomeE') + "</label></td>" +
                        "<td><input class='quantidadeProduto quantidadeCardapio' type='text' value='1' min='1' max='10'></td>" +
                        "<td><a href='#' class='removerProduto'><i class='fa fa-trash'></i></a></td>" +
                        "</tr>");

                    $(".selectIds").append("<option selected='selected' class='selectId' value='"+ id +"'>"+ id +"</option>");
                    $(".selectNome").append("<option selected='selected' class='selectProduto' value='"+$(this).attr('nomeE')+"'>"+$(this).attr('nomeE')+"</option>");
                    $(".selectQuantidade").append("<option selected='selected' class='selectQtd' value='1'>1</option>");
                }
                else
                    $('#alertRepetido').modal();
            }
        });
    });

    $('#addTr').on("click",".removerProduto",function(e) {
        e.preventDefault();
        var nomeRemove = $(this).parent().parent('tr').find('.nomeProduto').html();
        var cont = 0, contO = 0;

        $(this).parent().parent('tr').remove();

        $(".selectProduto").each(function () {
            if(nomeRemove !== $(this).html()) {
                cont++;
            }
            if(nomeRemove === $(this).html()) {
                $(this).remove();
                contO = cont + 1;
            }
        });

        var contIds = contO;
        var contQtd = contO;

        $(".selectId").each(function () {
            contIds--;
            if(contIds == 0) {
                $(this).remove();
            }
        });

        $(".selectQtd").each(function () {
            contQtd--;
            if(contQtd == 0) {
                $(this).remove();
            }
        });

        if($('#addTr tr').length === 1){
            $("#addTr").css("visibility", "hidden");
            $(".totalPedido").css("visibility", "hidden");
            $(".produtosPedidos").removeClass('tabelaProdutos');
        }
    });

    $(document).on('keyup', '.quantidadeProduto', function (e) {
        e.preventDefault();
        var id = $(this).parent().parent('tr').attr('iid');
        var nome = $(this).parent().parent('tr').attr('nomeProduto');
        var qtd = ($(this).parent().parent('tr').find('.quantidadeProduto').val()).replace(",", ".");
        var cont = 0, contO = 0;

        $(".selectProduto").each(function () {
            if(nome !== $(this).html()) {
                cont++;
            }
            if(nome === $(this).html()) {
                contO = cont + 1;
            }
        });

        var contQtd = contO;

        $(".selectQtd").each(function () {
            contQtd--;
            if(contQtd == 0) {
                $(this).val(qtd);
                $(this).html(qtd);
            }
        });

        ativarMascaras();
    });
});