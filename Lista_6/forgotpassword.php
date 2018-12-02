<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
require_once "includes/functions.inc.php";
	if (isset($_POST['email'])) {
		
		$mysqli = new mysqli("localhost","root", "root", "logsystem");
		$email = mysqli_real_escape_string($mysqli, $_POST['email']);	
		$query = $mysqli->prepare("SELECT * FROM users WHERE user_email ='$email'");
		$query->execute();
		$query->store_result();
		$rows = $query->num_rows;	
		$token = generateNewString();
		
		 if($rows>0){
			
			$token = generateNewString();
			$query = $mysqli->prepare("UPDATE users SET token='$token',tokenExpire=DATE_ADD(NOW(),INTERVAL 5 MINUTE) WHERE user_email='$email'");
			$query->execute();
			$mail = new PHPMailer(true);                           
			try {                             
				$mail->isSMTP();                               
				$mail->Host = 'smtp.gmail.com';  
				$mail->SMTPAuth = true;                              
				$mail->Username = 'bezpiekabank@gmail.com';                
				$mail->Password = 'tempPassword';                          
				$mail->SMTPSecure = 'tls';                          
				$mail->Port = 587;    
				$mail->CharSet = "UTF-8";                             

				$mail->setFrom('bezpiekabank@gami.com','Bank Bezpieka');
				$mail->addAddress($email);            

				$mail->isHTML(true);                               
				$mail->Subject = 'Resset Password';
				$mail->Body = "
						Hi,<br><br>
						
					In order to reset your password, please click on the link below:<br>
					<a href='
					http://localhost/banksystem/resetPassword.php?email=$email&token=$token
					'>http://localhost/banksystem/resetPassword.php?email=$email&token=$token</a><br><br>
					
					Kind Regards,<br>
					Jakub Bezpieczny
				";
				$mail->send();
     
				} catch (Exception $e) {
					exit(json_encode(array("status" => 0, "msg" => 'Something Wrong Just Happened! Please try again!')));
				}
				    exit(json_encode(array("status" => 1, "msg" => 'Please Check Your Email Inbox!')));
			  }else 
				exit(json_encode(array("status" => 0, "msg" => 'Please Check Your Inputs!')));
		}
					
	include_once 'header.php'

?>
	<div class='main-container'><div class='main-wrapper' align="center"> 
			<input  class="form-control" id="email" placeholder="Your email Adress"><br>
			<input  type="button" class="btn btn-primary" value="Reset Password">
			<br><br> 
			<p id="response"></p>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="crossorigin="anonymous"></script>
	<script type="text/javascript">
		var email=$("#email");
		
		$(document).ready(function(){
			$('.btn-primary').on('click', function() {
				if (email.val() != ""){
					email.css('border', '1px solid green');
					$.ajax({
						url: 'forgotpassword.php',
						method: 'POST',
						dataType: 'json',
						data: { 
							email: email.val()
						}, success: function (response) {
							if (!response.success)
							$("#response").html(response.msg).css('color',"red");
							else 
							$("#response").html(response.msg).css('color',"green");
						}
					});
				}else
				email.css('border', '1px solid red' );
			
				});
			});
	</script>
<?php
	include_once 'footer.php';
?>
