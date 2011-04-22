jQuery(document).ready(function() { 
	
	// animation pour les encarts 
	
	jQuery(".encart").stop().hover(function(){
		jQuery(this).children().stop().fadeTo(400, 1);
	}, function(){ 
		jQuery(this).children().stop().fadeTo(400, 0); 
	});

});