$(document).ready(function () {
    $("#salvarPedido").click(function (e) {
        e.preventDefault();

        if ($('#usuarios').val() == '') {
            $("#erroUsuario").modal();
        }
        else if ($('#motivoCorrecao').val() == '') {
            $("#erroMotivo").modal();
        }
        else {
            var cont = 0;
            $(".td").each(function () {
                cont++;
            });
            if (cont == 0) {
                $("#erroSalvar").modal();
            } else {
                $('#frmPedido').submit();
            }
        }
    });

    $('[data-toggle="popover"]').popover();

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
                var nome =  $(this).attr('nomeE');
                var nomeQ = nome.split(" ");

                var preco = $(this).attr('precoE');
                preco = parseFloat(preco).toFixed(2);

                if(nomeQ[0] == 'Sand.') {
                    $("#addTr").append("<tr class='produtosTabela'>" +
                        "<td><label class='nomeProduto'>" + $(this).attr('nomeE') + "</label></td>" +
                        "<td><label class='precoUnitario'>R$ " + preco.replace(".", ",") + "</label></td>" +
                        "<td class='sanduiche'>" +
                            "<input class='tipoPao' type='radio' name='tipo_pao' checked='checked' nomePao='Pão carioca' value='0.25'/>PC" +
                            "<input class='tipoPao' type='radio' name='tipo_pao' nomePao='Pão de forma' value='0.19'/>PF" +
                            "<input class='tipoPao' type='radio' name='tipo_pao' nomePao='Pão integral' value='0.23'/>PI" +
                            "<input class='tipoPao' type='radio' name='tipo_pao' nomePao='Pão sovado' value='0.25'/>PS" +
                        "</td>" +
                        "<td class='sanduiche'>" +
                            "<input class='chapado' type='radio' nomeChapado='Chapado' name='chapado' value='1'/> C" +
                            "<input class='chapado' type='radio' nomeChapado='Não chapado' name='chapado' checked='checked' value='0'/> N.C" +
                        "</td>" +
                        "<td class='sanduiche'>" +
                            "<input class='tipoRecheio' type='radio' name='tipo_recheio' nomeRecheio='Margarina' checked='checked' value='0.04'/>M" +
                            "<input class='tipoRecheio' type='radio' name='tipo_recheio' nomeRecheio='Requeijão' value='0.09'/>R" +
                            "<input class='tipoRecheio' type='radio' name='tipo_recheio' nomeRecheio='Nada' value='0.0'/> N/A" +
                        "</td>" +
                        "<td class='sanduiche'>" +
                            "<label class='precoFormado'>R$ " + preco.replace(".", ",") + "</label>" +
                        "</td> " +
                        "<td><input class='quantidadeProduto quantidade' type='text' value='1' min='1' max='10'></td>" +
                        "<td class='td'><label class='precoProduto'>R$ " + preco.replace(".", ",") + "</label></td>" +
                        "<td><a href='#' class='removerProduto'><i class='fa fa-trash'></i></a></td>" +
                        "</tr>");
                    $(".sanduiche").removeClass('colunaInativa');
                }
                else {
                    $("#addTr").append("<tr class='produtosTabela'>" +
                        "<td><label class='nomeProduto'>" + $(this).attr('nomeE') + "</label></td>" +
                        "<td><label class='precoUnitario'>R$ " + preco.replace(".", ",") + "</label></td>" +
                        "<td class='sanduiche colunaInativa'>" +
                        "</td>" +
                        "<td class='sanduiche colunaInativa'>" +
                        "</td>" +
                        "<td class='sanduiche colunaInativa'>" +
                        "</td>" +
                        "<td class='sanduiche colunaInativa'>" +
                        "<label class='precoFormado'>R$ " + preco.replace(".", ",") + "</label>" +
                        "</td> " +
                        "<td><input class='quantidadeProduto quantidade' type='text' value='1' min='1' max='10'></td>" +
                        "<td class='td'><label class='precoProduto'>R$ " + preco.replace(".", ",") + "</label></td>" +
                        "<td><a href='#' class='removerProduto'><i class='fa fa-trash'></i></a></td>" +
                        "</tr>");
                }
                $('.tipoPao').change();

                $(".selectNome").append("<option selected='selected' class='selectProduto' value='"+$(this).attr('nomeE')+"'>"+$(this).attr('nomeE')+"</option>");
                $(".selectQuantidade").append("<option selected='selected' class='selectQtd' value='1'>1</option>");
                $(".selectPrecoUnitario").append("<option selected='selected' class='selectPreco' value='"+$(this).attr('precoE')+"'>"+$(this).attr('precoE')+"</option>");
                $(".selectPrecoFormado").append("<option selected='selected' class='selectPrecoTotal' value='"+$(this).attr('precoE')+"'>"+$(this).attr('precoE')+"</option>");

            }
        });
        var totalPedido = 0;
        $(".td").each(function () {
            var precoProduto = $(this).find('.precoProduto').html();
            var precoProdutoQ = precoProduto.split(' ');

            totalPedido = parseFloat(totalPedido) + parseFloat(precoProdutoQ[1].replace(",", "."));
            totalPedido = totalPedido.toFixed(2);

            $("#totalPedido").html((totalPedido.toString()).replace(".", ","));
        });
    });

    $('#addTr').on("click",".removerProduto",function(e) {
        e.preventDefault();
        var nomeRemove = $(this).parent().parent('tr').find('.nomeProduto').attr('nomeProduto');
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
            $(".totalPedido").css("visibility", "hidden");
            $(".produtosPedidos").removeClass('tabelaProdutos');
        }

        var totalPedido = 0;
        $(".td").each(function () {
            var precoProduto = $(this).find('.precoProduto').html();
            var precoProdutoQ = precoProduto.split(' ');

            totalPedido = parseFloat(totalPedido) + parseFloat(precoProdutoQ[1].replace(",", "."));
            totalPedido = totalPedido.toFixed(2);

            $("#totalPedido").html((totalPedido.toString()).replace(".", ","));
        });

    });

    $(document).on('keyup', '.quantidadeProduto', function () {
        var nome = $(this).parent().parent('tr').find('.nomeProduto').attr('nomeProduto');
        var valuePrecoUnit = $(this).parent().parent('tr').find('.precoFormado').html();
        var qtd = ($(this).parent().parent('tr').find('.quantidadeProduto').val()).replace(",", ".");
        var precoUnitarioQ = valuePrecoUnit.split(' ');
        var precoUnitario = ((precoUnitarioQ[1].replace(",", ".")) * qtd).toString();
        var totalPedido = $('#totalPedido').html();
        var cont = 0, contO = 0;

        $(".selectProduto").each(function () {
            if(nome !== $(this).html()) {
                cont++;
            }
            if(nome === $(this).html()) {
                contO = cont + 1;
            }
        });

        var contPreco = contO;
        var contQtd = contO;

        $(".selectQtd").each(function () {
            contQtd--;
            if(contQtd == 0) {
                $(this).val(qtd);
                $(this).html(qtd);
            }
        });

        precoUnitario = parseFloat(precoUnitario).toFixed(2);
        $(this).parent().parent('tr').find('.precoProduto').html("R$ " + precoUnitario.replace(".", ","));

        $(".selectPrecoTotal").each(function () {
            contPreco--;
            if(contPreco == 0) {
                $(this).val(precoUnitario);
                $(this).html(precoUnitario);
            }
        });

        var totalPedido = 0;
        $(".td").each(function () {
            var precoProduto = $(this).find('.precoProduto').html();
            var precoProdutoQ = precoProduto.split(' ');

            totalPedido = parseFloat(totalPedido) + parseFloat(precoProdutoQ[1].replace(",", "."));
            totalPedido = totalPedido.toFixed(2);

            $("#totalPedido").html((totalPedido.toString()).replace(".", ","));
        });

        ativarMascaras();
    });

    var teste = false;
    var valorPao = 0;
    var nomePao = '';
    var chapado = '';
    var nomeRecheio = '';

    $(document).on('change', '.tipoPao', function () {
        var valuePreco = ($(this).parent().parent('tr').find('.precoUnitario').html()).split(" ");
        var valorAtual = (valuePreco[1].toString()).replace(",", ".");
        var valorTotal = 0;

        valorTotal = parseFloat(valorAtual) + parseFloat($('.tipoPao:checked').val());

        valorTotal = valorTotal.toFixed(2);

        valorPao = valorTotal;

        $(this).parent().parent('tr').find('.precoFormado').html("R$ " + (valorTotal.toString()).replace(".", ","));
        $('.tipoRecheio').change();
    });

    $(document).on('change', '.tipoRecheio', function () {
        var valuePreco = valorPao;
        var valorAtual = (valuePreco.toString()).replace(",", ".");
        var valorTotal = 0;

        valorTotal = parseFloat(valorAtual) + parseFloat($('.tipoRecheio:checked').val());

        valorTotal = valorTotal.toFixed(2);

        $(this).parent().parent('tr').find('.precoFormado').html("R$ " + (valorTotal.toString()).replace(".", ","));
        $('.quantidadeProduto').keyup();

        var id = ($(this).parent().parent('tr').find('#iid').val());

        nomePao = ($('.tipoPao:checked').attr('nomePao')).toLowerCase();
        nomeRecheio = ($('.tipoRecheio:checked').attr('nomeRecheio')).toLowerCase();
        chapado = ($('.chapado:checked').attr('nomeChapado')).toLowerCase();

        montarNomeSanduiche(id);
    });

    $(document).on('change', '.chapado', function () {
        var id = ($(this).parent().parent('tr').find('#iid').val());

        nomePao = ($('.tipoPao:checked').attr('nomePao')).toLowerCase();
        nomeRecheio = ($('.tipoRecheio:checked').attr('nomeRecheio')).toLowerCase();
        chapado = ($('.chapado:checked').attr('nomeChapado')).toLowerCase();

        montarNomeSanduiche(id);
    });
    
    function montarNomeSanduiche (id) {
        var nome = $('#nomeProduto' + id).attr('nomeProduto');
        $('#nomeProduto' + id).html(nome + " no " + nomePao + " c/ " + nomeRecheio + " " + chapado);

        $(".selectProduto").each(function () {
            if(nome === $(this).html()) {
                $(this).val(nome + " no " + nomePao + " c/ " + nomeRecheio + " " + chapado);
                $(this).html(nome + " no " + nomePao + " c/ " + nomeRecheio + " " + chapado);
            }
        });
    }

    $(".detalhesPedido").click(function () {
        var id = $(this).attr('iid');
        $("#detalhesPedido"+id).modal();
    });

    $('.tipoPao').change();
});