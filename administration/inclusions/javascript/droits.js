jQuery(document).ready(function(){

	jQuery('.bouton').button();
	
	// Va chercher les categorie dans la BDD
	jQuery(".auto_complete_categories").autocomplete({
        source: "categoriesJSON.php",
        minLength: 2,
        focus: function(event, ui) {
            jQuery(this).val(ui.item.label);
            return false;
        },
        select: function(event, ui) {
            jQuery(this).val(ui.item.label);
            jQuery(this).next().val(ui.item.value);
            return false;
        }
    });
    
    // Va chercher les utilisateurs dans la BDD
	jQuery(".auto_complete_utilisateurs").autocomplete({
        source: "utilisateursJSON.php",
        minLength: 2,
        focus: function(event, ui) {
            jQuery(this).val(ui.item.label);
            return false;
        },
        select: function(event, ui) {
            jQuery(this).val(ui.item.label);
            jQuery(this).next().val(ui.item.value);
            return false;
        }
    });
    
    // Va chercher les groupes dans la BDD
    jQuery(".auto_complete_groupes").autocomplete({
        source: "groupesJSON.php",
        minLength: 2,
        focus: function(event, ui) {
            jQuery(this).val(ui.item.label);
            return false;
        },
        select: function(event, ui) {
            jQuery(this).val(ui.item.label);
            jQuery(this).next().val(ui.item.value);
            if(jQuery('#groupe_id').val() != 0 || jQuery('#groupe_id').val() != 'undefined'){
            	modifierGroupe();
            } else {
            	jQuery('#groupe_categories, #groupe_membres').hide();
            }
            return false;
        }
    });
    
    jQuery('#groupe_categories, #groupe_membres').hide();
    
    function modifierGroupe(){
    	majCategories();
    	majMembres();
    	jQuery('#groupe_categories, #groupe_membres').show();
    }
    
    function majCategories(){
    	jQuery.ajax({ type: "POST", url: "gestionGroupeAjax.php",
    		data: "action=get_categories&id=" + jQuery('#groupe_id').val(),
    		success:function(data){
   				jQuery('#categories_actuelle').html(data);
    		}
    	});
    }
    
    function majMembres(){
    	jQuery.ajax({ type: "POST", url: "gestionGroupeAjax.php",
    		data: "action=get_membres&id=" + jQuery('#groupe_id').val(),
    		success:function(data){
   				jQuery('#membres_actuel').html(data);
    		}
    	});
    }
    
    // Ajouter une nouvelle catégorie
    jQuery('#nouvelle_categorie').click(function(){
    	if(jQuery('#nouvelle_categorie_admin').attr('checked') == true){
    		var admin = "1";
    	} else {
    		var admin = "0";
    	}
    	if(jQuery('#nouvelle_categorie_value').val() != ''){
    		jQuery.ajax({ type: "POST", url: "gestionCategorieAjax.php",
    			data: "action=nouvelle_categorie&nom=" + jQuery('#nouvelle_categorie_value').val() + "&admin=" + admin,
    			success:function(data){
    				jQuery('#nouvelle_categorie_value').val('');
    				jQuery('#nouvelle_categorie_id').val('');
    				jQuery('#nouvelle_categorie_admin').attr('checked','');
    			}
    		});
    	}
    });
    
    // Supprime une ancienne catégorie
    jQuery('#ancienne_categorie').click(function(){
    	if(jQuery('#ancienne_categorie_value').val() != ''){
    		jQuery.ajax({ type: "POST", url: "gestionCategorieAjax.php",
    			data: "action=ancienne_categorie&id=" + jQuery('#ancienne_categorie_id').val(),
    			success:function(data){
    				jQuery('#ancienne_categorie_value').val('');
    				jQuery('#ancienne_categorie_id').val('');
    			}
    		});
    	}
    });
    
    // Ajoute un nouveau groupe
    jQuery('#nouveau_groupe').click(function(){
    	if(jQuery('#nouveau_groupe_value').val() != ''){
    		jQuery.ajax({ type: "POST", url: "gestionGroupeAjax.php",
    			data: "action=nouveau_groupe&nom=" + jQuery('#nouveau_groupe_value').val(),
    			success:function(data){
    				jQuery('#nouveau_groupe_value').val('');
    				jQuery('#nouveau_groupe_id').val('');
    			}
    		});
    	}
    });
    
    // Supprime un ancien groupe
    jQuery('#ancien_groupe').click(function(){
    	if(jQuery('#ancien_groupe_value').val() != ''){
    		jQuery.ajax({ type: "POST", url: "gestionGroupeAjax.php",
    			data: "action=ancien_groupe&id=" + jQuery('#ancien_groupe_id').val(),
    			success:function(data){
    				jQuery('#ancien_groupe_value').val('');
    				jQuery('#ancien_groupe_id').val('');
    			}
    		});
    	}
    });
    
    // Modification groupe
    jQuery('.action_modification_groupe').click(function(){
    	var item = jQuery(this).attr('id');
    	if(item == "ajouter_membre_bouton" || item == "retirer_membre_bouton"){
    		var id = jQuery('#utilisateur_id').val();
    	} else if(item == "ajouter_categorie_bouton" || item == "retirer_categorie_bouton"){
    		var id = jQuery('#ajouter_categorie_id').val();
    	}
    	jQuery.ajax({ type: "POST", url: "gestionGroupeAjax.php", data: "action=" + item + "&idGroupe=" + jQuery('#groupe_id').val() + "&id=" + id,
    		success:function(data){
    			if(item == "ajouter_membre_bouton" || item == "retirer_membre_bouton"){
		    		majMembres();
		    		jQuery('#utilisateur_id').val('');
		    		jQuery('#ajouter_utilisateur').val('');
		    	} else if(item == "ajouter_categorie_bouton" || item == "retirer_categorie_bouton"){
		    		majCategories();
		    		jQuery('#ajouter_categorie_id').val('');
		    		jQuery('#ajouter_categorie').val('');
		    	}
    		}
    	});
    });
});