$(document).ready(function () {
    $("#salvarPedido").click(function (e) {
        e.preventDefault();

        $(".selectProdutoFormado").each(function () {
            $(this).remove();
        });

        $(".selectPrecoTotal").each(function () {
            $(this).remove();
        });

        $(".selectPao").each(function () {
            $(this).remove();
        });

        $(".selectChapado").each(function () {
            $(this).remove();
        });

        $(".selectRecheio").each(function () {
            $(this).remove();
        });

        var salvar = true;

        $(".disponiveis").each(function () {
            if($(this).val() < 0)
                salvar = false;
        });

        if (salvar) {
            $(".nomeProduto").each(function () {
                var id = $(this).parent().parent('tr').attr('iid');
                var novoValor = parseFloat($('.quantidadeTotalPedido'+id).val()) + parseFloat($(this).parent().parent('tr').find('.quantidade').val());

                $('.quantidadeTotalPedido'+id).val(novoValor);

                $(".selectNomeFormado").append("<option selected='selected' class='selectProdutoFormado' value='" + $(this).html() + "'>" + $(this).html() + "</option>");

                var tipoPao = $(this).parent().parent('tr').find('.tipoPao:checked').attr('nomePao');
                var tipoChapado = $(this).parent().parent('tr').find('.chapado:checked').attr('nomeChapado');
                var tipoRecheio = $(this).parent().parent('tr').find('.tipoRecheio:checked').attr('nomeRecheio');

                $(".selectTipoPao").append("<option selected='selected' class='selectPao' value='" + tipoPao + "'>" + tipoPao + "</option>");
                $(".selectTipoChapado").append("<option selected='selected' class='selectChapado' value='" + tipoChapado + "'>" + tipoChapado + "</option>");
                $(".selectTipoRecheio").append("<option selected='selected' class='selectRecheio' value='" + tipoRecheio + "'>" + tipoRecheio + "</option>");
            });

            $(".precoProduto").each(function () {
                var precoFormado = ($(this).html()).split(" ");
                $(".selectPrecoFormado").append("<option selected='selected' class='selectPrecoTotal' value='" + (precoFormado[1].toString()).replace(",", ".") + "'>" + (precoFormado[1].toString()).replace(",", ".") + "</option>");
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
        }
        else
            $("#erroSalvarQuantidade").modal();
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
            var pCarioca = $('#produtos').attr('pCarioca');
            var pForma = $('#produtos').attr('pForma');
            var pIntegral = $('#produtos').attr('pIntegral');
            var pSovado = $('#produtos').attr('pSovado');
            var pMargarina = $('#produtos').attr('pMargarina');
            var pRequeijao = $('#produtos').attr('pRequeijao');

            if(nomeQ[0] == 'Sand.') {
                $("#addTr").append("<tr class='produtosTabela' iid='" + id + "'>" +
                    "<td><label id='nomeProduto' iid='" + idSanduiche + "' nomeProduto='" + nome + "' class='nomeProduto'>" + nome + "</label></td>" +
                    "<td><label class='precoUnitario'>R$ " + preco.replace(".", ",") + "</label></td>" +
                    "<td class='sanduicheTp'>" +
                        "<input class='tipoPao' type='radio' name='tipo_pao" + idSanduiche + "' nomePao='Pão carioca' value='" + pCarioca + "'/>PC " +
                        "<input class='tipoPao' type='radio' name='tipo_pao" + idSanduiche + "' checked='checked' nomePao='Pão de forma' value='" + pForma + "'/>PF " +
                        "<input class='tipoPao' type='radio' name='tipo_pao" + idSanduiche + "' nomePao='Pão integral' value='" + pIntegral + "'/>PI " +
                        "<input class='tipoPao' type='radio' name='tipo_pao" + idSanduiche + "' nomePao='Pão sovado' value='" + pSovado + "'/>PS " +
                        "<input class='tipoPaoDeducao' type='hidden' value='Pão de forma'/>"+
                    "</td>" +
                    "<td class='sanduicheTr'>" +
                        "<input class='tipoRecheio' type='radio' name='tipo_recheio" + idSanduiche + "' nomeRecheio='Margarina' checked='checked' value='" + pMargarina + "'/>M " +
                        "<input class='tipoRecheio' type='radio' name='tipo_recheio" + idSanduiche + "' nomeRecheio='Requeijão' value='" + pRequeijao + "'/>R " +
                        "<input class='tipoRecheio' type='radio' name='tipo_recheio" + idSanduiche + "' nomeRecheio='Nada' value='0.0'/> N/A " +
                    "</td>" +
                    "<td class='sanduicheC'>" +
                        "<input class='chapado' type='radio' nomeChapado='Chapado' name='chapado" + idSanduiche + "' checked='checked' value='1'/> C " +
                        "<input class='chapado' type='radio' nomeChapado='Não chapado' name='chapado" + idSanduiche + "' value='0'/> N.C " +
                    "</td>" +
                    "<td class='sanduiche'>" +
                        "<label class='precoFormado "+ idSanduiche +"'>R$ " + preco.replace(".", ",") + "</label>" +
                    "</td> " +
                    "<td>" +
                        "<input class='quantidadeProduto quantidade' type='text' value='1' min='1' max='10'>" +
                        "<input class='deduzido' type='hidden' value='0'>" +
                    "</td>" +
                    "<td class='td'><label class='precoProduto'>R$ " + preco.replace(".", ",") + "</label></td>" +
                    "<td><a href='#' class='removerProduto'><i class='fa fa-trash'></i></a></td>" +
                    "</tr>");
            }
            else if(nomeQ[0] == 'Pão') {
                $("#addTr").append("<tr class='produtosTabela' iid='" + id + "'>" +
                    "<td><label id='nomeProduto' iid='" + idSanduiche + "' nomeProduto='" + nome + "' class='nomeProduto'>" + nome + "</label></td>" +
                    "<td><label class='precoUnitario'>R$ " + preco.replace(".", ",") + "</label></td>" +
                    "<td class='sanduicheTp colunaInativa'>" +
                    "</td>" +
                    "<td class='sanduicheTr'>" +
                        "<input class='tipoRecheio' type='radio' name='tipo_recheio" + idSanduiche + "' nomeRecheio='Margarina' checked='checked' value='" + pMargarina + "'/>M " +
                        "<input class='tipoRecheio' type='radio' name='tipo_recheio" + idSanduiche + "' nomeRecheio='Requeijão' value='" + pRequeijao + "'/>R " +
                        "<input class='tipoRecheio' type='radio' name='tipo_recheio" + idSanduiche + "' nomeRecheio='Nada' value='0.0'/> N/A " +
                    "</td>" +
                    "<td class='sanduicheC'>" +
                        "<input class='chapado' type='radio' nomeChapado='Chapado' name='chapado" + idSanduiche + "' checked='checked' value='1'/> C " +
                        "<input class='chapado' type='radio' nomeChapado='Não chapado' name='chapado" + idSanduiche + "' value='0'/> N.C " +
                    "</td>" +
                    "<td class='sanduiche'>" +
                        "<label class='precoFormado "+ idSanduiche +"'>R$ " + preco.replace(".", ",") + "</label>" +
                    "</td> " +
                    "<td>" +
                        "<input class='quantidadeProduto quantidade' type='text' value='1' min='1' max='10'>" +
                        "<input class='deduzido' type='hidden' value='0'>" +
                    "</td>" +
                    "<td class='td'><label class='precoProduto'>R$ " + preco.replace(".", ",") + "</label></td>" +
                    "<td><a href='#' class='removerProduto'><i class='fa fa-trash'></i></a></td>" +
                    "</tr>");
            }
            else if(nomeQ[0] == 'Tapioca') {
                $("#addTr").append("<tr class='produtosTabela' iid='" + id + "'>" +
                    "<td><label id='nomeProduto' iid='" + idSanduiche + "' nomeProduto='" + nome + "' class='nomeProduto'>" + nome + "</label></td>" +
                    "<td><label class='precoUnitario'>R$ " + preco.replace(".", ",") + "</label></td>" +
                    "<td class='sanduicheTp colunaInativa'>" +
                    "</td>" +
                    "<td class='sanduicheTr'>" +
                        "<input class='tipoRecheio' type='radio' name='tipo_recheio" + idSanduiche + "' nomeRecheio='Margarina' checked='checked' value='" + pMargarina + "'/>M " +
                        "<input class='tipoRecheio' type='radio' name='tipo_recheio" + idSanduiche + "' nomeRecheio='Requeijão' value='" + pRequeijao + "'/>R " +
                        "<input class='tipoRecheio' type='radio' name='tipo_recheio" + idSanduiche + "' nomeRecheio='Nada' value='0.0'/> N/A " +
                    "</td>" +
                    "<td class='sanduicheC  colunaInativa'>" +
                    "</td>" +
                    "<td class='sanduiche'>" +
                    "<label class='precoFormado "+ idSanduiche +"'>R$ " + preco.replace(".", ",") + "</label>" +
                    "</td> " +
                    "<td>" +
                        "<input class='quantidadeProduto quantidade' type='text' value='1' min='1' max='10'>" +
                        "<input class='deduzido' type='hidden' value='0'>" +
                    "</td>" +
                    "<td class='td'><label class='precoProduto'>R$ " + preco.replace(".", ",") + "</label></td>" +
                    "<td><a href='#' class='removerProduto'><i class='fa fa-trash'></i></a></td>" +
                    "</tr>");
            }
            else {
                $("#addTr").append("<tr class='produtosTabela' iid='" + id + "'>" +
                    "<td><label id='nomeProduto' iid='" + idSanduiche + "' nomeProduto='" + nome + "' class='nomeProduto'>" + nome + "</label></td>" +
                    "<td><label class='precoUnitario'>R$ " + preco.replace(".", ",") + "</label></td>" +
                    "<td class='sanduicheTp colunaInativa'>" +
                    "</td>" +
                    "<td class='sanduicheTr colunaInativa'>" +
                    "</td>" +
                    "<td class='sanduicheC colunaInativa'>" +
                    "</td>" +
                    "<td class='sanduiche colunaInativa'>" +
                        "<label class='precoFormado  "+ idSanduiche +"'>R$ " + preco.replace(".", ",") + "</label>" +
                    "</td> " +
                    "<td>" +
                        "<input class='quantidadeProduto quantidade' type='text' value='1' min='1' max='10'>" +
                        "<input class='deduzido' type='hidden' value='0'>" +
                    "</td>" +
                    "<td class='td'><label class='precoProduto'>R$ " + preco.replace(".", ",") + "</label></td>" +
                    "<td><a href='#' class='removerProduto'><i class='fa fa-trash'></i></a></td>" +
                    "</tr>");
            }

            var countTp = 0;
            var countTr = 0;
            var countC = 0;

            $(".tipoPao").each(function () {
                countTp++;
            });

            if (countTp > 0) {
                $(".sanduicheTp").removeClass('colunaInativa');
                $('.tipoPao').change();
            }

            $(".tipoRecheio").each(function () {
                countTr++;
            });

            if (countTr > 0) {
                $(".sanduicheTr").removeClass('colunaInativa');
                $('.tipoRecheio').change();
            }

            $(".chapado").each(function () {
                countC++;
            });

            if (countC > 0) {
                $(".sanduicheC").removeClass('colunaInativa');
                $('.tipoRecheio').change();
            }

            if (countTp > 0 || countTr > 0 || countC > 0) {
                $(".sanduiche").removeClass('colunaInativa');
            }

            $(".selectNome").append("<option selected='selected' iid='" + idSanduiche + "' class='selectProduto' value='"+ nome +"'>"+ nome +"</option>");
            $(".selectQuantidade").append("<option selected='selected' class='selectQtd' value='1'>1</option>");
            $(".selectPrecoUnitario").append("<option selected='selected' class='selectPreco' value='"+ preco +"'>"+ preco +"</option>");
            $(".selectIds").append("<option selected='selected' class='selectId' value='"+ id +"'>"+ id +"</option>");
        }
        totalPedido();
    });

    $('#addTr').on("click",".removerProduto",function(e) {
        e.preventDefault();
        var id = $(this).parent().parent('tr').find('.nomeProduto').attr('iid');
        var iid = $(this).parent().parent('tr').attr('iid');
        var nomeRemove = $(this).parent().parent('tr').find('.nomeProduto').attr('nomeProduto');
        var qtd = ($(this).parent().parent('tr').find('.quantidadeProduto').val()).replace(",", ".");
        var qtdDeduzido = $(this).parent().parent('tr').find('.deduzido').val();
        var qtdDisponivel = $("#"+iid).val();
        var cont = 0, contO = 0, ctrl = 0;
        var novaQtdDisponivel = parseFloat(qtdDisponivel) + parseFloat(qtdDeduzido);

        $("#"+iid).val(novaQtdDisponivel);

        $(this).parent().parent('tr').remove();

        $(".selectProduto").each(function () {
            if(nomeRemove !== $(this).html() || id !== $(this).attr('iid')) {
                cont++;
            }
            if(nomeRemove === $(this).html() && id === $(this).attr('iid')) {
                $(this).remove();
                contO = cont + 1;
            }
        });

        var contIds = contO;
        var contPreco = contO;
        var contQtd = contO;

        $(".selectId").each(function () {
            contIds--;
            if(contIds == 0) {
                $(this).remove();
            }
        });

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

        var countTp = 0;
        var countTr = 0;
        var countC = 0;

        $(".tipoPao").each(function () {
            countTp++;
        });

        if (countTp === 0) {
            $(".sanduicheTp").addClass('colunaInativa');
        }

        $(".tipoRecheio").each(function () {
            countTr++;
        });

        if (countTr === 0) {
            $(".sanduicheTr").addClass('colunaInativa');
        }

        $(".chapado").each(function () {
            countC++;
        });

        if (countC === 0) {
            $(".sanduicheC").addClass('colunaInativa');
        }

        if (countTp === 0 && countTr === 0 && countC === 0) {
            $(".sanduiche").addClass('colunaInativa');
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

        if (qtd != '') {
            $(".selectProduto").each(function () {
                if (nome !== $(this).html() || id !== $(this).attr('iid')) {
                    cont++;
                }
                if (nome === $(this).html() && id === $(this).attr('iid')) {
                    contO = cont + 1;
                }
            });

            var contQtd = contO;

            $(".selectQtd").each(function () {
                contQtd--;
                if (contQtd == 0) {
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

            var nomeQ = nome.split(" ");
            var iid = "";

            if (nomeQ[0] == "Sand.") {
                var paoAtual = $(this).parent().parent('tr').find('.tipoPao:checked').attr('nomePao');
                $(".disponiveis").each(function () {
                    if ($(this).attr('nomeP') === paoAtual) {
                        iid = $(this).attr('id');
                    }
                });
            }
            else {
                iid = $(this).parent().parent('tr').attr('iid');
            }

            var qtdDisponivel = $("#"+iid).val();
            var valorDeduzido = $(this).parent().parent('tr').find('.deduzido').val();

            if (qtdDisponivel !== '') {
                var comp;
                if (valorDeduzido < qtd)
                    comp = qtd - valorDeduzido;
                else
                    comp = qtdDisponivel;
                if (qtd !== valorDeduzido) {
                    if (qtd != '') {
                        if (valorDeduzido == 0) {
                            valorDeduzido = qtd;
                            $("#" + iid).val(qtdDisponivel - qtd);
                        }
                        else if (valorDeduzido != qtd) {
                            if (valorDeduzido > qtd) {
                                var aux = qtd;
                                qtd = valorDeduzido - qtd;
                                valorDeduzido = aux;
                                $("#" + iid).val(parseFloat(qtdDisponivel) + parseFloat(qtd));
                            }
                            else {
                                var aux = qtd;
                                qtd = qtd - valorDeduzido;
                                valorDeduzido = aux;
                                $("#" + iid).val(qtdDisponivel - qtd);
                            }
                        }
                        $(this).parent().parent('tr').find('.deduzido').val(valorDeduzido);
                    }
                }
            }
        }

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

        var qtd = ($(this).parent().parent('tr').find('.quantidadeProduto').val()).replace(",", ".");

        if (qtd != '') {
            var paoAnterior = $(this).parent().parent('tr').find('.tipoPaoDeducao').val();
            var paoAtual = $(this).parent().parent('tr').find('.tipoPao:checked').attr('nomePao');
            var idAnterior = '';
            var idAtual = '';

            $(".disponiveis").each(function () {
                if ($(this).attr('nomeP') === paoAnterior) {
                    idAnterior = $(this).attr('id');
                }
                if ($(this).attr('nomeP') === paoAtual) {
                    idAtual = $(this).attr('id');
                }
            });

            var qtdDisponivelAnterior = $("#" + idAnterior).val();
            var qtdDisponivel = $("#" + idAtual).val();
            var valorDeduzido = $(this).parent().parent('tr').find('.deduzido').val();

            if (qtdDisponivel !== '') {
                var comp;
                if (valorDeduzido < qtd)
                    comp = qtd - valorDeduzido;
                else
                    comp = qtdDisponivel;
                if (qtd !== valorDeduzido || paoAnterior != paoAtual) {
                    if (qtd != '') {
                        if (valorDeduzido == 0) {
                            valorDeduzido = qtd;
                            $("#" + idAtual).val(qtdDisponivel - qtd);
                        }
                        else if (valorDeduzido != qtd) {
                            if (valorDeduzido > qtd) {
                                var aux = qtd;
                                qtd = valorDeduzido - qtd;
                                valorDeduzido = aux;
                                $("#" + idAtual).val(parseFloat(qtdDisponivel) + parseFloat(qtd));
                            }
                            else {
                                var aux = qtd;
                                qtd = qtd - valorDeduzido;
                                valorDeduzido = aux;
                                $("#" + idAtual).val(qtdDisponivel - qtd);
                            }
                        }
                        else if (valorDeduzido == qtd) {
                            $("#" + idAtual).val(parseFloat(qtdDisponivel) - parseFloat(qtd));
                            $("#" + idAnterior).val(parseFloat(qtdDisponivelAnterior) + parseFloat(qtd));
                        }
                        $(this).parent().parent('tr').find('.deduzido').val(valorDeduzido);
                        $(this).parent().parent('tr').find('.tipoPaoDeducao').val(paoAtual);
                    }
                }
            }
        }

        $('.tipoRecheio').change();
    });

    $(document).on('change', '.tipoRecheio', function () {
        var valuePreco = ($(this).parent().parent('tr').find('.precoUnitario').html()).split(" ");
        var valorAtual = (valuePreco[1].toString()).replace(",", ".");
        var valorTotal = 0;

        var nomeQ = ($(this).parent().parent('tr').find('.nomeProduto').attr('nomeProduto')).split(" ");

        if(nomeQ[0] == 'Sand.')
            valorTotal = parseFloat(valorAtual) + parseFloat(($(this).parent().parent('tr').find('.tipoPao:checked').val()));
        if (nomeQ[0] == 'Pão')
            valorTotal = parseFloat(valorAtual);
        if (nomeQ[0] == 'Tapioca')
            valorTotal = parseFloat(valorAtual);

        valorTotal = valorTotal.toFixed(2);

        var valorPao = (valorTotal.toString()).replace(",", ".");
        var valorPaoRecheio = 0;

        valorPaoRecheio = parseFloat(valorPao) + parseFloat(($(this).parent().parent('tr').find('.tipoRecheio:checked').val()));

        valorPaoRecheio = valorPaoRecheio.toFixed(2);

        $(this).parent().parent('tr').find('.precoFormado').html("R$ " + (valorPaoRecheio.toString()).replace(".", ","));
        $('.quantidadeProduto').keyup();

        var nome = "";
        if(nomeQ[0] == 'Sand.') {
            nomePao = ($(this).parent().parent('tr').find('.tipoPao:checked').attr('nomePao')).toLowerCase();
            nomeRecheio = ($(this).parent().parent('tr').find('.tipoRecheio:checked').attr('nomeRecheio')).toLowerCase();
            chapado = ($(this).parent().parent('tr').find('.chapado:checked').attr('nomeChapado')).toLowerCase();

            nome = $(this).parent().parent('tr').find('.nomeProduto').attr('nomeProduto');

            $(this).parent().parent('tr').find('.nomeProduto').html(nome + " no " + nomePao + " c/ " + nomeRecheio + " " + chapado);
        }
        else if (nomeQ[0] == 'Pão') {
            nomeRecheio = ($(this).parent().parent('tr').find('.tipoRecheio:checked').attr('nomeRecheio')).toLowerCase();
            chapado = ($(this).parent().parent('tr').find('.chapado:checked').attr('nomeChapado')).toLowerCase();

            nome = $(this).parent().parent('tr').find('.nomeProduto').attr('nomeProduto');

            $(this).parent().parent('tr').find('.nomeProduto').html(nome + " c/ " + nomeRecheio + " " + chapado);
        }
        else if (nomeQ[0] == 'Tapioca') {
            nomeRecheio = ($(this).parent().parent('tr').find('.tipoRecheio:checked').attr('nomeRecheio')).toLowerCase();

            nome = $(this).parent().parent('tr').find('.nomeProduto').attr('nomeProduto');

            $(this).parent().parent('tr').find('.nomeProduto').html(nome + " c/ " + nomeRecheio);
        }
    });

    $(document).on('change', '.chapado', function () {
        var nomeQ = ($(this).parent().parent('tr').find('.nomeProduto').attr('nomeProduto')).split(" ");

        var nome = "";
        if(nomeQ[0] == 'Sand.') {
            nomePao = ($(this).parent().parent('tr').find('.tipoPao:checked').attr('nomePao')).toLowerCase();
            nomeRecheio = ($(this).parent().parent('tr').find('.tipoRecheio:checked').attr('nomeRecheio')).toLowerCase();
            chapado = ($(this).parent().parent('tr').find('.chapado:checked').attr('nomeChapado')).toLowerCase();

            nome = $(this).parent().parent('tr').find('.nomeProduto').attr('nomeProduto');

            $(this).parent().parent('tr').find('.nomeProduto').html(nome + " no " + nomePao + " c/ " + nomeRecheio + " " + chapado);
        }
        else if (nomeQ[0] == 'Pão') {
            nomeRecheio = ($(this).parent().parent('tr').find('.tipoRecheio:checked').attr('nomeRecheio')).toLowerCase();
            chapado = ($(this).parent().parent('tr').find('.chapado:checked').attr('nomeChapado')).toLowerCase();

            nome = $(this).parent().parent('tr').find('.nomeProduto').attr('nomeProduto');

            $(this).parent().parent('tr').find('.nomeProduto').html(nome + " c/ " + nomeRecheio + " " + chapado);
        }

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