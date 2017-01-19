$(document).ready(function () {
    var urlAtual = window.location.href.split('/');

    if(urlAtual[4] === 'editar') {
        $("#addTr").css("visibility", "visible");
    }

    $('#addProduto').click(function () {
        if($('.produtosPedidos').hasClass("tabelaProdutos") == false) {
            $(".produtosPedidos").addClass('tabelaProdutos');
            $("#addTr").css("visibility", "visible");
        }
        $(".produto").each(function () {
            if ($(this).val() == $('#produtos').val() && $('#produtos').val() != '') {
                var nome =  $(this).attr('nomeE');
                var ctrl = 1;

                $(".produtosTabela").each(function () {
                    if(nome === $(this).find(".nomeProduto").html()) {
                        ctrl = 0;
                    }
                });

                if(ctrl) {
                    $("#addTr").append("<tr class='produtosTabela'>" +
                        "<td><label class='nomeProduto'>" + $(this).attr('nomeE') + "</label></td>" +
                        "<td><label class='precoUnitario'>" + $(this).attr('precoE') + "</label></td>" +
                        "<td><input class='quantidadeProduto' type='number' value='1'></td>" +
                        "<td><label class='precoProduto'>" + $(this).attr('precoE') + "</label></td>" +
                        "<td><a href='#' class='removerProduto'><i class='fa fa-trash'></i></a></td>" +
                        "</tr>");

                    $(".selectNome").append("<option selected='selected' class='selectProduto' value='"+$(this).attr('nomeE')+"'>"+$(this).attr('nomeE')+"</option>");
                    $(".selectPrecoUnitario").append("<option selected='selected' class='selectPreco' value='"+$(this).attr('precoE')+"'>"+$(this).attr('precoE')+"</option>");
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

        var contPreco = contO;
        var contQtd = contO;
        $(".selectPreco").each(function () {
            contPreco--;
            if(contPreco == 0) {
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
            $(".produtosPedidos").removeClass('tabelaProdutos');
        }

    });

    $(document).on('change', '.quantidadeProduto', function () {
        var nome = $(this).parent().parent('tr').find('.nomeProduto').html();
        var unit = $(this).parent().parent('tr').find('.precoUnitario').html();
        var qtd = $(this).parent().parent('tr').find('.quantidadeProduto').val();
        var cont = 0, contO = 0;

        $(".selectProduto").each(function () {
            if(nome !== $(this).html()) {
                cont++;
            }
            if(nome === $(this).html()) {
                contO = cont + 1;
            }
        });

        $(".selectQtd").each(function () {
            contO--;
            if(contO == 0) {
                $(this).val(qtd);
                $(this).html(qtd);
            }
        });

        $(this).parent().parent('tr').find('.precoProduto').html(unit * qtd);
    });
});