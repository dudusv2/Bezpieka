<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Banking system</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 1.32" />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
	
	<header>
		<div class="logo" > 
		<a href="index.php" >Bezpieka Bank</a>
		</div>
		<nav>
			<div class="main-wrapper">
				<ul>
					<?php
						if(isset($_SESSION['u_id'])){
					 echo '<li><a href="index.php">Home</a></li>
						   <li><a href="form.php">Transfer</a></li>
						   <li><a href="history.php">History</a></li>';
					   }else {
						   '<li><a href="index.php">Home</a></li>';
						   }
					
					?>
				</ul>
				<div class="nav-login">
					<?php
						if(isset($_SESSION['u_id'])){
							echo '<form action="includes/logout.inc.php" method="POST">
									<button type="submit" name="submit">Logout</button>
								</form>';	
							} else {
							echo '<form action="includes/login.inc.php" method="POST">
									<input type="text" name="uid" placeholder="Username/e-mail">
									<input type="password" name="pwd" placeholder="password">
									<button type="submit" name="submit">Login</button>
								</form>
								<a href="signup.php">Sign up</a> 
								<a href="forgotpassword.php">ForgotPassword</a>';
							}
					?>
				</div>
			</div>
		</nav> 
	</header> 
