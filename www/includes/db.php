<?php
    //create CONSTANT to important database details
    define('DBNAME','store');
    define('DBUSER','root');
    define('DBPASS','tajud99n');

    try{
        $conn = new PDO('mysql:host=localhost;dbname='.DBNAME, DBUSER, DBPASS);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);

    }catch(PDOException $err) {
        echo $err->getMessage();
    }
?>
