<?php
	$page_title = "Register";
	include 'includes/header.php';
	include 'includes/db.php';

	$error = [];
	if (array_key_exists('register',$_POST)) {
		
		if (empty($_POST['fname'])) {
			$error['fname']  = "Please enter your firstname";
		}
		if (empty($_POST['lname'])) {
			$error['lname']  = "Please enter your lastname";
		}	
		if (empty($_POST['email'])) {
			$error['email']  = "Please enter your email";
		}	
		if (empty($_POST['password'])) {
			$error['password']  = "Please enter your password";
		}
		if (empty($_POST['pword'])) {
			$error['pword']  = "Please confirm your password";
		}	
		if (empty($error)) {
			$clean = array_map('trim',$_POST);
			
			//encrypting password
			$hash = password_hash($clean['password'], PASSWORD_BCRYPT);
			
			//prepare is used in communicating with the db
			//:f,:l,:e,:h are all placeholders for values we want to pass into the db
			$stmt = $conn->prepare("INSERT INTO admin(firstName,lastName,email,hash) VALUES(:f, :l, :e, :h)"); //or ("INSERT INTO admin VALUES(null,:f, :l, :e, :h)")

			//binding placeholders and values
			$data = [
				":f" => $clean['fname'],
				":l" => $clean['lname'],
				":e" => $clean['email'],
				":h" => $hash
			];
			
			$stmt->execute($data);
		}
			
	}
	   
?>
<div class="wrapper">
		<h1 id="register-label">Register</h1>
		<hr>
		<form id="register"  action ="register.php" method ="POST">
			<div>
				<?php if (isset($error['fname'])) { echo '<span class=err >'.$error['fname'].'</span>'; } ?>
				<label>first name:</label>
				<input type="text" name="fname" placeholder="first name">
			</div>
			<div>
				<?php if (isset($error['lname'])) { echo '<span class=err >'.$error['lname'].'</span>'; } ?>				
				<label>last name:</label>	
				<input type="text" name="lname" placeholder="last name">
			</div>

			<div>
				<?php if (isset($error['email'])) { echo '<span class=err >'.$error['email'].'</span>'; } ?>								
				<label>email:</label>
				<input type="text" name="email" placeholder="email">
			</div>
			<div>
				<?php if (isset($error['password'])) { echo '<span class=err >'.$error['password'].'</span>'; } ?>								
				<label>password:</label>
				<input type="password" name="password" placeholder="password">
			</div>
 
			<div>
				<?php if (isset($error['pword'])) { echo '<span class=err >'.$error['pword'].'</span>'; } ?>								
				<label>confirm password:</label>	
				<input type="password" name="pword" placeholder="password">
			</div>

			<input type="submit" name="register" value="register">
		</form>

		<h4 class="jumpto">Have an account? <a href="login.php">login</a></h4>
    </div>
<?php
    include 'includes/footer.php';
?>
