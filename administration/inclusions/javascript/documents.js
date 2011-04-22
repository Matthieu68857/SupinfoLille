jQuery(document).ready(function() {
	
	// animation pour la partie Gestion des documents
	
	var modificationEnCours = 0;
	
	jQuery(".nomDocument").dblclick(function(){
		if(modificationEnCours == 0){
			var id = jQuery(this).attr('title');
			jQuery(this).html('<input type="text" value="'+ jQuery(this).html() +'"/>');
			modificationEnCours = 1;
			jQuery(".nomDocument input").blur(function(){
				jQuery(this).parent().html(jQuery(this).val());
				
				jQuery.ajax({ type: "GET", 
					url: "gestionDocumentsAjax.php?action=modifier&id="+id+"&new="+jQuery(this).val(),
    				success:function(data){
    					modificationEnCours = 0;
        			}
    			});				
				
			});
		}
	});
	
});