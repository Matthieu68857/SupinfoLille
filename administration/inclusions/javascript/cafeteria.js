jQuery(document).ready(function() { 
		
	function afficherEditionProduit(produit){
		jQuery.ajax({ type: "GET", 
			url: "affichageEditionProduitAjax.php?produit="+produit,
    		success:function(data){
        		jQuery("#gestionProduit").html(data);
        	}, beforeSend:function(){
        		jQuery("#gestionProduit").html("<p style='text-align:center;'><img src='../../images/ajax-loader.gif'/></p>");
        	}
    	});
	}
	
	jQuery("#liste_produits .type_produit").click(function(){
		jQuery("#liste_produits .type_produit").removeClass("type_produit_selected");
		jQuery(this).addClass("type_produit_selected");
		
		jQuery.ajax({ type: "GET", 
			url: "affichageProduitsAdminAjax.php?categorie="+jQuery(this).attr('title'),
    		success:function(data){	 
				jQuery("#affichage_produits").html(data);
				jQuery("#liste_produits img.editer").click(function(){
					afficherEditionProduit(jQuery(this).attr('title'));
				});			
        	}, beforeSend:function(){
        		jQuery("#affichage_produits").html("<p style='text-align:center;'><img src='../../images/ajax-loader.gif'/></p>");
        	}
    	});
	});
	
	jQuery("#liste_produits img.editer").click(function(){
		afficherEditionProduit(jQuery(this).attr('title'));
	});
	
	/* ############################## BADGES ############################## */
	
	jQuery("#check_badges input[type=button]").click(function(){
		jQuery.ajax({ type: "GET", 
			url: "affichageCheckBadgesAjax.php",
    		success:function(data){	 
				jQuery("#check_badges #resultats").html(data);		
        	}, beforeSend:function(){
        		jQuery("#check_badges #resultats").html("<p style='text-align:center;'><img src='../../images/ajax-loader.gif'/></p>");
        	}
    	});
	});
	
	/* ############################ LIVE CAFETERIA ############################ */
	
	jQuery("#live input[type=button]").click(function(){
		var heures = jQuery("#live input[name=heures]").val();
		var minutes = jQuery("#live input[name=minutes]").val();
		if(heures != "" && minutes != ""){
			location.href='liveCafeteria.php?heures='+heures+'&minutes='+minutes;
		}
	});
	
	var date = jQuery("#live input[type=hidden]").val();
	
	var elem = window.location.href.split('/');
	if(elem[elem.length - 2] == "cafeteria"){
		setInterval(function() { updateLive(date); }, 1000);
	}
	
	function updateLive(actuel){
		jQuery.ajax({ type: "GET", 
			url: "liveCafeteriaAjax.php?date=actuel",
    		success:function(data){	 
				jQuery("#liveTable").html(data);		
        	}
    	});
	}

});