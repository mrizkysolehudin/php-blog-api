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

  public function create()
  {
    $query = 'INSERT INTO ' .
      $this->table . '
    SET
      name = :name';

    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->name = htmlspecialchars(strip_tags($this->name));

    // Bind data
    $stmt->bindParam(':name', $this->name);


    if ($stmt->execute()) {
      $this->id = $this->conn->lastInsertId();

      return true;
    }

    printf("Error: $s.\n", $stmt->error);

    return false;
  }
}