jQuery(document).ready(function(){
	
	activeLien();
	
	jQuery('.rechercheAdmin').keyup(function(){
		rechercherAdmin();
	});
	
	jQuery('.rechercheAdminSelect').change(function(){
		rechercherAdmin();
	});
	
	jQuery('#datepickerSBN').datepicker({ dateFormat: 'dd/mm/yy' });
	
	jQuery('#supprimerEntree').click(function(){
		jQuery("#dialog-confirm").dialog({
			resizable: false,
			height:175,
			modal: true,
			buttons: {
				Annuler: function() {
					jQuery(this).dialog("close");
				},
				Supprimer: function() {
					jQuery(this).dialog("close");
					jQuery('#formSupprimer').submit();
				}
			}
		});
	});
	
	jQuery('.supprimerDoublon').click(function(){
		jQuery(this).parent().submit();
	});
	
	function activeLien(){
		jQuery('.lien').click(function(){
			window.open(jQuery(this).attr("href"));
			return false;
		});
	}
	
	function rechercherAdmin(){
		jQuery.ajax({
			type: "POST", 
			url: "ajax.php", 
			data: 
				'page=' + jQuery('#recherchePage').val() + 
				'&id=' + jQuery('#rechercheId').val() + 
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