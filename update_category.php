<?php
// retrieve one category will be here
// get ID of the category to be edited
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
  
// include database and object files
include_once 'config/database.php';
include_once 'objects/book.php';
include_once 'objects/category.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare objects
$book = new Book($db);
$category = new Category($db);
  
// set ID property of category to be edited
$category->id = $id;
  
// read the details of category to be edited
$category->readOne();


// set page header
$page_title = "Update Category";
include_once "layout_header.php";
  
// contents will be here
echo "<div class='right-button-margin'>
          <a href='read_category.php' class='btn btn-default pull-right'>Read Categories</a>
     </div>";
  
?>
<!-- 'update category' form will be here -->
<!-- post code will be here -->
<?php 
// if the form was submitted
if($_POST){
  
    // set category property values
    $category->name = $_POST['name'];
    $category->description = $_POST['description'];

  
    // update the category
    if($category->update()){
        echo "<div class='alert alert-success alert-dismissable'>";
            echo "Category was updated.";
        echo "</div>";
    }
  
    // if unable to update the category, tell the user
    else{
        echo "<div class='alert alert-danger alert-dismissable'>";
            echo "Unable to update category.";
        echo "</div>";
    }
}
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
  
        <tr>
            <td>Name</td>
            <td><input type='text' name='name' value='<?php echo $category->name; ?>' class='form-control' /></td>
        </tr>
  
        <tr>
            <td>Description</td>
            <td><input type='text' name='description' value='<?php echo $category->description; ?>' class='form-control' /></td>
        </tr>
  
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Update</button>
            </td>
        </tr>
  
    </table>
</form>


<?php
// set page footer
include_once "layout_footer.php";
?>