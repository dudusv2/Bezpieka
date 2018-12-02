<?php 
	include_once 'header.php';
?>
<section class="main-container">
	<div class="main-wrapper">
		<h2>Zaloguj lub zarejestruj się</h2>
			<form action="includes/login.inc.php" method="POST">
			<input type="text" name="uid" placeholder="Username/e-mail"><br>
			<input type="password" name="pwd" placeholder="password"><br>
			<button type="submit" name="submit">Login</button>
			<a href="signup.php">Sign up</a>
	</div>
</section>
	
<?php
	include_once 'footer.php';
?>
