jQuery(document).ready(function() { 

	//  administration des SONDAGES
				
	var nbroption = jQuery(".nbroption").size() - 1;
	var info = false;	

	jQuery( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
	
	jQuery(".moins").click(function(){
		if(nbroption == 1){ 
			if(info == false){
				jQuery(this).after(' <span style="color:red">Il faut au moins deux options !</span>'); 
				info = true;
			} 
		} else { 
			jQuery("#options div:last").remove();
			nbroption--;
		};
	});
				
	jQuery(".plus").click(function(){
		nbroption++;
		var displayopt = nbroption + 1;
		jQuery("#options").append('<div>Choix ' + displayopt + ' : <input name="opt[' + nbroption + ']" type="text" /><br /></div>');
	});
				 
	jQuery("#formsondage").submit(function() {
		var dataString = 'choix='+ nbroption;
		
		jQuery.ajax({
			type: "POST",
			url: "sondages.php?action=ajouter",
			data: nbroption,
			success: function() {

			}
		});	
						
	});
	
});