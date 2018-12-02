<?php
	function generateNewString($len = 10) {
		$token = "qwertyuiopASDFGHJKL1234567890zxcVBNm";
		$token = str_shuffle($token);
		$token = substr($token,0,$len);

		return $token;
	}

	function redirectToLoginPage() {
		header('Location: index.php');
		exit();
	}

?>
