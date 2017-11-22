<?php
    session_start(); 
    $page_title = "Admin Dashboard";
    include 'includes/db.php';       
    include 'funct.php';    
    include 'includes/dashboard_header.php';
    

    if ($_GET['book_id']) {
        $book_id = $_GET['book_id'];
    }

    deleteBook($conn,$book_id);

?>
