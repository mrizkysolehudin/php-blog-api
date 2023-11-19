<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/PostModel.php';

$database = new Database();
$db = $database->connect();

$post = new PostModel($db);

$data = json_decode(file_get_contents("php://input"));

$post->category_id = $data->category_id;
$post->title = $data->title;
$post->body = $data->body;
$post->author = $data->author;

if ($post->create()) {
  echo json_encode(
    array(
      'status' => 'success',
      'message' => 'Create post success',
      'data' => [
        'id' => $post->id,
        'category_id' => $post->category_id,
        'title' => $post->title,
        'body' => $post->body,
        'author' => $post->author,
      ]
    )
  );
} else {
  echo json_encode(
    array('message' => 'Create post error')
  );
}