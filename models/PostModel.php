<?php
class PostModel
{
  private $conn;
  private $table = 'posts';


  public $id;
  public $category_id;
  public $category_name;
  public $title;
  public $body;
  public $author;
  public $created_at;


  public function __construct($db)
  {
    $this->conn = $db;
  }


  // get posts
  public function read()
  {
    $query = 'SELECT c.name as category_name, p.id, p.category_id, p.title, p.body, p.author, p.created_at
              FROM ' . $this->table . ' p
              LEFT JOIN categories c ON p.category_id = c.id
              ORDER BY p.created_at DESC';

    $stmt = $this->conn->prepare($query);
    $stmt->execute();

    return $stmt;
  }


  public function read_by_id()
  {
    $query = 'SELECT c.name as category_name, p.*  
    FROM ' . $this->table . ' p
    LEFT JOIN categories c ON p.category_id = c.id
    WHERE p.id = ?';

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->id);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $this->id = $row['id'];
    $this->category_id = $row['category_id'];
    $this->category_name = $row['category_name'];
    $this->title = $row['title'];
    $this->body = $row['body'];
    $this->author = $row['author'];
    $this->created_at = $row['created_at'];
  }

  public function create()
  {
    $query = 'INSERT INTO ' .
      $this->table . '
    SET
      category_id = :category_id,
      title = :title,
      body = :body,
      author = :author';

    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->category_id = htmlspecialchars(strip_tags($this->category_id));
    $this->title = htmlspecialchars(strip_tags($this->title));
    $this->body = htmlspecialchars(strip_tags($this->body));
    $this->author = htmlspecialchars(strip_tags($this->author));

    // Bind data
    $stmt->bindParam(':category_id', $this->category_id);
    $stmt->bindParam(':title', $this->title);
    $stmt->bindParam(':body', $this->body);
    $stmt->bindParam(':author', $this->author);


    if ($stmt->execute()) {
      $this->id = $this->conn->lastInsertId();

      return true;
    }

    printf("Error: $s.\n", $stmt->error);

    return false;
  }

}