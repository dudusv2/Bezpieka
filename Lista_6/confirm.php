<?php
       session_start();
       include_once 'header.php';
       if($_SESSION['login']!="true" ){
        header("Location: login.php");
    }
    
    
    $recipient = $_POST['recipient'];
    $rec_number = $_POST['number'];
    $sum = $_POST['sum'];
    $title = $_POST['title'];
    $sender_number;
    $sender = $_SESSION['u_uid'];

    try {
        $con = new mysqli("localhost","root", "root", "logsystem");
        mysqli_query($con, "SET CHARSET utf8");
        mysqli_query($con, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
        mysqli_set_charset($con,'utf8');
        
        if($con->connect_errno != 0) {
            throw new Exception(mysqli_connect_error());
        }
        else {
            if($check = $con->query("SELECT user_account From users where user_uid='".$sender."'")){
                $row = $check->fetch_assoc();
                $sender_number = $row['user_account'];
            }
            $con->close();
        }
    }
    catch(Exception $error) {
        echo "Connection Error!";
    }
?>
        <div class="container">
            <div class="header">
                <h1>Bezpieka Bank</h1>
            </div>
         
            <?php
            echo "<form action='send.php' method='post'>
                Nadawca:<br>
                <textarea readonly name='sender'>".$sender."</textarea><br>
                Numer konta nadawcy:<br>
                <textarea readonly name='sender_number'>".$sender_number."</textarea><br>
                Odbiorca:<br>
                <textarea readonly name='recipient'>".$recipient."</textarea><br>
                Numer konta odbiorcy:<br>
                <textarea readonly name='rec_number' id='account'>".$rec_number."</textarea><br>
                Kwota:<br>
                <textarea readonly name='sum'>".$sum."</textarea><br>
                Tytuł przelewu:<br>
                <textarea readonly name='title'>".$title."</textarea><br>
                <input type='submit' name='b_login' value='Potwierdź' class='but'>
            </form>";
            ?>
            <form action="form.php">
                <input type="submit" name="b_back" value="Anuluj" class="but">
            </form>
        </div>
    <?php
              
        include_once 'footer.php';
        ?>
