<?php
class Book{
  
    // database connection and table name
    private $conn;
    private $table_name = "books";
  
    // object properties
    public $id;
    public $name;
    public $author_name;
    public $price;
    public $category_id;
    public $quantity;
    public $timestamp;
  
    public function __construct($db){
        $this->conn = $db;
    }
  
    // create book
    function create(){
  
        //write query
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    name=:name,author_name=:author_name, price=:price,  category_id=:category_id, quantity=:quantity, created=:created";
        $stmt = $this->conn->prepare($query);
  
        // posted values
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->author_name=htmlspecialchars(strip_tags($this->author_name));
        $this->price=htmlspecialchars(strip_tags($this->price));
        $this->category_id=htmlspecialchars(strip_tags($this->category_id));
        $this->quantity=htmlspecialchars(strip_tags($this->quantity));
  
        // to get time-stamp for 'created' field
        $this->timestamp = date('Y-m-d H:i:s');
  
        // bind values 
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":author_name", $this->author_name);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":created", $this->timestamp);
  
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
  
    }
    function readAll($from_record_num, $records_per_page){
  
        $query = "SELECT
                    id, name, author_name, price, category_id, quantity
                FROM
                    " . $this->table_name . "
                ORDER BY
                    name ASC
                LIMIT
                    {$from_record_num}, {$records_per_page}";
      
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
      
        return $stmt;
    }

    // used for paging books
    public function countAll(){
    
        $query = "SELECT id FROM " . $this->table_name . "";
    
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
    
        $num = $stmt->rowCount();
    
        return $num;
    }
    
    //read one book by id
    function readOne(){
  
        $query = "SELECT
                    name, author_name, price, category_id, quantity
                FROM
                    " . $this->table_name . "
                WHERE
                    id = ?
                LIMIT
                    0,1";
      
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
      
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
      
        $this->name = $row['name'];
        $this->author_name = $row['author_name'];
        $this->price = $row['price'];
        $this->category_id = $row['category_id'];
        $this->quantity = $row['quantity'];
    }

    //update book by id
    function update(){
  
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    name = :name,
                    author_name = :author_name,
                    price = :price,
                    category_id  = :category_id,
                    quantity = :quantity
                WHERE
                    id = :id";
        $stmt = $this->conn->prepare($query);
      
        // posted values
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->author_name=htmlspecialchars(strip_tags($this->author_name));
        $this->price=htmlspecialchars(strip_tags($this->price));
        $this->category_id=htmlspecialchars(strip_tags($this->category_id));
        $this->quantity=htmlspecialchars(strip_tags($this->quantity));
        $this->id=htmlspecialchars(strip_tags($this->id));
      
        // bind parameters
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':author_name', $this->author_name);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':quantity', $this->quantity);
        $stmt->bindParam(':id', $this->id);
      
        // execute the query
        if($stmt->execute()){
            return true;
        }
        return false;
          
    }

    // delete the Book by id
    function delete(){
  
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
    
        if($result = $stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
}
?>