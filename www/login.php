<?php
	session_start();
	$page_title = "Login"; 
	include ('includes/header.php');
	include 'includes/db.php';
	include 'funct.php';

	
	$error = [];
	if (array_key_exists('login',$_POST)){
		if (empty($_POST['email'])) {
			$error['email'] = "Please enter email address";
		}
		if (empty($_POST['password'])) {
			$error['password'] = "Please enter password";
		}
		if (empty($error)) {
			$clean =   array_map('trim',$_POST);

			$data = loginAdmin($conn);
			if ($data[0]) {
				$details = $data[1];

				$_SESSION['admin_id'] = $details['admin_id'];
				$_SESSION['name'] = $details['firstName']." ".$details['lastName'];

				redirect("add_category.php?msg=","admin successfully logged in");
			}
		}
	}
?>
<div class="wrapper">
		<h1 id="register-label">Admin Login</h1>
		<hr>
		<form id="register"  action ="login.php" method ="POST">
			<div>
				<?php $data = displayErrors($error, 'email'); ?>								
				<label>email:</label>
				<input type="text" name="email" placeholder="email">
			</div>
			<div>
				<?php $data = displayErrors($error, 'password'); ?>								
				<label>password:</label>
				<input type="password" name="password" placeholder="password">
			</div>

			<input type="submit" name="login" value="login">
		</form>

		<h4 class="jumpto">Don't have an account? <a href="register.php">register</a></h4>
	</div>
<?php
    include 'includes/footer.php';
?>
