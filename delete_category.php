<?php
// check if value was posted
if($_POST){
  
    // include database and object file
    include_once 'config/database.php';
    include_once 'objects/category.php';
  
    // get database connection
    $database = new Database();
    $db = $database->getConnection();
  
    // prepare category object
    $category = new Category($db);
      
    // set category id to be deleted
    $category->id = $_POST['object_id'];
      
    // delete the category
    if($category->delete()){
        echo "Object was deleted.";
    }
      
    // if unable to delete the category
    else{
        echo "Unable to delete object.";
    }
}
?>