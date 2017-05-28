<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AdminRequest;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Events\WhoIsTyping;

use App\User;
use App\Chat1;
use App\TypeStatus;


class ChatController extends Controller
{
    //

    public function search(AdminRequest $request){

    	$search = $request->input('search');



    if(!empty($search)){

          $users = User::where('name','like','%'.$search.'%')->paginate(1);
      

              if($users->count()>0){

                  $a='';

                   foreach ($users as $user) {
                      # code...

                    if($user->name != Auth::user()->name){

                      global $a;

                      $a .= "<a href='javascript:void(0)' class='user'>$user->name</a>

                        <input type='hidden' value= '$user->id' name='id' class='user'>";
                    }

                    

                    }

                 


        $code = <<<DELIMITER

       <SCRIPT>

    
       var typedCounter = 0.00;
       var timer=1000;

       $(document).ready(function(){

			

				$('a.user').on('click',function(e){

       			e.preventDefault();

       			var value = $('#result').find( 'input[name=id]' ).val();

       			$('#poruke').val(value);

       			$(this).hide();
       			$('#search').val('');

       			setInterval(previous_communication,1000);

					 });

        $('#typing').keyup(function(event){


          clearTimeout(timer);

          timer = setTimeout(function(){

             $.post('/typing',

                    {

                      "_token": $('#search-form').find( 'input[name=_token]' ).val(),
                      "id":$("#user_id").val(),
                      "message":""

                    },

                    function(data){

                       
                    }

              );

          },1000)

          if (event.keyCode >= 65 && event.keyCode <= 90) {

            typedCounter += 0.5;

          }
          

          if(typedCounter > 3) {

            typedCounter = 0;

            setTimeout(function(){
              
               $.post('/typing',

                    {

                      "_token": $('#search-form').find( 'input[name=_token]' ).val(),
                      "id":$("#user_id").val(),
                      "message":" is typing..."

                    },

                    function(data){

                       
                    }

              );

            },1000);
          }
            
           

        });

			function previous_communication (){

				   $.post(
				            '/messages',
				            {

				            	"_token": $('#result').find( 'input[name=_token]' ).val(),
				            	"id": $('#poruke').val()
				                
				                
				            },
				            function( data ) {
				                //do something with data/response returned by server

							                if(!data.error){

													$('#chat_box').html(data);

												}
				            }
				                    );

			  	
			 
			}


       });

       </SCRIPT>

DELIMITER;



return response()->json(['users'=>$a,'code' => $code]);

              } else {

                  echo "<ul style='background:red;' class='nav'><li>Nema rezultata</li></ul>";
              }

                 
      }




    }

    public function messages(AdminRequest $request){

    	$id1 = $request->input('id');
    	$id2 = Auth::user()->id;

   
    	// $messages = DB::table('chat1s')
     //        ->where('user_id', '=', $id1)
     //        ->orWhere('user_id','=',$id2)
     //        ->get();

            $messages = Chat1::where('user_id', '=', $id1)
    ->orWhere('user_id','=',$id2)
    ->get();

    	
    	foreach ($messages as $message) {
    		# code...

    		$time = $message->created_at->diffForHumans();

    		echo "<div id='chat_data'><span style='color: green;'>$message->name:</span>
				<span style='color:red;'>$message->message</span>
				<span >$time</span></div>";

    	}
    	
    }

    public function send(AdminRequest $request){

    	$name = Auth::user()->name;
    	
    	$message = $request->input('message');

    	Auth::user()->messages()->create(['name'=>$name,'message'=>$message]); 


    }

    public function whoIsTyping(AdminRequest $request){

      $message = $request->input('message');
      $id = $request->input('id');

      event(new whoIsTyping($message,$id));
       
       
    }
}
