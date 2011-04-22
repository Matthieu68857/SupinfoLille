jQuery(document).ready(function() {	
	
	// *************** animation pour l'edition des informations ***************
	
	var demandeModifs = false;
	
	jQuery("#editer_informations").click(function(){
		if(demandeModifs == false){
			jQuery(this).html("<input type='submit' value='Enregistrer'/>");
			jQuery("#mesinformations form span strong").each(function(){
				jQuery(this).html('<input type="text" value="'+jQuery(this).html()+'" name="'+jQuery(this).attr('title')+'"/>');
			})	
			demandeModifs = true;
		}
	});
	
	jQuery("#changer_mdp").click(function(){
		jQuery("#compte_infos").hide();
		jQuery("#mdp").show();
		jQuery(this).html("<input type='submit' value='Enregistrer'/>");
		jQuery("#moncompte h2 input").click(function(){
			jQuery("#moncompte form").submit();
		});
	});
	
});