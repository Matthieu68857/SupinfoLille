jQuery(document).ready(function() {
		
	jQuery(".modifier_entraide").click(function(){
		jQuery.ajax({ type: "GET", 
			url: "editerEntraideAjax.php?id="+jQuery(this).attr('title'),
    		success:function(data){
				jQuery("#edition_event").html(data);
				jQuery("#editer_evenements input[name=date]").datepicker({ dateFormat: 'yy-mm-dd' });
        	}
    	});
	});
	
});