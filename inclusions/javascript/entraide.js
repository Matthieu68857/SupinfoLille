jQuery(document).ready(function() {	

	function ouvrirFermerDetails(parent, currdet) {
		parent.slideToggle(300);
		currdet.toggle();
	}
	
	jQuery(".detailquestion").click(function(){
		ouvrirFermerDetails(jQuery(this).parent().find('.details'), jQuery(this).parent().find('.detailquestion'));
	});
	
	$('#form_question input').focus(function() {
		if ($("#form_question input").val() == "Entrez votre Question ici...") {
			$("#form_question input").val('');
		}
	});
			
	jQuery(".submitquestion").click(function(){	
		jQuery("#form_question").submit();
	});
		
	jQuery(".valid").click(function(){	
		jQuery(this).parent().submit();
	});
	
});