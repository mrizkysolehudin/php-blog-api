<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/PostModel.php';

$database = new Database();
$db = $database->connect();

$post = new PostModel($db);

$result = $post->read();
$num = $result->rowCount();

if ($num > 0) {
  $posts_arr = array();

  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    extract($row);

    $post_item = array(
      'id' => $id,
      'title' => $title,
      'body' => html_entity_decode($body),
      'author' => $author,
      'category_id' => $category_id,
      'category_name' => $category_name
    );

    array_push($posts_arr, $post_item);
  }

  echo json_encode($posts_arr);

} else {
  echo json_encode(
    array('message' => 'No Posts Found')
  );
}