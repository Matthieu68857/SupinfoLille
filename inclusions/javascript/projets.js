jQuery(document).ready(function() {

	// *************** Animation pour l'ajout de projets ***************
	
	jQuery("#addProjet input, #addProjet select, #addProjet textarea").focus(function(){
		jQuery("#addProjet h1, #addProjet h3").css("color","#474747");
		jQuery(this).parent().children("h1, h3").css("color","#A1C117");
	});
	
	jQuery("#addProjet input, #addProjet select, #addProjet textarea").blur(function(){
		jQuery(this).parent().children("h1, h3").css("color","#474747");
	});

	// *************** Affichage des projets en Ajax ***************
	
	jQuery("#categories div").click(function(){
		jQuery("#categories div").removeClass("categorie_actuelle");
		jQuery(this).addClass("categorie_actuelle");
	
		jQuery.ajax({ type: "GET", 
			url: "affichageProjetsAjax.php?categorie="+jQuery(this).attr('title'),
    		success:function(data){	 
				jQuery("#affichageProjets").html(data);			
        	}, beforeSend:function(){
        		jQuery("#affichageProjets").html("<p style='text-align:center;'><img src='../images/ajax-loader.gif'/></p>");
        	}
    	});
	});

});