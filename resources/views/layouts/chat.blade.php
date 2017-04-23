<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Chat Box</title>

	<link rel="stylesheet" href="{{asset('css/libs.css')}}" class="">

	@yield('styles')

</head>
<body>

<div id="container">
<input type="hidden" id="poruke" value="">
	<div id="chat_box">

	
	</div>
	<div class="" id="isTyping"></div>

		{!! Form::open(['method'=>'POST','action'=>'ChatController@send','id'=>'send-form']) !!}
	
		
		<textarea name="message" id="typing" cols="30" rows="10" placeholder="Enter your message"></textarea>
		<input type="submit" name="submit" value="Send">

	
		{!! Form::close() !!}

		{!! Form::open(['method'=>'POST','action'=>'ChatController@search','id'=>'search-form']) !!}
		
			<input type="text"  name="search" placeholder="Enter name" id="search">
	
		{!! Form::close() !!}
	

		{!! Form::open(['method'=>'POST','action'=>'ChatController@messages','id'=>'result']) !!}
		{!! Form::close() !!}
	
</div>

<div id="code"></div>

	
</body>
</html>

<script class="" src="{{asset('js/libs.js')}}"></script>
<script src="https://js.pusher.com/3.1/pusher.min.js"></script>


@yield('scripts')