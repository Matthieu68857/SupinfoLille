jQuery(document).ready(function() {
	
	function textReplacement(input){
		var originalvalue = input.val();
 
 		input.focus( function(){
 			if( $.trim(input.val()) == originalvalue ){ input.val(''); }
 		});
 		
 		input.blur( function(){
  			if( $.trim(input.val()) == '' ){ input.val(originalvalue); }
 		});
	}	
	
	textReplacement(jQuery("#recherche_student input[name=recherche_student]"));
	
	var countAjaxRecherche = 0;
	
	function rechercheStudent(initial){
		var actuelCountAjaxRecherche = ++countAjaxRecherche;
		jQuery.ajax({ type: "GET", 
			url: "../etudiants/rechercheStudentAjax.php?recherche="+jQuery("#recherche_student input[name=recherche_student]").val()+"&initial="+initial,
    		success:function(data){
    			if(actuelCountAjaxRecherche == countAjaxRecherche){
        			jQuery("#resultat_recherche").html(data);
    			}
    			jQuery(".students_found").click(function(){
					afficherProfile(jQuery(this).attr('title'));
				});
				
        	}, beforeSend:function(){
        		jQuery("#resultat_recherche").html("<p style='text-align:center;'><img src='../../images/ajax-loader.gif'/></p>");
        	}
    	});
	}
	
	jQuery("#recherche_student input[name=recherche_student_button]").click(function(){
		rechercheStudent();
	})
	
	jQuery("#recherche_student input[name=recherche_student]").keyup(function(){
		rechercheStudent();
	});	
	
	var elem = window.location.href.split('/');
	if(elem[elem.length - 2] == "etudiants"){
		rechercheStudent("true");
	}
	
	var modificationEnCours = 0;
	
	function afficherProfile(id){
		jQuery.ajax({ type: "GET", 
			url: "gestionStudentAjax.php?idbooster="+id,
    		success:function(data){
        		jQuery("#profile_student").html(data);
        		jQuery("#initPass input").click(function(){
					initPass(jQuery(this).attr('title'));
				});
								
				// ------------- PROMOTION
	
				jQuery("#EditPromotion").dblclick(function(){
					if(modificationEnCours == 0){
						modificationEnCours = 1;
						if(jQuery(this).html() == "B3"){
							jQuery(this).html("<select><option value='B1'>B1</option><option value='B2'>B2</option><option selected='selected' value='B3'>B3</option></select>");
						} else if(jQuery(this).html()=="B2"){
							jQuery(this).html("<select><option value='B1'>B1</option><option selected='selected' value='B2'>B2</option><option value='B3'>B3</option></select>");
						} else{
							jQuery(this).html("<select><option value='B1'>B1</option><option value='B2'>B2</option><option value='B3'>B3</option></select>");
						}	
						jQuery("#EditPromotion select").focus();	
						jQuery("#EditPromotion select").blur(function(){
							jQuery(this).parent().html(jQuery(this).val());
			
							jQuery.ajax({ type: "GET", 
								url: "editionStudentAjax.php?idbooster="+jQuery('#boosterEdit').html()+"&what=promo&new="+jQuery(this).val(),
    							success:function(data){
    								modificationEnCours = 0;
        						}
    						});	
						});
					}
				});
	
				// ------------- AUTORISATION
	
				jQuery("#EditVisites").dblclick(function(){
					if(modificationEnCours == 0){
						modificationEnCours = 1;
						jQuery(this).html("<input type='text' value='"+jQuery(this).html()+"'/>");
						jQuery("#EditVisites input").blur(function(){
							jQuery(this).parent().html(jQuery(this).val());
			
							jQuery.ajax({ type: "GET", 
							url: "editionStudentAjax.php?idbooster="+jQuery('#boosterEdit').html()+"&what=visites&new="+jQuery(this).val(),
    							success:function(data){
    								modificationEnCours = 0;
        						}
    						});	
						});
					}
				});
	
				// ------------- VISITES
		
				jQuery("#EditAutorisation").dblclick(function(){
					if(modificationEnCours == 0){
						modificationEnCours = 1;
						if(jQuery(this).html() == "2"){
							jQuery(this).html("<select><option value='0'>Bloqué</option><option value='1'>Étudiant</option><option selected='selected' value='2'>Administrateur</option></select>");
						} else if(jQuery(this).html()=="1"){
							jQuery(this).html("<select><option value='0'>Bloqué</option><option selected='selected' value='1'>Étudiant</option><option value='2'>Administrateur</option></select>");
						} else{
							jQuery(this).html("<select><option value='0'>Bloqué</option><option value='1'>Étudiant</option><option value='2'>Administrateur</option></select>");
						}
						jQuery("#EditAutorisation select").focus();
						jQuery("#EditAutorisation select").blur(function(){
							jQuery(this).parent().html(jQuery(this).val());
			
							jQuery.ajax({ type: "GET", 
								url: "editionStudentAjax.php?idbooster="+jQuery('#boosterEdit').html()+"&what=autorisation&new="+jQuery(this).val(),
    							success:function(data){
    								modificationEnCours = 0;
        						}
    						});	
						});
					}
				});
								
				
        	}, beforeSend:function(){
        		jQuery("#profile_student").html("<br/><br/><br/><p style='text-align:center;'><img src='../../images/ajax-loader.gif'/></p>");
        	}
    	});
	}
	
	jQuery(".students_found").click(function(){
	
		afficherProfile(jQuery(this).attr('title'));
	
	});
		
		// ------------- PROMOTION
	
	jQuery("#EditPromotion").dblclick(function(){
		if(modificationEnCours == 0){
			modificationEnCours = 1;
			if(jQuery(this).html() == "B3"){
				jQuery(this).html("<select><option value='B1'>B1</option><option value='B2'>B2</option><option selected='selected' value='B3'>B3</option></select>");
			} else if(jQuery(this).html()=="B2"){
				jQuery(this).html("<select><option value='B1'>B1</option><option selected='selected' value='B2'>B2</option><option value='B3'>B3</option></select>");
			} else{
				jQuery(this).html("<select><option value='B1'>B1</option><option value='B2'>B2</option><option value='B3'>B3</option></select>");
			}
			jQuery("#EditPromotion select").focus();	
			jQuery("#EditPromotion select").blur(function(){
				jQuery(this).parent().html(jQuery(this).val());
			
				jQuery.ajax({ type: "GET", 
					url: "editionStudentAjax.php?idbooster="+jQuery('#boosterEdit').html()+"&what=promo&new="+jQuery(this).val(),
    				success:function(data){
    					modificationEnCours = 0;
        			}
    			});	
			});
		}
	});
	
		// ------------- AUTORISATION
	
	jQuery("#EditVisites").dblclick(function(){
		if(modificationEnCours == 0){
			modificationEnCours = 1;
			jQuery(this).html("<input type='text' value='"+jQuery(this).html()+"'/>");
			jQuery("#EditVisites input").blur(function(){
				jQuery(this).parent().html(jQuery(this).val());
			
				jQuery.ajax({ type: "GET", 
					url: "editionStudentAjax.php?idbooster="+jQuery('#boosterEdit').html()+"&what=visites&new="+jQuery(this).val(),
    				success:function(data){
    					modificationEnCours = 0;
        			}
    			});	
			});
		}
	});
	
		// ------------- VISITES
		
	jQuery("#EditAutorisation").dblclick(function(){
		if(modificationEnCours == 0){
			modificationEnCours = 1;
			if(jQuery(this).html() == "2"){
				jQuery(this).html("<select><option value='0'>Bloqué</option><option value='1'>Étudiant</option><option selected='selected' value='2'>Administrateur</option></select>");
			} else if(jQuery(this).html()=="1"){
				jQuery(this).html("<select><option value='0'>Bloqué</option><option selected='selected' value='1'>Étudiant</option><option value='2'>Administrateur</option></select>");
			} else{
				jQuery(this).html("<select><option value='0'>Bloqué</option><option value='1'>Étudiant</option><option value='2'>Administrateur</option></select>");
			}
			jQuery("#EditAutorisation select").focus();
			jQuery("#EditAutorisation select").blur(function(){
				jQuery(this).parent().html(jQuery(this).val());
			
				jQuery.ajax({ type: "GET", 
					url: "editionStudentAjax.php?idbooster="+jQuery('#boosterEdit').html()+"&what=autorisation&new="+jQuery(this).val(),
    				success:function(data){
    					modificationEnCours = 0;
        			}
    			});	
			});
		}
	});

	function initPass(idbooster){
		jQuery.ajax({ type: "GET", url: "initStudentPassAjax.php?idbooster="+idbooster,
			success:function(data){
				jQuery("#newPass").html(data);
			}, beforeSend:function(){
        		jQuery("#newPass").html("<img src='../../images/ajax-loader.gif'/>");
        	}
        });
	}

	jQuery("#initPass input").click(function(){
		initPass(jQuery(this).attr('title'));
	});

});