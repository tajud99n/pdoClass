<?php
    session_start(); 
    $page_title = "Admin Dashboard";
    include 'includes/db.php';        
    include 'funct.php';    
    include 'includes/dashboard_header.php';
    checkLogin();

    $error = [];
    if (array_key_exists('add',$_POST)) {
        if (empty($_POST['cat_name'])) {
            $error['cat_name'] = "Please Enter Category Name";
        }
        if (empty($error)) {
            $clean = array_map('trim',$_POST);
            addCategory($conn,$clean);
            redirect("view_category.php");

        }
    }
?>
<div class="wrapper">
		<div id="stream">
			<form id="register"  action ="add_category.php" method ="POST">
			    <div>
                    <?php $data = displayErrors($error, 'cat_name'); ?>								
				    <label>Add Category:</label>
				    <input type="text" name="cat_name" placeholder="category name">
                </div>
                <input type="submit" name="add" value="Add">
            </form>
		</div>
</div>
<?php
    include 'includes/footer.php'
?>
