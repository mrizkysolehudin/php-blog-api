<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/PostModel.php';

$database = new Database();
$db = $database->connect();

$post = new PostModel($db);


$post->id = isset($_GET['id']) ? $_GET['id'] : die();
$post->read_by_id();

$post_arr = array(
  'id' => $post->id,
  'category_id' => $post->category_id,
  'category_name' => $post->category_name,
  'title' => $post->title,
  'body' => $post->body,
  'author' => $post->author,
  'created_at' => $post->created_at,
);

print_r(json_encode($post_arr));