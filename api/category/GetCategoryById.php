<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/CategoryModel.php';

$database = new Database();
$db = $database->connect();

$category = new CategoryModel($db);


$category->id = isset($_GET['id']) ? $_GET['id'] : die();
$category->read_by_id();

$category_arr = array(
  'id' => $category->id,
  'name' => $category->name,
  'created_at' => $category->created_at,
);

print_r(json_encode($category_arr));