<?php
class Category{
  
    // database connection and table name
    private $conn;
    private $table_name = "categories";
  
    // object properties
    public $id;
    public $name;
    public $description;
    public $timestamp;
  
    public function __construct($db){
        $this->conn = $db;
    }
  
    // create category
    function create(){
  
        //write query
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    name=:name, description=:description, created=:created";
        $stmt = $this->conn->prepare($query);
  
        // posted values
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->description=htmlspecialchars(strip_tags($this->description));
       
  
        // to get time-stamp for 'created' field
        $this->timestamp = date('Y-m-d H:i:s');
  
        // bind values 
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":created", $this->timestamp);
  
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
  
    }

    // used by select drop-down list
    function read(){
        //select all data
        $query = "SELECT
                    id, name, description
                FROM
                    " . $this->table_name . "
                ORDER BY
                    name";  
  
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
  
        return $stmt;
    }
    // used to read category name by its ID
    function readName(){
        
        $query = "SELECT name FROM " . $this->table_name . " WHERE id = ? limit 0,1";
    
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->name = $row['name'];
    }


    function readAll($from_record_num, $records_per_page){
  
        $query = "SELECT
                    id, name, description
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
    // used for paging categories
    public function countAll(){
    
        $query = "SELECT id FROM " . $this->table_name . "";
    
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
    
        $num = $stmt->rowCount();
    
        return $num;
    }

    //read one category
    function readOne(){
        $query = "SELECT
                    name, description
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
        $this->description = $row['description'];
    }

    // update category by id
    function update(){
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    name = :name,
                    description = :description
                WHERE
                    id = :id";
      
        $stmt = $this->conn->prepare($query);
      
        // posted values
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->id=htmlspecialchars(strip_tags($this->id));
      
        // bind parameters
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':id', $this->id);
      
        // execute the query
        if($stmt->execute()){
            return true;
        }
        return false;
          
    }

    // delete the Category
    function delete(){
        //$query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $query = "DELETE FROM categories 
        WHERE id NOT IN (
          SELECT category_id FROM books
        )"; 
        
        
        $stmt = $this->conn->prepare($query);
        //$stmt->bindParam(1, $this->id);
    
        if($result = $stmt->execute()){
            return true;
        }else{
            return false;
        }
    }  
}
?>