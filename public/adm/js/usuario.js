function updateCoords(c) {
    $('#x').val(c.x);
    $('#y').val(c.y);
    $('#w').val(c.w);
    $('#h').val(c.h);
};

function ShowImagePreview(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            var alturaOriginal = 0;
            var larguraOriginal = 0;

            var novaAltura = 150;
            var novaLargura = 0;

            var img = new Image;
            img.onload = function () {
                alturaOriginal = img.height;
                larguraOriginal = img.width;
            };

            img.src = reader.result;

            setTimeout(function () {
                novaLargura = (novaAltura * larguraOriginal) / alturaOriginal;

                JcropAPI = $('#imgUsuario').data('Jcrop');
                JcropAPI.destroy();


                $('#imgUsuario').prop('src', e.target.result)
                    .height(novaAltura)
                    .width(novaLargura);

                $('#imgUsuario').Jcrop({
                    setSelect: [0, 0, novaLargura, novaAltura],
                    onSelect: updateCoords,
                    aspectRatio: 1
                });
            }, 100);

        };

        reader.readAsDataURL(input.files[0]);
    }
}

$(document).ready(function () {
    $(function () {
        $('#imgUsuario').Jcrop({
            onSelect: updateCoords,
            aspectRatio: 1
        });
    });
});