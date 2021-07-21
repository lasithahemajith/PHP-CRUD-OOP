<?php
// get ID of the book to be read
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
  
// set ID property of book to be read
$book->id = $id;
  
// read the details of book to be read
$book->readOne();


// set page headers
$page_title = "Read One Book";
include_once "layout_header.php";
  
// read books button
echo "<div class='right-button-margin'>";
    echo "<a href='index.php' class='btn btn-primary pull-right'>";
        echo "<span class='glyphicon glyphicon-list'></span> Read Books";
    echo "</a>";
echo "</div>";

// HTML table for displaying a book details
echo "<table class='table table-hover table-responsive table-bordered'>";
  
    echo "<tr>";
        echo "<td>Name</td>";
        echo "<td>{$book->name}</td>";
    echo "</tr>";
  
    echo "<tr>";
        echo "<td>Author Name</td>";
        echo "<td>{$book->author_name}</td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td>Price</td>";
    echo "<td>{$book->price}</td>";
echo "</tr>";


    echo "<tr>";
        echo "<td>Category</td>";
        echo "<td>";
            // display category name
            $category->id=$book->category_id;
            $category->readName();
            echo $category->name;
        echo "</td>";
    echo "</tr>";

    echo "<tr>";
        echo "<td>Quantity</td>";
        echo "<td>{$book->quantity}</td>";
    echo "</tr>";
  
echo "</table>";

  
// set footer
include_once "layout_footer.php";
?>