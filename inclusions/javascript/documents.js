jQuery(document).ready(function() {	

	// *************** Uploadify pour la page propoderDocument.php ***************
	
	var firstUpload = 0;
		
	jQuery('#file_upload').uploadify({
    	'uploader'  : '../inclusions/javascript/uploadify/uploadify.swf',
    	'script'    : '../inclusions/javascript/uploadify/uploadify.php',
    	'cancelImg' : '../inclusions/javascript/uploadify/cancel.png',
    	'buttonImg' : '../images/select_file.jpg',
    	'folder'    : '/documents/uploads',
    	'sizeLimit' : 10485760,
    	'onComplete'  : function(event, ID, fileObj, response, data) {
    		var matiere = jQuery("#file_matiere").val();
    		var nom = jQuery("#file_name").val();
      		jQuery.ajax({ type: "GET", 
				url: "ajoutDocumentAjax.php?chemin="+fileObj.name+"&nom="+nom+"&matiere="+matiere,
    			success:function(retour){
        		}
    		});
    		jQuery("#file_matiere").val(1);
    		jQuery("#file_name").val("");
    		firstUpload = 0;
    		jQuery("#proposerDocument h2 div").hide();
    		jQuery("#texteProposer")
    			.html("<span style='color:green'>Votre document a bien été proposé. Il sera validé (ou pas) par les administrateurs.</span>");
    	}, 
    	'onOpen'    : function(event,ID,fileObj) {
    		if(firstUpload == 0){
    			jQuery("#proposerDocument h2 div").show();
    			firstUpload = 1;
    		}
    	},
    	'onError'     : function (event,ID,fileObj,errorObj) {
      		jQuery("#texteProposer")
      			.html("<span style='color:red'>Une erreur est survenue lors de l'upload. Veuillez recommencer s'il vous plait. La taille maximum d'un fichier est de 10Mo.</span>");
    	}
 	});
 	
 	jQuery("#button_file_upload").click(function(){
 		jQuery('#file_upload').uploadifyUpload();
 	});

	// *************** Jquery UI pour la page Documents ***************
	
	jQuery(".choix_promo").click(function(){
	
		jQuery.ajax({ type: "GET", 
			url: "documentsAjax.php?section=matieres&promo="+jQuery(this).text(),
    		success:function(data){
        		jQuery("#liste_matieres").html(data);
        		jQuery(".matiere").click(function(){
					afficherDocuments(jQuery(this).attr('title'));
					jQuery("#matiere_en_cours").html(jQuery(this).text());
				});
        	}, beforeSend:function(){
        		jQuery("#liste_matieres").html("<p style='text-align:center;'><img src='../images/ajax-loader2.gif'/></p>");
        	}
    	});
		
	});
	
	function afficherDocuments(matiere_id){
		
		jQuery.ajax({ type: "GET", 
			url: "documentsAjax.php?section=documents&matiere="+matiere_id,
    		success:function(data){
        		jQuery("#liste_documents").html(data);
        		jQuery( ".document" ).draggable({
					appendTo: "body",
					helper: "clone"
				});
				jQuery( ".document" ).dblclick(function(){
        			window.location.replace("telecharger.php?section=ddl&document="+jQuery(this).attr('title'));
    			});
        	}, beforeSend:function(){
        		jQuery("#liste_documents").html("<p style='text-align:center;'><img src='../images/ajax-loader2.gif'/></p>");
        	}
    	});
	
	}
	
	jQuery(".matiere").click(function(){
	
		afficherDocuments(jQuery(this).attr('title'));
		jQuery("#matiere_en_cours").html(jQuery(this).text());
	
	});
	
	jQuery("#liste_telechargements").droppable({
		activeClass: "liste_telechargements_active",
		hoverClass: "liste_telechargements_hover",
		accept: ".document",
		drop: function( event, ui ) {
			jQuery( this ).find( ".placeholder" ).remove();
			jQuery( "<li title='"+ui.draggable.attr("title")+"'></li>" ).text( ui.draggable.text() ).appendTo( this );
		}
	});
	
	jQuery("#bouton_telecharger").click(function(){
	
		if(jQuery("#liste_telechargements li").size() != 0){
		
			var documents = ""; 
	
			jQuery("#liste_telechargements li").each(function(){
				documents = documents + jQuery(this).attr("title") + "a"; 
			});
			
			window.location.replace("telecharger.php?section=telechargements&documents=" + documents.substring(0, documents.length - 1));
		}
	
	});
	
	function viderTelechargements(){
		jQuery("#liste_telechargements")
		.html('<span class="placeholder">Drag&Dropper ici les fichiers que vous voulez télécharger.</span>');
	}
	
	jQuery("#bouton_vider").click(function(){
		viderTelechargements();
	});
	
	jQuery("#bouton_proposer").click(function(){
		window.location.replace("proposerDocument.php");
	});
	
});