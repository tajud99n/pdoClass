<?php
    session_start(); 
    $page_title = "Admin Dashboard";
    include 'includes/db.php';        
    include 'funct.php';    
    include 'includes/dashboard_header.php';
    checkLogin();

    $error = [];
    $flag = ['Top-Selling','Trending','Recently-Viewed'];
    define('MAX_FILE_SIZE',2097152);
    $ext = ['image/jpeg','image/jpg','image/png'];

    if (array_key_exists('add',$_POST)) {
        if (empty($_POST['title'])) {
            $error['title'] = "Please Enter Book Title";
        }
        if (empty($_POST['author'])) {
            $error['author'] = "Please Enter Author Name";
        }
        if (empty($_POST['price'])) {
            $error['price'] = "Please Enter Price";
        }
        if (empty($_POST['p_date'])) {
            $error['p_date'] = "Please Enter Publication Date";
        }
        if (empty($_POST['cat'])) {
            $error['cat'] = "Please Select Category";
        }
        if (empty($_POST['flag'])) {
            $error['flag'] = "Please Select Flag";
        }
        if (empty($_FILES['image']['name'])) {
            $error['image'] = "Please select a book image";
        }
        if ($_FILES['image']['size'] > MAX_FILE_SIZE) {
            $error['image'] = "Image size too large";
        }
        if (!in_array($_FILES['image']['type'], $ext)) {
            $error['image'] = "Image type not supported";
        }
        if (empty($error)) {
            $img = uploadFile($_FILES,'image','uploads/');
            if ($img[0]) {
                $location = $img[1];
            }
            $clean = array_map('trim',$_POST);
            $clean['dest'] = $location;
            addProduct($conn,$clean);
            redirect("view_products.php");

        }
    }
?>
<div class="wrapper">
		<div id="stream">
			<form id="register"  action ="add_products.php" method ="POST" enctype="multipart/form-data">
			    <div>
                    <?php $data = displayErrors($error, 'title'); ?>								
				    <label>Book:</label>
				    <input type="text" name="title" placeholder="title">
                </div>
                <div>
                    <?php $data = displayErrors($error, 'author'); ?>								
				    <label>Author:</label>
				    <input type="text" name="author" placeholder="author">
                </div>
                <div>
                    <?php $data = displayErrors($error, 'price'); ?>								
				    <label>Price:</label>
				    <input type="text" name="price" placeholder="price">
                </div>
                <div>
                    <?php $data = displayErrors($error, 'p_date'); ?>								
				    <label>Publication Date:</label>
				    <input type="text" name="p_date" placeholder="year of publication">
                </div>
                <div>
                    <?php $data = displayErrors($error, 'cat'); ?>								                    
                    <label>Category</label>
                    <select name="cat" >
                        <option>SELECT CATEGORY</option>
                        <?php
                            $data = fetchCategory($conn);
                            echo $data;
                        ?>
                    </select>
                </div>
                <div>
                    <?php $data = displayErrors($error, 'flag'); ?>
                    <label>Flag:</label>
                    <select name="flag" >
                        <option>Select Flag</option>
                        <?php foreach ($flag as $f1) { ?>
                            <option value="<?php echo $f1 ?>"><?php echo $f1 ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div>
                    <?php $data = displayErrors($error, 'image'); ?>
                    <label>Image:</label>
                    <input type="file" name="image">
                </div>
                <input type="submit" name="add" value="Add">
            </form>
		</div>
</div>
<?php
    include 'includes/footer.php'
?>
