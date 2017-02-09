$(document).ready(function () {
    $("#salvarPedido").click(function (e) {
        e.preventDefault();

        $(".selectProdutoFormado").each(function () {
            $(this).remove();
        });

        $(".selectPrecoTotal").each(function () {
            $(this).remove();
        });

        $(".nomeProduto").each(function () {
            $(".selectNomeFormado").append("<option selected='selected' class='selectProdutoFormado' value='"+ $(this).html() +"'>"+ $(this).html() +"</option>");
        });

        $(".precoProduto").each(function () {
            var precoFormado = ($(this).html()).split(" ");
            $(".selectPrecoFormado").append("<option selected='selected' class='selectPrecoTotal' value='"+ (precoFormado[1].toString()).replace(",", ".") +"'>"+ (precoFormado[1].toString()).replace(",", ".") +"</option>");
        });


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

    var ctrlDuplicata = 1;

    $('#addProduto').click(function () {
        if ($('#produtos').val() != '') {
            if($('.produtosPedidos').hasClass("tabelaProdutos") == false) {
                $(".produtosPedidos").addClass('tabelaProdutos');
                $("#addTr").css("visibility", "visible");
                $(".totalPedido").css("visibility", "visible");
            }
            var id = $('#produtos').val();
            var nome =  $('#produtos option:selected').attr('nomeE');
            var nomeQ = nome.split(" ");

            var preco = $('#produtos option:selected').attr('precoE');

            preco = parseFloat(preco).toFixed(2);
            var duplicata = buscaDuplicata(id);

            var idSanduiche = duplicata ? id+"_"+ (ctrlDuplicata++) : id;

            if(nomeQ[0] == 'Sand.') {
                $("#addTr").append("<tr class='produtosTabela' iid='" + id + "'>" +
                    "<td><label id='nomeProduto' iid='" + idSanduiche + "' nomeProduto='" + nome + "' class='nomeProduto'>" + nome + "</label></td>" +
                    "<td><label class='precoUnitario'>R$ " + preco.replace(".", ",") + "</label></td>" +
                    "<td class='sanduiche'>" +
                        "<input class='tipoPao' type='radio' name='tipo_pao" + idSanduiche + "' nomePao='Pão carioca' value='0.25'/>PC " +
                        "<input class='tipoPao' type='radio' name='tipo_pao" + idSanduiche + "' checked='checked' nomePao='Pão de forma' value='0.19'/>PF " +
                        "<input class='tipoPao' type='radio' name='tipo_pao" + idSanduiche + "' nomePao='Pão integral' value='0.23'/>PI " +
                        "<input class='tipoPao' type='radio' name='tipo_pao" + idSanduiche + "' nomePao='Pão sovado' value='0.25'/>PS " +
                    "</td>" +
                    "<td class='sanduiche'>" +
                        "<input class='chapado' type='radio' nomeChapado='Chapado' name='chapado" + idSanduiche + "' checked='checked' value='1'/> C " +
                        "<input class='chapado' type='radio' nomeChapado='Não chapado' name='chapado" + idSanduiche + "' value='0'/> N.C " +
                    "</td>" +
                    "<td class='sanduiche'>" +
                        "<input class='tipoRecheio' type='radio' name='tipo_recheio" + idSanduiche + "' nomeRecheio='Margarina' checked='checked' value='0.04'/>M " +
                        "<input class='tipoRecheio' type='radio' name='tipo_recheio" + idSanduiche + "' nomeRecheio='Requeijão' value='0.09'/>R " +
                        "<input class='tipoRecheio' type='radio' name='tipo_recheio" + idSanduiche + "' nomeRecheio='Nada' value='0.0'/> N/A " +
                    "</td>" +
                    "<td class='sanduiche'>" +
                        "<label class='precoFormado "+ idSanduiche +"'>R$ " + preco.replace(".", ",") + "</label>" +
                    "</td> " +
                    "<td><input class='quantidadeProduto quantidade' type='text' value='1' min='1' max='10'></td>" +
                    "<td class='td'><label class='precoProduto'>R$ " + preco.replace(".", ",") + "</label></td>" +
                    "<td><a href='#' class='removerProduto'><i class='fa fa-trash'></i></a></td>" +
                    "</tr>");
                $(".sanduiche").removeClass('colunaInativa');
            }
            else {
                $("#addTr").append("<tr class='produtosTabela' iid='" + id + "'>" +
                    "<td><label id='nomeProduto' iid='" + idSanduiche + "' nomeProduto='" + nome + "' class='nomeProduto'>" + nome + "</label></td>" +
                    "<td><label class='precoUnitario'>R$ " + preco.replace(".", ",") + "</label></td>" +
                    "<td class='sanduiche colunaInativa'>" +
                    "</td>" +
                    "<td class='sanduiche colunaInativa'>" +
                    "</td>" +
                    "<td class='sanduiche colunaInativa'>" +
                    "</td>" +
                    "<td class='sanduiche colunaInativa'>" +
                        "<label class='precoFormado  "+ idSanduiche +"'>R$ " + preco.replace(".", ",") + "</label>" +
                    "</td> " +
                    "<td><input class='quantidadeProduto quantidade' type='text' value='1' min='1' max='10'></td>" +
                    "<td class='td'><label class='precoProduto'>R$ " + preco.replace(".", ",") + "</label></td>" +
                    "<td><a href='#' class='removerProduto'><i class='fa fa-trash'></i></a></td>" +
                    "</tr>");
            }

            $(".selectNome").append("<option selected='selected' iid='" + idSanduiche + "' class='selectProduto' value='"+ nome +"'>"+ nome +"</option>");
            $(".selectQuantidade").append("<option selected='selected' class='selectQtd' value='1'>1</option>");
            $(".selectPrecoUnitario").append("<option selected='selected' class='selectPreco' value='"+ preco +"'>"+ preco +"</option>");

            $('.tipoPao').change();
        }
        totalPedido();
    });

    $('#addTr').on("click",".removerProduto",function(e) {
        e.preventDefault();
        var id = $(this).parent().parent('tr').find('.nomeProduto').attr('iid');
        var nomeRemove = $(this).parent().parent('tr').find('.nomeProduto').attr('nomeProduto');
        var cont = 0, contO = 0, ctrl = 0;

        $(this).parent().parent('tr').remove();

        $(".selectProduto").each(function () {
            if(nomeRemove !== $(this).html()) {
                cont++;
            }
            if(nomeRemove === $(this).html() && id === $(this).attr('iid')) {
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

        totalPedido();

    });

    $(document).on('keyup', '.quantidadeProduto', function (e) {
        e.preventDefault();
        var id = $(this).parent().parent('tr').find('.nomeProduto').attr('iid');
        var nome = $(this).parent().parent('tr').find('.nomeProduto').attr('nomeProduto');
        var valuePrecoUnit = $(this).parent().parent('tr').find('.precoFormado').html();
        var qtd = ($(this).parent().parent('tr').find('.quantidadeProduto').val()).replace(",", ".");
        var precoUnitarioQ = valuePrecoUnit.split(' ');
        var precoUnitario = ((precoUnitarioQ[1].replace(",", ".")) * qtd).toString();
        var cont = 0, contO = 0;

        $(".selectProduto").each(function () {
            if(nome !== $(this).html() || id !== $(this).attr('iid')) {
                cont++;
            }
            if(nome === $(this).html() && id === $(this).attr('iid')) {
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

        precoUnitario = parseFloat(precoUnitario).toFixed(2);
        $(this).parent().parent('tr').find('.precoProduto').html("R$ " + precoUnitario.replace(".", ","));

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

    var valorPao = 0;
    var nomePao = '';
    var chapado = '';
    var nomeRecheio = '';

    var i = 1;
    $(document).on('change', '.tipoPao', function () {
        var valuePreco = ($(this).parent().parent('tr').find('.precoUnitario').html()).split(" ");
        var valorAtual = (valuePreco[1].toString()).replace(",", ".");
        var valorTotal = 0;

        valorTotal = parseFloat(valorAtual) + parseFloat(($(this).parent().parent('tr').find('.tipoPao:checked').val()));

        valorTotal = valorTotal.toFixed(2);

        valorPao = valorTotal;

        $(this).parent().parent('tr').find('.precoFormado').html("R$ " + (valorTotal.toString()).replace(".", ","));
        $('.tipoRecheio').change();
    });

    $(document).on('change', '.tipoRecheio', function () {
        var valuePreco = ($(this).parent().parent('tr').find('.precoUnitario').html()).split(" ");
        var valorAtual = (valuePreco[1].toString()).replace(",", ".");
        var valorTotal = 0;

        valorTotal = parseFloat(valorAtual) + parseFloat(($(this).parent().parent('tr').find('.tipoPao:checked').val()));

        valorTotal = valorTotal.toFixed(2);

        var valorPao = (valorTotal.toString()).replace(",", ".");
        var valorPaoRecheio = 0;

        valorPaoRecheio = parseFloat(valorPao) + parseFloat(($(this).parent().parent('tr').find('.tipoRecheio:checked').val()));

        valorPaoRecheio = valorPaoRecheio.toFixed(2);

        $(this).parent().parent('tr').find('.precoFormado').html("R$ " + (valorPaoRecheio.toString()).replace(".", ","));
        $('.quantidadeProduto').keyup();

        nomePao = ($(this).parent().parent('tr').find('.tipoPao:checked').attr('nomePao')).toLowerCase();
        nomeRecheio = ($(this).parent().parent('tr').find('.tipoRecheio:checked').attr('nomeRecheio')).toLowerCase();
        chapado = ($(this).parent().parent('tr').find('.chapado:checked').attr('nomeChapado')).toLowerCase();

        var nome = $(this).parent().parent('tr').find('.nomeProduto').attr('nomeProduto');
        var nomeAntigo = $(this).parent().parent('tr').find('.nomeProduto').html();

        $(this).parent().parent('tr').find('.nomeProduto').html(nome + " no " + nomePao + " c/ " + nomeRecheio + " " + chapado);

    });

    $(document).on('change', '.chapado', function () {
        var id = ($(this).parent().parent('tr').attr('iid'));

        nomePao = ($(this).parent().parent('tr').find('.tipoPao:checked').attr('nomePao')).toLowerCase();
        nomeRecheio = ($(this).parent().parent('tr').find('.tipoRecheio:checked').attr('nomeRecheio')).toLowerCase();
        chapado = ($(this).parent().parent('tr').find('.chapado:checked').attr('nomeChapado')).toLowerCase();

        var nome = $(this).parent().parent('tr').find('.nomeProduto').attr('nomeProduto');
        var nomeAntigo = $(this).parent().parent('tr').find('.nomeProduto').html();

        $(this).parent().parent('tr').find('.nomeProduto').html(nome + " no " + nomePao + " c/ " + nomeRecheio + " " + chapado);

        $(".selectProdutoFormado").each(function () {
            if(nomeAntigo === $(this).html()) {
                $(this).val(nome + " no " + nomePao + " c/ " + nomeRecheio + " " + chapado);
                $(this).html(nome + " no " + nomePao + " c/ " + nomeRecheio + " " + chapado);
            }
        });
    });

    function totalPedido() {
        var totalPedido = 0;
        $(".td").each(function () {
            var precoProduto = $(this).find('.precoProduto').html();
            var precoProdutoQ = precoProduto.split(' ');

            totalPedido = parseFloat(totalPedido) + parseFloat(precoProdutoQ[1].replace(",", "."));
            totalPedido = totalPedido.toFixed(2);
            $("#totalPedido").html((totalPedido.toString()).replace(".", ","));
        });

        return totalPedido;
    }

    function buscaDuplicata(id) {
        var retorno = false;
        $(".produtosTabela").each(function () {
            if(($(this).attr('iid')) == id) {
                retorno = true;
            }
        });
        return retorno;
    }

    $(".detalhesPedido").click(function () {
        var id = $(this).attr('iid');
        $("#detalhesPedido"+id).modal();
    });

});