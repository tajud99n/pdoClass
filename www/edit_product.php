<?php
    session_start(); 
    $page_title = "Admin Dashboard";
    include 'includes/db.php';       
    include 'funct.php';    
    include 'includes/dashboard_header.php';
    checkLogin();

    if ($_GET['book_id']) {
        $book_id = $_GET['book_id'];
    }

    $item = getBookById($conn,$book_id);

    $error = [];
    if (array_key_exists('edit',$_POST)) {
        if (empty($_POST['title'])) {
            $error['title'] = "Please Enter Category Name";
        }
        if (empty($_POST['author'])) {
            $error['author'] = "Please Enter Author Name";
        }
        if (empty($_POST['price'])) {
            $error['price'] = "Please Enter Price";
        }
        if (empty($_POST['p_date'])) {
            $error['p_date'] = "Please Enter Year of publication";
        }
        if (empty($error)) {
           $clean = array_map('trim',$_POST);
           $clean['id'] = $book_id;

            updateBook($conn,$clean);

            redirect("view_category.php");
        }
    }
?>
<div class="wrapper">
		<div id="stream">
			<form id="register"  action ="" method ="POST">
			    <div>
                    <?php $data = displayErrors($error, 'title'); ?>								
				    <label>Edit Title:</label>
				    <input type="text" name="title" placeholder="book title" value="<?php echo $item[1]; ?>">
                </div>
                 
                <div>
                    <?php $data = displayErrors($error, 'author'); ?>								
				    <label>Edit Author:</label>
				    <input type="text" name="author" placeholder="author" value="<?php echo $item[2]; ?>">
                </div>
                <div>
                    <?php $data = displayErrors($error, 'price'); ?>								
				    <label>Price:</label>
				    <input type="text" name="price" placeholder="price" value="<?php echo $item[3]; ?>">
                </div>
                <div>
                    <?php $data = displayErrors($error, 'p_date'); ?>								
				    <label>Publication Date:</label>
				    <input type="text" name="p_date" placeholder="year of publication" value="<?php echo $item[4]; ?>">
                </div>
                <input type="submit" name="edit" value="Edit">
            </form>
		</div>
</div>
<?php
    include 'includes/footer.php'
?>
