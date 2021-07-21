<?php

// include database and object files
include_once 'config/database.php';
include_once 'objects/category.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// pass connection to objects
$category = new Category($db);


// set page headers
$page_title = "Create Category";
include_once "layout_header.php";
  
// contents will be here
echo "<div class='right-button'>
        <a href='index.php' class='btn btn-default pull-right'>Read Books</a>
    </div>";
echo "<div class='right-button-margin'>
    <a href='read_category.php' class='btn btn-default pull-right'>Read Categories</a>
</div>";
  
?>
<!-- 'create category' html form will be here -->
<?php 
// if the form was submitted - PHP OOP CRUD Tutorial
if($_POST){
  
    // set category property values
    $category->name = $_POST['name'];
    $category->description = $_POST['description'];

  
    // create the category
    if($category->create()){
        echo "<div class='alert alert-success'>Category was created.</div>";
    }
  
    // if unable to create the category, tell the user
    else{
        echo "<div class='alert alert-danger'>Unable to create category.</div>";
    }
}
?>
  
<!-- HTML form for creating a category -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
  
    <table class='table table-hover table-responsive table-bordered'>
  
        <tr>
            <td>Name</td>
            <td><input type='text' name='name' class='form-control' /></td>
        </tr>
  
        <tr>
            <td>Description</td>
            <td><input type='text' name='description' class='form-control' /></td>
        </tr>
  
        
  
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Create</button>
            </td>
        </tr>
  
    </table>
</form>


<?php
  
// footer
include_once "layout_footer.php";
?>