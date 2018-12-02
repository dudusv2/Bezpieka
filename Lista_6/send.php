<?php
      session_start();
       include_once 'header.php';
       if($_SESSION['login']!="true"){
        header("Location: login.php");
    }
    $recipient = $_POST['recipient'];
    $rec_number = $_POST['rec_number'];
    $sum = $_POST['sum'];
    $title = $_POST['title'];
    $sender_number = $_POST['sender_number'];
    $sender = $_POST['sender'];

    try {
         $mysqli = new mysqli("localhost","root", "root", "logsystem");
        mysqli_query($mysqli, "SET CHARSET utf8");
        mysqli_query($mysqli, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
        mysqli_set_charset($mysqli,'utf8');
        
        if($mysqli->connect_errno != 0) {
            throw new Exception(mysqli_connect_error());
        }
        else {
            if($check = $mysqli->query("SELECT user_account From users where user_account='".$rec_number."'")){
                $row = $check->fetch_assoc();
                $ps = $row['user_account'];
                if($ps!=$rec_number){
                    $_SESSION['error'] = "Nie ma tekiego konta";
                    header("Location: form.php");
                }else{
                    if(!$check = $mysqli->query("CALL transfer('$sender','$sender_number','$recipient','$rec_number','$sum','$title')")){
                      $_SESSION['error'] = "Nie udało się wysłać pieniążków";
                        header("Location: form.php");
                    }
                }
            }
        }
        $mysqli->close();
    }
    catch(Exception $error) {
        echo "Connection Error!";
    }
	
	echo "<h1> Success </h1><br>
	<div class='main-container'><div class='main-wrapper'><h3>Your many have been sent<br>
	Sender: ".$sender."<br> 
	From: ".$sender_number."<br>
	Recipient: ".$recipient."<br>
	<div id='account'>to: ".$rec_number."</div>
	ammount: ".$sum."<br>
	title: ".$title."<br></h3></div></div>";
	include_once 'footer.php';
?>

	
	
 
