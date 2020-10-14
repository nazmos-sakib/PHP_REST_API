<?php 
	
	//headers
	header('Access-Conteol-Allow-Origin: *');
	header('Access-Conteol-Allow-Methods: POST');
	header('Control-Type: application/json');
	header('Access-Conteol-Allow-Headers: Access-Conteol-Allow-Headers, Control-Type, Access-Conteol-Allow-Methods, Authorization, X-Requested-With');

	//initializing our api
	include_once('../core/initialize.php');

	//instantiate post
	$post = new Post($db);

	//get raw posted data
	$data = json_decode(file_get_contents('php://input'));


	$post->title = $data->title ;
	$post->body = $data->body ;
	$post->author = $data->author ;
	$post->category_id = $data->category_id ;
	
	//create post
	if($post->create())
	{
		echo json_encode(
			array('message' => 'Post Created')
		);
	}
	else
	{
		echo json_encode(
			array('message' => 'Post not Created')
		);
	}



 ?>

 