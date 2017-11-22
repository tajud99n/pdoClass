<?php
    session_start(); 
    $page_title = "Admin Dashboard";
    include 'includes/db.php';       
    include 'funct.php';    
    include 'includes/dashboard_header.php';
    

    if ($_GET['cat_id']) {
        $cat_id = $_GET['cat_id'];
    }

    deleteCategory($conn,$cat_id);

?>
