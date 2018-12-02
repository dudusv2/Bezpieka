<?php 

if (isset($_POST['submit'])){
	session_start();
	session_unset();
	session_destroy();
	header("Location: ../index.php?logout=sucess");
	exit();
	include_once 'dbh.inc.php';
}
?>
