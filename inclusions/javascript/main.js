jQuery(document).ready(function() {	

	//  *************** Affichage des personnes connectées ***************

	setInterval(function() { updateConnectes(); }, 3000);
	
	function updateConnectes(){
		jQuery.ajax({ type: "GET", 
			url: "../connexion/affichageConnectesAjax.php",
    		success:function(data){
        		jQuery("#connectes").html(data);
        	}
    	});
	}
	
	 // *************** Notifications nouvelles personnes connectées ***************

	setInterval(function() { updateNotifConnectes(); }, 3000);
	
	function updateNotifConnectes(){
		jQuery.ajax({ type: "GET", 
			url: "../connexion/notificationConnectesAjax.php",
    		success:function(data){	 
				jQuery(data).purr(
					{
						usingTransparentPNG: true
					}
				);				
        	}
    	});
	}

	// *************** Animation pour les input text ***************
	
	function textReplacement(input){
		var originalvalue = input.val();
 
 		input.focus( function(){
 			if( $.trim(input.val()) == originalvalue ){ input.val(''); }
 		});
 		
 		input.blur( function(){
  			if( $.trim(input.val()) == '' ){ input.val(originalvalue); }
 		});
	}	
	
	textReplacement(jQuery("#connexion input[name=idbooster]"));
	textReplacement(jQuery("#connexion input[name=pass]"));
	textReplacement(jQuery("#recherche_student input[name=recherche_student]"));
	textReplacement(jQuery("#cafet-input"));	

	// *************** Animation des encarts ***************
		
	jQuery(".encart").stop().hover(function(){
		jQuery(this).children().stop().fadeTo(400, 1);
	}, function(){ 
		jQuery(this).children().stop().fadeTo(400, 0); 
	});
						
});
