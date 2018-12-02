<?php
   session_start();
       if($_SESSION['login']!="true"){
        header("Location: login.php");
        exit();
    }
    try {
		$mysqli = new mysqli("localhost","root", "root", "logsystem");
        mysqli_query($mysqli, "SET CHARSET utf8");
        mysqli_query($mysqli, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
        mysqli_set_charset($mysqli,'utf8');
        
        if($mysqli->connect_errno != 0) {
            throw new Exception(mysqli_connect_error());
        }
        else {
            if($check = $mysqli->query("SELECT user_amount From users where user_uid='".$_SESSION['u_uid']."'")){
                $row = $check->fetch_assoc();
                $ps = $row['user_amount'];
            }
            $mysqli->close();
        }
    }
    catch(Exception $error) {
        echo "Connection Error!";
    }
    include_once 'header.php'
?>
        <div class="container">
            <div class="header">
                <h1>Bezpieka Bank</h1>
            </div>
            <div>
                <h1>Stan konta:</h1>
                <?php
                    echo "<h2>".$ps."zł</h2>"
                ?>
            </div>
            <form action="confirm.php" method="post">
                <div class="d_text">
                    <h3>Nazwa odbiorcy:</h3>
                    <input type="text" name="recipient" class="textarea">
                </div>
                <div class="d_text">
                    <h3>Numer konta:</h3>
                    <input type="text" name="number" class="textarea" pattern=".{26}" id="account">
                </div>
                <div class="d_text">
                    <h3>Kwota:</h3>
                    <input type="number" step="0.01" name="sum" class="textarea" min="0.01">
                </div>
                <div class="d_text">
                    <h3>Tytuł przelewu:</h3>
                    <input type="text" name="title" class="textarea">
                </div>
                <input type="submit" name="b_login" value="Wyślij" >
            </form>
            <form action="index.php">
                <input type="submit" name="b_back" value="Anuluj" >
            </form>
            <?php
                if(isset($_SESSION['error'])){
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                    
                }
        include_once 'footer.php';
        ?>
