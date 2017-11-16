<?php
    include('funct.php');
    define('MAX_FILE_SIZE', '2097152');
    $ext = ['image/jpg','image/jpeg','image/png'];

    if(array_key_exists('upload',$_POST)){
        //print_r($_FILES);
        $errors = [];
        if (empty($_FILES['pics']['name'])) {
            $errors[] = "Please select a file";
        }
        if ($_FILES['pics']['size'] > MAX_FILE_SIZE) {
            $errors[] = "File too large. Maximum: ".MAX_FILE_SIZE;
            $_FILES['pics']['tmp_name'] = null;
        }

        //validates if supported format is uploaded
        if (!in_array($_FILES['pics']['type'], $ext)) {
            $errors[] = "File format not supported";
        }

        //validates if file is moved
      /*  if (!move_uploaded_file($_FILES['pics']['tmp_name'],destination())) {
            $errors[] = "File not upload";
        }*/

        if (empty($errors)) {
            move_uploaded_file($_FILES['pics']['tmp_name'],destination());
            echo "File upload successful";
        }else {
            foreach ($errors as $err) {
                echo $err."<br>";
            }
        }            
    }
?>
<form id="register" method="POST" enctype="multipart/form-data">
    <p>Please Upload a picture</p>
    <input type="file" name="pics">
    
    <input type="submit" name="upload">
</form>
