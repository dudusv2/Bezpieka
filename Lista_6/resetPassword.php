<?php 
require_once "includes/functions.php";

	if (isset($_GET['email']) && isset($_GET['token'])) {
		
		$conn = new mysqli('localhost', 'root', 'root', 'logsystem');
		$email = $conn->real_escape_string($_GET['email']);
		$token = $conn->real_escape_string($_GET['token']);
		$sql = $conn->query("SELECT user_id FROM users WHERE
			user_email='$email' AND token='$token' AND token<>'' AND tokenExpire > NOW()
		");
		$rows = $sql->num_rows;
		
		if ($rows > 0) {
			$newPassword = generateNewString();
			$newPasswordEncrypted = password_hash($newPassword, PASSWORD_BCRYPT);
			$conn->query("UPDATE users SET token='', user_pwd = '$newPasswordEncrypted'
				WHERE user_email='$email'
			");

			echo "Your New Password Is $newPassword<br><a href='index.php'>Click Here To Log In</a>";
		} else
			echo redirectToLoginPage();
		}
		else {
			echo redirectToLoginPage();
		}
?>
