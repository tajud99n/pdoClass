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

            $stmt = $dbconn->prepare("SELECT * FROM admin WHERE email=:e");
			$stmt->bindParam(":e", $_POST['email']);

			$stmt->execute();

			if($stmt->rowCount() == 1){

				while($result = $stmt->fetch(PDO::FETCH_ASSOC)){										
				
					if (password_verify($_POST['password'],$result['hash'])) {
						echo 1;
					//header("location:");
                    }
				}
			}
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
?>
