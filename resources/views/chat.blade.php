@extends('layouts.chat')

@section('styles')
<style class="">
	
	*{
		padding:0px;
		margin:0px;
		border: 0px;
	}

	body {

		background: silver;
	}

	#container {

		width:40%;
		background: white;
		margin:0 auto;
		padding: 20px;
		
	}

	#chat_box {

		width: 90%;
		height: 500px !important;
		
	}

	input[type='text']{

		width: 100%;
		height: 40px;
		border: 1px solid gray;
		border-radius: 5px;
		margin-top: 5px;

	}

	input[type='submit']{

		width: 100%;
		height: 40px;
		border: 1px solid gray;
		border-radius: 5px;
		background: green;
		
	}

	textarea{

		width: 100%;
		height: 40px;
		border: 1px solid gray;
		border-radius: 5px;
		margin-top: 5px !important;
		
	}

	#chat_data {

		width: 100%;
		padding: 5px;
		margin-bottom: 5px;
		border-bottom: 1px solid silver;
		font-weight: bold;
	}
</style>
@endsection

@section('scripts')



<script class="">

$(document).ready(function(){

	// Kad brisemo slova kod pretrage

		

			$('#search').keydown(function(event){

				var key = event.keyCode || event.charCode;

				if(key == 8 || key == 46 ){

					$('.user').remove();
				}
			});



	// Pretraga

			    $( '#search' ).keyup(function() {
 
       
 
				        $.post(
				            '/chat',
				            {

				            	"_token": $('#search-form').find( 'input[name=_token]' ).val(),
				                search: $( '#search' ).val()
				                
				            },
				            function( data ) {
				                //do something with data/response returned by server

							                if(!data.error){

							                		$('#result .user').remove();
							                		$('#result').append(data.users);
													$('#code').html(data.code);
							                	
												}
				            }
				                    );
 
       
			        return false;
			    } );

	// Posalji poruku

			  		  $( '#send-form' ).submit(function(e) {
 
       					e.preventDefault();

					        $.post(
					            '/send',
					            {

					            	"_token": $('#send-form').find( 'input[name=_token]' ).val(),
					                "message": $('#send-form').find('textarea[name=message]').val()
					                
					            },
					            function( data ) {
					                //do something with data/response returned by server

								                if(!data.error){

														// $('#result ').append(data.users);
														// $(data.code).insertAfter('#result');

														$('#send-form').find('textarea[name=message]').val('');

													}
					            }
					                    );
 
       
					        return false;
					   } );


	  //instantiate a Pusher object with our Credential's key

		      var pusher = new Pusher('96d73fc3ac2a47842664', {
		          cluster: '',
		          encrypted: true
		      });

      //Subscribe to the channel we specified in our Laravel Event

		      var channel = pusher.subscribe('chat');

      //Bind a function to a Event (the full Laravel class)

		      channel.bind('App\\Events\\WhoIsTyping', addMessage);

		      function addMessage(data) {

		      	var status = data.message;

		        $("#isTyping").text(status);

		      }



			 
});
	

</script>

@endsection