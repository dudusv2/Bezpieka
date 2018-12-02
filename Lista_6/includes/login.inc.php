<?php 

session_start();

if (isset($_POST['submit'])){
	
	include_once 'dbh.inc.php';
	
	$uid = mysqli_real_escape_string($conn, $_POST['uid']);
	$pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
	
	
	//Error handlers
	//Check for empty fields
	if(empty($uid)||empty($pwd)){
	header("Location: ../index.php?index=empty");
	exit();
	}	else{		
				$sql="SELECT * FROM users WHERE user_uid = '$uid' OR user_email='$uid'";
				$result = mysqli_query($conn, $sql);
				$resultCheck = mysqli_num_rows($result);
				
				if($resultCheck <1){
					header("Location: ../index.php?login=error");
					exit();	
				} else{
					if($row = mysqli_fetch_assoc($result)){
						
						$hashedPwdCheck = password_verify($pwd, $row['user_pwd']);
						if($hashedPwdCheck == false){
							header("Location: ../index.php?login=error");
							exit();	
						} elseif ($hashedPwdCheck == true){
							// Log in
							$_SESSION['u_id'] = $row['user_id'];
							$_SESSION['u_email'] = $row['user_email'];
							$_SESSION['u_uid'] = $row['user_uid'];
							$_SESSION['u_account'] = $row['user_account'];
							$_SESSION['login'] = true; 
							header("Location: ../index.php?login=success");
							exit();	
						}
					 }
					}
			}
		

	
} else {
	header("Location: ../signup.php?login=error");
	exit();
}
?>
