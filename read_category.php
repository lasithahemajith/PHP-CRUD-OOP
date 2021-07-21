<?php
// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;
  
// set number of records per page
$records_per_page = 5;
  
// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;
  
// retrieve records here
// include database and object files
include_once 'config/database.php';
include_once 'objects/book.php';
include_once 'objects/category.php';
  
// instantiate database and objects
$database = new Database();
$db = $database->getConnection();
  
$book = new Book($db);
$category = new Category($db);
  
// query categories
$stmt = $category->readAll($from_record_num, $records_per_page);
$num = $stmt->rowCount();



// set page header
$page_title = "Read Categories";
include_once "layout_header.php";
  
// contents will be here
echo "<div class='right-button-margin'>
    <a href='index.php' class='btn btn-default pull-right'>Read Books</a>
</div>";

echo "<div class='right-button'>
    <a href='create_book.php' class='btn btn-default pull-left'>Create Book</a>
</div>";

echo "<div class='right-button-margin'>
    <a href='create_category.php' class='btn btn-default pull-left'>Create Category</a>
</div>";



// display the categories if there are any
if($num>0){
  
    echo "<table class='table table-hover table-responsive table-bordered'>";
        echo "<tr>";
            echo "<th>Category</th>";
            echo "<th>Description</th>";
            echo "<th>Actions</th>";
        echo "</tr>";
  
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
  
            extract($row);
            echo "<tr>";
                echo "<td>{$name}</td>";
                echo "<td>{$description}</td>";
                echo "<td>";
                    // read one, edit and delete button will be here
                
                    echo "
                    <a href='update_category.php?id={$id}' class='btn btn-default left-margin'>
                    <span class='glyphicon glyphicon-edit'></span> Edit
                    </a>
                   
                    <a delete-id='{$id}' class='btn btn-danger  delete-category'>
                    <span class='glyphicon glyphicon-remove'></span> Delete
                    </a>";
                echo "</td>";
  
            echo "</tr>";
  
        }
        
    echo "</table>";
    // the page where this paging is used
    $page_url = "read_category.php?";
    
    // count all categorys in the database to calculate total pages
    $total_rows = $category->countAll();
    
    // paging buttons here
    include_once 'paging.php';
  
    // paging buttons will be here
}
  
// tell the user there are no categorys
else{
    echo "<div class='alert alert-info'>No categories found.</div>";
}

// set page footer
include_once "layout_footer.php";
?>