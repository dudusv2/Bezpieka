<?php 

if (isset($_POST['submit'])){
	
	include_once 'dbh.inc.php';
	
	
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$uid = mysqli_real_escape_string($conn, $_POST['uid']);
	$pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
	$pwdConfirm = mysqli_real_escape_string($conn, $_POST['pwdConfirm']);
	
	//Error handlers
	//Check for empty fields
	if(empty($email)||empty($pwdConfirm)||empty($uid)||empty($pwd)){
	header("Location: ../signup.php?signup=empty");
	exit();
	}else{
		// Check if inputs charakters are valid
		if(strcmp($pwd, $pwdConfirm)!==0){
		header("Location: ../signup.php?signup=diffrentPassword");
		exit();	
		}else {
			// Check if email is valid
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				header("Location: ../signup.php?signup=email");
				exit();		
			}else{
				$sql="SELECT * FROM users WHERE user_uid='$uid'";
				$result = mysqli_query($conn, $sql);
				$resultCheck = mysqli_num_rows($result);
				
				if($resultCheck > 0){
					header("Location: ../signup.php?signup=usertaken");
					exit();	
				} else{
					//Hashing the password
					$hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
					$hashedPwdConfirm = password_hash($pwdConfirm, PASSWORD_DEFAULT);
					//Insert the user into the database
					$sql = "INSERT INTO users (user_email, user_uid, user_pwd,token) VALUES ('$email', '$uid','$hashedPwd','$hashedPwdConfirm');";
					mysqli_query($conn, $sql);
					header("Location: ../signup.php?signup=success");
					exit();	
					}
			}
		}
	}	
} else {
	header("Location: ../signup.php");
	exit();
}
?>
