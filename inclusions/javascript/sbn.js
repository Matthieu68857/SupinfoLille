jQuery(document).ready(function(){
	
	activeLien();
	
	jQuery('.recherche').keyup(function(){
		rechercher();
	});
	
	jQuery('.rechercheSelect').change(function(){
		rechercher();
	});
	
	jQuery('#datepicker').datepicker({ dateFormat: 'dd / mm / yy' });
	
	function activeLien(){
		jQuery('.lien').click(function(){
			window.open(jQuery(this).attr("href"));
			return false;
		});
	}
	
	function rechercher(){
		jQuery.ajax({
			type: "POST", 
			url: "ajax.php", 
			data: 
				'page=' + jQuery('#recherchePage').val() + 
				'&nom=' + jQuery('#rechercheNom').val() + 
				'&ville=' + jQuery('#rechercheVille').val() + 
				'&thematique=' + jQuery('#rechercheThematique').val(),
			beforeSend:function(){
				jQuery('#loader').css('visibility','visible');
			},
			success:function(data){
				jQuery('#entreprises').html(data);
				activeLien();
				jQuery('#loader').css('visibility','hidden');
			}
		});
	}
	
});