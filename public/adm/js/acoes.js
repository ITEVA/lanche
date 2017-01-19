$(document).ready(function(){

    $("#tipo").change(function() {
        var $this, secao, atual, campos;

        campos = $("div[data-name]");

        campos.addClass("hide");

        if (this.value !== "") {
            secao = $('option[data-section][value="' + this.value + '"]', this).attr("data-section");

            atual = campos.filter("[data-name=" + secao + "]");

            if (atual.length !== 0) {
                atual.removeClass("hide");
            }
        }

        switch ($("#tipo").val()) {
            case "2":
                $('#cpfCnpj').removeClass('cpf');
                $('#cpfCnpj').removeClass('cnpj');
                $('#especial').addClass('hide');
                $('#especial1').removeClass('col-md-6');
                $('#especial1').addClass('col-md-3');
                $('#especial1').removeClass('quebrarDiv');
                $('#lblNomeRazaoSocial').html('Outros *');
                break;
            case "1":
                $('#cpfCnpj').addClass('cnpj').removeClass('cpf');
                $('#especial').removeClass('hide');
                $('#especial1').removeClass('col-md-3');
                $('#especial1').addClass('col-md-6');
                $('#especial1').addClass('quebrarDiv');
                $('#lblCpfCnpj').html('Cnpj *');
                $('#lblNomeRazaoSocial').html('Razão social');
                break;
            case "0":
                $('#cpfCnpj').addClass('cpf').removeClass('cnpj');
                $('#especial').removeClass('hide');
                $('#especial1').removeClass('col-md-3');
                $('#especial1').addClass('col-md-6');
                $('#especial1').addClass('quebrarDiv');
                $('#lblCpfCnpj').html('Cpf *');
                $('#lblNomeRazaoSocial').html('Nome *');
                break;
        }

        ativarMascaras();
    });

    $("#tipo").change();
});