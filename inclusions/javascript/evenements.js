jQuery(document).ready(function() {	

	//  *************** Animation des événements ***************
	
	var inscriptionEventEnCours = 0;
	
	function inscrireOuPasEvent(parent, event){
		if(inscriptionEventEnCours == 0){
			inscriptionEventEnCours = 1;
			jQuery.ajax({ type: "GET", 
				url: "participationEvenementsAjax.php?evenement="+event.attr('title')+"&action="+event.attr('class'),
    			success:function(data){
        			parent.html(data);
        		
        			jQuery.ajax({ type: "GET", 
						url: "participationEvenementsAjax.php?evenement="+event.attr('title')+"&action=participants",
    					success:function(data){
        					jQuery("#participants_"+event.attr('title')).html(data);
        				}
    				});
    				
    				jQuery.ajax({ type: "GET", 
						url: "participationEvenementsAjax.php?evenement="+event.attr('title')+"&action=printparticipants",
    					success:function(data){
        					jQuery("#ilsparticipent_"+event.attr('title')).html(data);
        				}
    				});
    				
    				inscriptionEventEnCours = 0;
        		
        			jQuery(".event_header p span span").click(function(){
						inscrireOuPasEvent(jQuery(this).parent(), jQuery(this));
					});
        		}
    		});
		}
	}
	
	jQuery(".event_header p span span").click(function(){
		inscrireOuPasEvent(jQuery(this).parent(), jQuery(this));
	});
	
});