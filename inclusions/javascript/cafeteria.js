jQuery(document).ready(function() {

	// *************** Animation pour les badges ***************
	
	var ongletActuel = "Tous les badges";
	
	jQuery("#menuListeBadges .choix").click(function(){
		jQuery("#menuListeBadges .choix").removeClass("selected");
		jQuery(this).addClass("selected");
		
		var onglet = jQuery(this).attr('title');
		
		if(onglet == "Tous les badges"){
			ongletActuel = "Tous les badges";
			jQuery("#listeBadges #affichageStats").hide();
			jQuery("#listeBadges #affichagePotentiel").hide();
			jQuery("#listeBadges #affichageBadges").show();
			jQuery("#listeBadges .badge img.badgeImage").each(function(e){
				this.src = "../images/badges/"+ this.alt +".png";
			});
		} else if(onglet == "Mes badges"){
			ongletActuel = "Mes badges";
			jQuery("#listeBadges #affichageStats").hide();
			jQuery("#listeBadges #affichagePotentiel").hide();
			jQuery("#listeBadges #affichageBadges").show();
			jQuery("#listeBadges .badge.defaut img.badgeImage").attr("src","../images/badges/defaut.png");
		} else if(onglet == "Mon potentiel") {
			ongletActuel = "Mon potentiel";
			jQuery("#listeBadges #affichageBadges").hide();
			jQuery("#listeBadges #affichageStats").hide();
			jQuery("#listeBadges #affichagePotentiel").show();
		} else if(onglet == "Statistiques"){
			ongletActuel = "Statistiques";
			jQuery("#listeBadges #affichageBadges").hide();
			jQuery("#listeBadges #affichagePotentiel").hide();
			jQuery("#listeBadges #affichageStats").show();
		}
	});
	
	jQuery("#listeBadges #affichageBadges .defaut img.badgeImage").hover(function(){
		if(ongletActuel == "Mes badges"){
			jQuery(this).attr("src","../images/badges/"+ this.alt +".png");
		}
	}, function(){
		if(ongletActuel == "Mes badges"){
			jQuery(this).attr("src","../images/badges/defaut.png");
		}
	});
	
	jQuery("#listeBadges #affichagePotentiel .progressbar").each(function(e){
		var pt = jQuery(this).attr("title");
		jQuery(this).progressbar({
			value: parseInt(pt)
		});
	});
	
	jQuery("#listeBadges .badge img.badgeImage").hover(function(){
		
		var contenu = jQuery(this).next().html();
		
		jQuery(this).qtip({
        	content: contenu, 
           	position: {
            	corner: {
                	target: 'topLeft',
      				tooltip: 'bottomRight'
           	    }
           	},
           	show: {
           		when: false,
           		ready: true
           	},
           	hide: false,
           	style: {
           		border: {
           	    	width: 3,
           	        radius: 10
            	},
           	    padding: 10, 
           	    width: 230,
           	    textAlign: 'center',
           	    tip: true,
           	    name: 'dark'
           	}
    	})
	}, function(){
		jQuery(this).qtip("destroy");
	});

	// *************** Animation pour la cafeteria ***************
	
	jQuery("#solde_historique_cafeteria tr, #cafeteria tr, #cafeteria_stats tr").hover(function(){
		jQuery(this).css("background","#F0F0F0");
	},function(){
		jQuery(this).css("background","inherit");
	});
	
	jQuery("#cafeteria .type_produit").click(function(){
		jQuery("#cafeteria .type_produit").removeClass("type_produit_selected");
		jQuery(this).addClass("type_produit_selected");
		
		jQuery.ajax({ type: "GET", 
			url: "affichageProduitsAjax.php?categorie="+jQuery(this).attr('title'),
    		success:function(data){	 
				jQuery("#affichage_produits").html(data);			
        	}, beforeSend:function(){
        		jQuery("#affichage_produits").html("<p style='text-align:center;'><img src='../images/ajax-loader.gif'/></p>");
        	}
    	});
	});

});