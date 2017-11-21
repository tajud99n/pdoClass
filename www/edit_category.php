<?php
    session_start(); 
    $page_title = "Admin Dashboard";
    include 'includes/db.php';       
    include 'funct.php';    
    include 'includes/dashboard_header.php';
    checkLogin();

    if ($_GET['cat_id']) {
        $cat_id = $_GET['cat_id'];
    }

    $item = getCategoryById($conn,$cat_id);

    $error = [];
    if (array_key_exists('edit',$_POST)) {
        if (empty($_POST['cat_name'])) {
            $error['cat_name'] = "Please Enter Category Name";
        }
        if (empty($error)) {
           $clean = array_map('trim',$_POST);
           $clean['id'] = $cat_id;

            updateCategory($conn,$clean);

            redirect("view_category.php");
        }
    }
?>
<div class="wrapper">
		<div id="stream">
			<form id="register"  action ="" method ="POST">
			    <div>
                    <?php $data = displayErrors($error, 'cat_name'); ?>								
				    <label>Edit Category:</label>
				    <input type="text" name="cat_name" placeholder="category name" value="<?php echo $item[1]; ?>">
                </div>
                <input type="submit" name="edit" value="Edit">
            </form>
		</div>
</div>
<?php
    include 'includes/footer.php'
?>
