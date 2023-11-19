<?php

class CategoryModel
{
  private $conn;
  private $table = 'categories';

  public $id;
  public $name;
  public $created_at;


  public function __construct($db)
  {
    $this->conn = $db;
  }


  // get categories
  public function read()
  {
    $query = 'SELECT c.*, c.created_at
    FROM ' . $this->table . ' c
    ORDER BY c.created_at DESC';

    $stmt = $this->conn->prepare($query);
    $stmt->execute();

    return $stmt;
  }


}