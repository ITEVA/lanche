$(document).ready(function(e) {
	$('.files').change(function() {
		for(var i=0; i<this.files.length;i++){
			if (this.files[i].size>(1024*1024)){
				alert("Selecione arquivos com tamanho máximo de 2Mb");
				$(this).val("");
			}
		}
	});    
});
