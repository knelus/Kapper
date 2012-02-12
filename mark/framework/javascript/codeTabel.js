$(document).ready(function(){
		$("#codesTabel").change(function(){
			if($(this).val()!="leeg"){
				$("#codesTabel option[value=leeg]").remove();
			}
			$("#voorwaarden").load("ajax?page=codeVoorwaarden&id=" + $(this).val());
			return true;
		});
	}
);