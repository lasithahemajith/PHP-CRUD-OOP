<?php
// retrieve one book will be here
// get ID of the book to be edited
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
  
// set ID property of book to be edited
$book->id = $id;
  
// read the details of book to be edited
$book->readOne();


// set page header
$page_title = "Update Book";
include_once "layout_header.php";
  
// contents will be here
echo "<div class='right-button-margin'>
          <a href='index.php' class='btn btn-default pull-right'>Read Books</a>
     </div>";
  
?>
<!-- 'update book' form will be here -->
<!-- post code will be here -->
<?php 
// if the form was submitted
if($_POST){
  
    // set book property values
    $book->name = $_POST['name'];
    $book->author_name = $_POST['author_name'];
    $book->price = $_POST['price'];
    $book->category_id = $_POST['category_id'];
    $book->quantity = $_POST['quantity'];
  
    // update the book
    if($book->update()){
        echo "<div class='alert alert-success alert-dismissable'>";
            echo "Book was updated.";
        echo "</div>";
    }
  
    // if unable to update the book, tell the user
    else{
        echo "<div class='alert alert-danger alert-dismissable'>";
            echo "Unable to update book.";
        echo "</div>";
    }
}
?>

  
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
  
        <tr>
            <td>Name</td>
            <td><input type='text' name='name' value='<?php echo $book->name; ?>' class='form-control' /></td>
        </tr>
  
        <tr>
            <td>Author Name</td>
            <td><input type='text' name='author_name' value='<?php echo $book->author_name; ?>' class='form-control' /></td>
        </tr>

        <tr>
            <td>Price</td>
            <td><input type='text' name='price' value='<?php echo $book->price; ?>' class='form-control' /></td>
        </tr>
  
        <tr>
            <td>Category</td>
            <td>
                <!-- categories select drop-down will be here -->
                <?php
                $stmt = $category->read();
                
                // put them in a select drop-down
                echo "<select class='form-control' name='category_id'>";
                
                    echo "<option>Please select...</option>";
                    while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC)){
                        $category_id=$row_category['id'];
                        $category_name = $row_category['name'];
                
                        // current category of the book must be selected
                        if($book->category_id==$category_id){
                            echo "<option value='$category_id' selected>";
                        }else{
                            echo "<option value='$category_id'>";
                        }
                
                        echo "$category_name</option>";
                    }
                echo "</select>";
                ?>
            </td>
        </tr>

        <tr>
            <td>Quantity</td>
            <td><input type='text' name='quantity' value='<?php echo $book->quantity; ?>' class='form-control' /></td>
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