$(document).ready(function () {
    $('#selectAnos').on("change", function() {
        var base = $("base").attr('href');

        $(window.document.location).attr('href', base + "/gastos/" + $("#idUsuario").val() + "/" + $("#selectAnos").val());
    });
});