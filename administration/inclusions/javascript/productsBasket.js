// JavaScript Document : plugin jQuery : Produits SupLille

function productsBasket() {	
		
			$("#cafet-products ul li").hover(function() {
				$(this).children('span').show();
			}, function() {
				$(this).children('span').hide();	
			});
			 $("#cafet-input").click(function() {
			 	$(this).val('');
			 });
			 
			 
			 
	function rechercheStudentCafet(){
		jQuery.ajax({ type: "GET", 
			url: "../cafeteria/rechercheStudentCafetAjax.php?recherche="+jQuery("#cafet-form input").val(),
    		success:function(data){
    			
        			jQuery("#cafet-student").html(data);
					$("#payer").show()
				
        	}, beforeSend:function(){
        		jQuery("#cafet-student").html("<p style='text-align:center;'><img src='../../images/ajax-loader.gif'/></p>");
        	}
    	});
	}
	
	if($("#cafet-form input") != "Entrez un ID Booster...") { rechercheStudentCafet()};
	
	$("#cafet-form input").live("keyup", function(e) {
    if(e.keyCode == 13) {
        rechercheStudentCafet();
    }
	});
	
	jQuery("#cafet-form button").click(function(){
		rechercheStudentCafet();
		return false;
	})
	
	
	function addProduct(id) {
		
							jQuery.ajax({ type: "GET", 
				url: "rechercheProduitAjax.php?id=" + id,
				success:function(data){
						data = data.split('_');
						prix = data[0];
						nom = data[2];
						$('#cafet-basket ul').append('<li class="' + id + '"><img src="../../images/cafeteria/' + id + '.jpg" class="item" /> <span class="item-text">' + nom + '</span><span class="price">' + prix + '</span></li>');
						$("#cafet-basket").css('border', '2px dashed #2FF');
						$("#total").fadeOut(500);
						prix = parseFloat(prix);
						ancienprix = parseFloat($("#total").text());
						$("#total").text((ancienprix + prix).toFixed(1));
						$("#total").fadeIn(500);
						}
					});
					
					
	}
	
	
/***************** Panier *************************/



			// Les produits dans le panier sont draggables et sortables
			$($('#cafet-basket ul')).sortable({
				axis: "y", 
				containment: "#cafet-basket", 
				handle: ".item-text", 
				distance: 10,
			});
			
			// Ajout de la poubelle au panier
			$($('#cafet-basket ul')).after("<div class='trash'>Poubelle</div>");
								
			// La poubelle est droppable
			$(".trash").droppable({
				drop: function(event, ui){
					prix = ui.draggable.children("span.price").text()
					$(this).removeClass("hover");
					$(this).addClass("deleted");
					$("#total").fadeOut(500);
						prix = parseFloat(prix);
						ancienprix = parseFloat($("#total").text());
						$("#total").text((ancienprix - prix).toFixed(1));
						$("#total").fadeIn(500);
					$(this).text("Article "+ ui.draggable.find(".item-text").text()+" supprimé !");
					setTimeout(function() { ui.draggable.remove(); }, 1);
					elt = $(this);
					setTimeout(function(){ elt.removeClass("deleted"); elt.text("Poubelle"); }, 2000);
				},
				over: function(event, ui){
					$(this).addClass("hover");
					ui.draggable.hide();
					$(this).text("Retirer l'article "+ui.draggable.find(".item-text").text() + " ?");
					$(this).css("cursor", "pointer");
				},
				out: function(event, ui){ 
					$(this).removeClass("hover");
					ui.draggable.show();
					$(this).text("Poubelle");
					$(this).css("cursor", "normal");
				} 
			})	 
			
			
			// Le panier est droppable
			$("#cafet-basket").droppable({
				drop: function(event, ui){		
					id = ui.draggable.children("img").attr("title");
					addProduct(id);					
				},
				over: function(event, ui){
					$("#cafet-basket").css('border', '2px solid #A1C117');
				},
				out: function(event, ui){ 
					$("#cafet-basket").css('border', '2px dashed #666');
				} 
			})
			
			
			
			
/************* Produits **************************/
		
		
			// Les produits sont draggables
			$( "#cafet-products li" ).draggable({
				helper: "clone",
			});
			
			// Le produit s'ajoute au panier avec un Double click
			$( "#cafet-products li" ).dblclick(function() {
				id = $(this).children("img").attr("title");
				addProduct(id);
			});
			
			
			
/************** Validation ****************************/
		$("#payer").click(function() {
			student = $(".student_found").attr("title");
			
			$("#cafet-basket li").each(function() {	
			id = $(this).attr("class");
			jQuery.ajax({ type: "GET", 
					url: "validateBasketItemAjax.php?id=" + id + "&student=" + student,
					success:function(data){
							}
						});
			});
			
			jQuery.ajax({ type: "GET", 
					url: "validateBasketPriceAjax.php?total=" + parseFloat($("#total").text())  + "&student=" + student,
					success:function(data){
						$("#payer").fadeOut(500);
						$("#payer").text("Bonne dégustation !");
						$("#payer").fadeIn(500);
							}
			});
		});
		

};
