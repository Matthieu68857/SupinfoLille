jQuery(document).ready(function() {
	
	// animation la gestion des events et entraide
	
	jQuery("#editer_evenements input[name=date]").datepicker({ dateFormat: 'yy-mm-dd' });
	
	jQuery("#liste_evenements .modifier_event").click(function(){
		jQuery.ajax({ type: "GET", 
			url: "editerEvenementAjax.php?id="+jQuery(this).attr('title'),
    		success:function(data){
				jQuery("#edition_event").html(data);
				jQuery("#editer_evenements input[name=date]").datepicker({ dateFormat: 'yy-mm-dd' });
        	}
    	});
	
	});
	
	jQuery("#liste_evenements h2 div").click(function(){
		jQuery.ajax({ type: "GET", 
			url: "editerEvenementAjax.php?creation=true",
    		success:function(data){
				jQuery("#edition_event").html(data);
				jQuery("#editer_evenements input[name=date]").datepicker({ dateFormat: 'yy-mm-dd' });
        	}
    	});
	
	});
	
});