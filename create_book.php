<?php

// include database and object files
include_once 'config/database.php';
include_once 'objects/book.php';
include_once 'objects/category.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// pass connection to objects
$book = new Book($db);
$category = new Category($db);


// set page headers
$page_title = "Create Book";
include_once "layout_header.php";
  
// contents will be here
echo "<div class='right-button-margin'>
        <a href='index.php' class='btn btn-default pull-right'>Read Books</a>
    </div>";
  
?>
<!-- 'create book' html form will be here -->

<?php 
// if the form was submitted - PHP OOP CRUD Tutorial
if($_POST){
  
    // set book property values
    $book->name = $_POST['name'];
    $book->author_name = $_POST['author_name'];
    $book->price = $_POST['price'];
    $book->category_id = $_POST['category_id'];
    $book->quantity = $_POST['quantity'];
  
    // create the book
    if($book->create()){
        echo "<div class='alert alert-success'>Book was created.</div>";
    }
  
    // if unable to create the book, tell the user
    else{
        echo "<div class='alert alert-danger'>Unable to create book.</div>";
    }
}
?>
  
<!-- HTML form for creating a book -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
  
    <table class='table table-hover table-responsive table-bordered'>
  
        <tr>
            <td>Name</td>
            <td><input type='text' name='name' class='form-control' /></td>
        </tr>

        <tr>
            <td>Author Name</td>
            <td><input type='text' name='author_name' class='form-control'></td>
        </tr>
  
        <tr>
            <td>Price</td>
            <td><input type='text' name='price' class='form-control' /></td>
        </tr>
  
        <tr>
            <td>Category</td>
            <td>
            <!-- categories from database will be here -->
            <?php
            // read the book categories from the database
            $stmt = $category->read();
            
            // put them in a select drop-down
            echo "<select class='form-control' name='category_id'>";
                echo "<option>Select category...</option>";
            
                while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row_category);
                    echo "<option value='{$id}'>{$name}</option>";
                }
            
            echo "</select>";
            ?>
            </td>
        </tr>

        <tr>
            <td>Quantity</td>
            <td><input type='text' name='quantity' class='form-control'></textarea></td>
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