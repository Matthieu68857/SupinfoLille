$(function() {



    $('#chat form').submit(function() {



        var user    = $('#chat input[name=user]').val();



        var message = $('#chat input[name=message]').val();



        $.post('../inclusions/javascript/chat/chat.php5', { 'user':user, 'message':message }, function() {



            refreshChat();



        });



        $('#chat input[name=message]').val('');



        return false;



    });



    

	var actif;

    function refreshChat() {

		clearTimeout(actif);

	 var oldscrollHeight = $("#room").attr("scrollHeight"); //Scroll height before the request  

        $.ajax({



            url: "../inclusions/javascript/chat/chatbox.php", 



			ifModified:true,



            success: function(content){



                $('#room').html(content);

				var newscrollHeight = $("#room").attr("scrollHeight"); //Scroll height after the request  

		           if(newscrollHeight > oldscrollHeight){  

	               $("#room").animate({ scrollTop: newscrollHeight }, 1); } //Autoscroll to bottom of div  

					

            }

		

        });

		actif = setTimeout(refreshChat, 1000);

    }

	

    refreshChat();

});