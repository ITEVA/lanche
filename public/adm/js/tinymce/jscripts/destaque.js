$(function () {
    jQuery(function($){
        $('.destaque-ntc').mask('9');
    });
    $('#aviso').hide();
    $('input.destaque-ntc').focusout(function () {
        var idElemento = $(this).attr('id');
        var iid = $(this).parent().parent().find('#idNoticia').text();
        var valor = $(this).val();
        if (valor == 0 || valor >4){
            alert("Só são aceitos os dígitos: 1, 2, 3 ou 4");
            window.location.href='?pg=painel';
            return false;
        }
        $.ajax({
            type: "POST",
            url: "includes/destaque.php",
            data: {
                id: iid,
                destaque:valor
            }
        })
            .done(function (resultado) {
                $('.destaque-ntc').each(function(){
                    if($(this).val() == valor && $(this).attr('id') != idElemento){
                        $(this).val('');
                    }
                });

                $('#aviso').html(resultado);
                $('#aviso').show('slow').delay(5000).hide('slow');
            });


    });
});