jQuery(document).ready(function() {	

	// *************** Ajax pour l'affichage d'un profil après recherche ***************
	
	function afficherProfile(id){
		jQuery.ajax({ type: "GET", 
			url: "affichageProfileStudentAjax.php?idbooster="+id,
    		success:function(data){
        		jQuery("#profile_student").html(data);
        		jQuery("#profile_student #compte_infos img").click(function(){
					afficherInformationsSociales(jQuery(this).attr('title'));
				});
        	}, beforeSend:function(){
        		jQuery("#profile_student").html("<br/><br/><br/><p style='text-align:center;'><img src='../images/ajax-loader.gif'/></p>");
        	}
    	});
	}
	
	jQuery(".students_found").click(function(){
	
		afficherProfile(jQuery(this).attr('title'));
	
	});
	
	function afficherInformationsSociales(icone){
		
		jQuery("#resultats_sociaux").html(jQuery("#compte_infos input[name="+ icone +"]").val());		
	
	}
	
	jQuery("#profile_student #compte_infos img").click(function(){
	
		afficherInformationsSociales(jQuery(this).attr('title'));
	
	});
	
	// *************** Ajax pour la recherche d'un student ***************
	
	var countAjaxRecherche = 0;
	
	function rechercheStudent(initial){
		var actuelCountAjaxRecherche = ++countAjaxRecherche;
		jQuery.ajax({ type: "GET", 
			url: "rechercheStudentAjax.php?recherche="+jQuery("#recherche_student input[name=recherche_student]").val()+"&initial="+initial,
    		success:function(data){
    			if(actuelCountAjaxRecherche == countAjaxRecherche){
        			jQuery("#resultat_recherche").html(data);
    			}
    			jQuery(".students_found").click(function(){
					afficherProfile(jQuery(this).attr('title'));
				});
				
        	}, beforeSend:function(){
        		jQuery("#resultat_recherche").html("<p style='text-align:center;'><img src='../images/ajax-loader.gif'/></p>");
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
	
});