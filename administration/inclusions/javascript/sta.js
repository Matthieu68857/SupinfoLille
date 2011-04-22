jQuery(document).ready(function() {
	
	// Outils pour les STAs
	
	jQuery("#randomSujet input[type=button]").click(function(){
		jQuery("#randomSujetReponse").css("display","block");
		jQuery.ajax({ type: "GET", 
			url: "staAjax.php?outil=randomSujet&borneInf="+jQuery("#borneInf").val()+"&borneSup="+jQuery("#borneSup").val(),
    		success:function(data){
				jQuery("#randomSujetReponse").html(data);
        	}, beforeSend:function(){
        		jQuery("#randomSujetReponse").html("<p style='text-align:center;'><img src='../../images/ajax-loader.gif'/></p>");
        	}
    	});
	
	});
	
	jQuery("#randomStudent input[type=button]").click(function(){
		jQuery("#randomStudentReponse").css("display","block");
		jQuery.ajax({ type: "GET", 
			url: "staAjax.php?outil=randomStudent&methode="+jQuery('#randomStudent #selectMethode input:radio:checked').val()+ "&promo="+jQuery('#randomStudent #selectPromo input:radio:checked').val(),
    		success:function(data){
				jQuery("#randomStudentReponse").html(data);
        	}, beforeSend:function(){
        		jQuery("#randomStudentReponse").html("<p style='text-align:center;'><img src='../../images/ajax-loader.gif'/></p>");
        	}
    	});
	
	});
	
});