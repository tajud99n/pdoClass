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
?>
