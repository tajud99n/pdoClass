<?php
    //function generating serial number
    function random(){
        $rnd = rand(000000000,999999999);
        return $rnd;
    }

    //function to replace white space
    function strip_name(){
       $strip_name = str_replace(' ','_',$_FILES['pics']['name']);
       return $strip_name;
    }

    //function to generate a new name for the uploaded file
    function filename(){
        $filename = random().strip_name();
        return $filename;
    }

    //function creating file upload destination
    function destination(){
        $destination = './uploads/'.filename();
        return $destination;
    }

    //redifined file upload
    function uploadFile($files,$name,$loc){
        $result = [];
        $rnd = rand(000000000,999999999);        
        $strip_name = str_replace(' ','_',$_FILES[$name]['name']);
        
        $fileName = $rnd.$strip_name;
        $destination = $loc.$fileName;

        if (move_uploaded_file($files[$name]['tmp_name'],$destination)){
            $result[] = true;
            $result[] = $destination;
        }else {
            $result[] = false;
        }
        return $result;
    }


    function doAdminRegister($dbconn, $input){
            //encrypting password
			$hash = password_hash($input['password'], PASSWORD_BCRYPT);
			
			//prepare is used in communicating with the db
			//:f,:l,:e,:h are all placeholders for values we want to pass into the db
			$stmt = $dbconn->prepare("INSERT INTO admin(firstName,lastName,email,hash) VALUES(:f, :l, :e, :h)"); //or ("INSERT INTO admin VALUES(null,:f, :l, :e, :h)")

			//binding placeholders and values
			$data = [
				":f" => $input['fname'],
				":l" => $input['lname'],
				":e" => $input['email'],
				":h" => $hash
			];
			
			$stmt->execute($data);
    }

    function loginAdmin($dbconn){

            $result = [];
            $stmt = $dbconn->prepare("SELECT * FROM admin WHERE email=:e");
			$stmt->bindParam(":e", $_POST['email']);

			$stmt->execute();

			if($stmt->rowCount() == 1){

			$row = $stmt->fetch(PDO::FETCH_ASSOC);									
				
			if (!password_verify($_POST['password'],$row['hash'])) {
				return false;
            }else{
                $result[] = true;
                $result[] = $row;
            }
            }
            return $result;
    }

    function doesEmailExists($dbconn,$email){
        $result = false;

        $stmt = $dbconn->prepare("SELECT email FROM admin WHERE :e=email");

        //binding placeholder :e, with value $email
        $stmt->bindParam(":e", $email);
        $stmt->execute();

        $count = $stmt->rowCount();

        if($count > 0){
            $result = true;
        }
        return $result;
    }

    //refactoring error messages
    function displayErrors($errors,$name){
        $result = "";
        if (isset($errors[$name])) { 
            echo '<span class=err >'.$errors[$name].'</span>';
         }	
         return $result;
    }

    //add category
    function addCategory($dbconn,$input){
        $stmt = $dbconn->prepare("INSERT INTO category(category_name) VAlUES(:catName)");
        $stmt->bindParam(":catName",$input['cat_name']);
        $stmt->execute();
    }

    //validate login
    function checkLogin(){
        if(!isset($_SESSION['admin_id'])){
            header("location:login.php");
        }
    }

    //redirect
    function redirect($location,$msg){
        header("location:".$location.$msg);
    }

    //view category on admin dashboard
    function viewCategory($dbconn){
        $result = "";
        $stmt = $dbconn->prepare("SELECT * FROM category");
        $stmt->execute();

        while($row = $stmt->fetch(PDO::FETCH_BOTH)){
            $result .= '<tr><td>'.$row[0].'</td>';
            $result .= '<td>'.$row[1].'</td>';
            $result .= '<td><a href="edit_category.php?cat_id='.$row[0].'">edit</a></td>';
            $result .= '<td><a href="delete_category.php?cat_id='.$row[0].'">delete</a></td></tr>';            
        }
        return $result;
    }

    //get category for edit on Admin dash board
    function getCategoryById($dbconn,$id){
        $stmt = $dbconn->prepare("SELECT * FROM category WHERE category_id=:catId");
        $stmt->bindParam(':catId',$id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_BOTH);

        return $row;
    }

    //update category on edit category page
    function updateCategory($dbconn,$input){
        $stmt = $dbconn->prepare("UPDATE category SET category_name=:catName WHERE category_id=:catId");

        $data = [
            ":catName" => $input['cat_name'],
            ":catId" => $input['id']
        ];

        $stmt->execute($data);
    }

    //
    function curNave($page){
        $curPage = basename($_SERVER['SCRIPT_FILENAME']);
        if ($curPage == $page) {
            echo 'class = "selected"';
        }
    }

    //Delete category on view category page
    function deleteCategory($dbconn,$input){
        $stmt = $dbconn->prepare("DELETE FROM category WHERE category_id=:catId");

        $stmt->bindParam (":catId", $input);

        $stmt->execute();
        redirect("view_category.php");

    }

    //fetching category for add product page
    function fetchCategory($dbconn){
        $result = "";
        $stmt= $dbconn->prepare("SELECT * FROM category");
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_BOTH)) {
            $result .='<option value="'.$row[0].'">'.$row[1].'</option>';
        } 
        return $result;
    }
    
    //add product
    function addProduct($dbconn,$input){
        $stmt = $dbconn->prepare("INSERT INTO books VALUES(null,:t, :a, :p, :p_date, :cat, :f1, :img)");
        $stmt->execute();

		$data = [
		    ":t" => $input['title'],
			":a" => $input['author'],
			":p" => $input['price'],
            ":p_date" => $input['p_date'],
            ":cat" => $input['cat'],
            ":f1" => $input['flag'],
            ":img" => $input['dest']
			];
			
			$stmt->execute($data);
    
    }

    function viewProduct($dbconn){
        $result = "";
        $stmt = $dbconn->prepare("SELECT * FROM books");
        $stmt->execute();

        while($row = $stmt->fetch(PDO::FETCH_BOTH)){
            $result .= '<tr><td>'.$row[1].'</td>';
            $result .= '<td>'.$row[2].'</td>';
            $result .= '<td>'.$row[3].'</td>';
            $result .= '<td>'.$row[5].'</td>';    
            $result .= '<td><img src ="'.$row[7].'" height="50" width="50"></td>';                    
            $result .= '<td><a href="edit_product.php?book_id='.$row[0].'">edit</a></td>';
            $result .= '<td><a href="delete_product.php?book_id='.$row[0].'">delete</a></td></tr>';            
        }
        return $result;
    }
    
    function getBookById($dbconn,$id){
        $stmt = $dbconn->prepare("SELECT * FROM books WHERE book_id=:bookId");
        $stmt->bindParam(':bookId',$id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_BOTH);

        return $row;
    }    

    //update book on edit book page
    function updateBook($dbconn,$input){
        $stmt = $dbconn->prepare("UPDATE books SET title=:t,author=:a,price=:p,publication_date=:d WHERE book_id=:b");

        $data = [
            ":t" => $input['title'],
            ":b" => $input['id'],
            ":a" => $input['author'],
            ":p" => $input['price'],
            ":d" => $input['p_date']
        ];

        $stmt->execute($data);
    }
    //Delete book on view product page
    function deleteBook($dbconn,$input){
        $stmt = $dbconn->prepare("DELETE FROM books WHERE book_id=:bookId");

        $stmt->bindParam (":bookId", $input);

        $stmt->execute();
        redirect("view_products.php");

    }
?>

