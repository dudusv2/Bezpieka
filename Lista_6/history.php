<?php
    session_start();
       if($_SESSION['login']!="true"){
        header("Location: login.php");
    }
    include_once 'header.php';

    try {
        $con = new mysqli("localhost","root", "root", "logsystem");
        mysqli_query($con, "SET CHARSET utf8");
        mysqli_query($con, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
        mysqli_set_charset($con,'utf8');
        
        if($con->connect_errno != 0) {
            throw new Exception(mysqli_connect_error());
        }
        else {
            if($check = $con->query("SELECT * From transfers where s_account='".$_SESSION['u_account']."' ORDER BY data DESC")){
                $num_rows = $check->num_rows;
                if($num_rows>0){
                    while($r=$check->fetch_assoc()){
                        echo "<div class='main-container'>
                         <div style='float:left'>&nbsp;Data: ".$r['data']." </div>
                         <div style='float:left'>&nbsp;|| Sender : ".$r['sender']."</div>
                         <div class='account_no' style='float:left'>&nbsp;||  From: ".$r['s_account']."</div>
					     <div style='float:left'> &nbsp;|| Reciplent : ".$r['recipient']."</div>
					     <div class='r_account' style='float:left'>||To:".$r['r_account']."</div>
					     <div class='opis' style='float:left'> &nbsp;||Title: ".$r['title']."</div>
					     <div style='float:left'> &nbsp;||Amount:".$r['amount']."</div></div>
						";
                   
                    }
                }
            }
            $con->close();
        }
    }
    catch(Exception $error) {
        echo "Connection Error!";
    }

	include_once 'footer.php';
?>
