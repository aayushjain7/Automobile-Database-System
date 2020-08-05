<?php
session_start();
$salt='XyZzy12*_';
$md5=hash('md5','XyZzy12*_php123');
$storedhash=$md5;
if(isset($_POST['email'])&&isset($_POST['pass'])){
	unset($_SESSION['email']);
	if(strlen($_POST['email'])<1 || strlen($_POST['pass'])<1){
		$_SESSION['error']="User name and password are required";
		header("Location: login.php");
		return;
	}
	elseif(strpos($_POST['email'],'@')===false){
		$_SESSION['error']="Email must have an at-sign (@)";
		header("Location: login.php");
		return;
	}
	else{
		$check=hash('md5',$salt.$_POST['pass']);
		if($check==$storedhash){
			error_log("Login success ".$_POST['email']);
			$_SESSION['name']=$_POST['email'];
			header("Location: index.php");
			return;
		}
		else{
			$_SESSION['error']="Incorrect Password";
			error_log("Login fail ".$_POST['email']." $check");
			header("Location: login.php");
			return;
		}
	}
}
?>
<!DOCTYPE html>
<head>
<title>Aayush Jain</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
<h1>Please Log In</h1>
<?php
if(isset($_SESSION['error'])){
	echo('<p style="color:red">'.htmlentities($_SESSION['error'])."</p>\n");
	unset($_SESSION['error']);
}
?>
<form method="POST">
<label for="nam">User Name</label>
<input type="text" name="email" id="nam"><br/>
<label for="pas">Password</label>
<input type="password" name="pass" id="pas"><br/>
<input type="submit" value="Log In"><a href="index.php">Cancel</a>
</form>
<p>For a password hint, view source and find a password hint in the HTML comments.</p>
<!-- Hint: The password is the four character sound a cat
makes (all lower case) followed by 123. -->
</div>
</body>
</html>