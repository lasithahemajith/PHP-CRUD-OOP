<?php
// check if value was posted
if($_POST){
  
    // include database and object file
    include_once 'config/database.php';
    include_once 'objects/book.php';
  
    // get database connection
    $database = new Database();
    $db = $database->getConnection();
  
    // prepare book object
    $book = new Book($db);
      
    // set book id to be deleted
    $book->id = $_POST['object_id'];
      
    // delete the book
    if($book->delete()){
        echo "Object was deleted.";
    }
      
    // if unable to delete the book
    else{
        echo "Unable to delete object.";
    }
}
?>