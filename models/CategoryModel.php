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
    $query = 'SELECT c.*
    FROM ' . $this->table . ' c
    ORDER BY c.created_at DESC';

    $stmt = $this->conn->prepare($query);
    $stmt->execute();

    return $stmt;
  }

  public function read_by_id()
  {
    $query = 'SELECT c.*
    FROM ' . $this->table . ' c
    WHERE id = ?';

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->id);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $this->id = $row['id'];
    $this->name = $row['name'];
    $this->created_at = $row['created_at'];
  }


}