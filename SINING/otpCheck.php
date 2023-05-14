<?php

include 'condb.php';
session_start();
$user_id = $_SESSION['user_id'];
error_reporting(0);

   use PHPMailer\PHPMailer\PHPMailer;
   use PHPMailer\PHPMailer\Exception;
   require 'phpmailer/src/Exception.php';
   require 'phpmailer/src/PHPMailer.php';
   require 'phpmailer/src/SMTP.php';

if(isset($_POST['submit'])){

    $otp = mysqli_real_escape_string($conn, $_POST['code']);
    $select = mysqli_query($conn, "SELECT * FROM `sining_artists` WHERE artistId = '$user_id'") or die('query failed');

    if(mysqli_num_rows($select) > 0){
        while($row = mysqli_fetch_assoc($select)){
            $email = $row['artistEmail'];
            $post_time = $row['regAtime'];
			$post_date = $row['regAdate'];
            $curr_time = time();
			$real_time = $curr_time - $post_time;
			$real_min = $real_time / 60;
        }
        if($real_min < 1 && $real_min < 2){
            $query = mysqli_query($conn, "UPDATE sining_artists SET isActivated = '1' WHERE otp_code = '$otp'") or die('query failed');
            echo "Your account has been activated!";
        }
        else if ($real_min >= 2){
            echo "OTP Code has expired!<br>";

            echo "
                <form action='' method='post'>
                    <button type='submit' name='resend'>Resend OTP Code</button>
                </form>
            ";
        }
   }
   else{
    echo "Incorrect code!";
   }
}
if (isset($_POST['resend'])) {
    $newotp = rand(1111, 9999);
    $newtime = time();
    $query = mysqli_query($conn, "UPDATE sining_artists SET otp_code = '$newotp', regAtime = '$newtime' WHERE artistId = '$user_id'") or die('query failed');
    $select = mysqli_query($conn, "SELECT * FROM `sining_artists` WHERE artistId = '$user_id'") or die('query failed');
    if(mysqli_num_rows($select) > 0){
        while($row = mysqli_fetch_assoc($select)){
            $email = $row['artistEmail'];
        }
            $mail = new PHPMailer(true);

            $mail -> isSMTP();
            $mail -> Host = 'smtp.gmail.com';
            $mail -> SMTPAuth = true;
            $mail -> Username = 'sugaxxminyoongixxagustd@gmail.com';
            $mail -> Password = 'ubagorbqalazafob';
            $mail -> SMTPSecure = 'ssl';
            $mail -> Port = 465;

            $mail -> setFrom('sugaxxminyoongixxagustd@gmail.com');

            $mail -> addAddress($email);

            $mail -> isHTML(true);

            $mail -> Subject = "Account Verification Code";
            $message = "Here's the code to activate your account: " . $newotp;
      
            $signature = "<html><body><br><img src='https://siningecommercewebsite.000webhostapp.com/img/Siningesign.jpg' alt='' class='img-responsive'></body></html>";
            $mail->Body = "<p>$message</p>$signature";

            $mail -> send();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>OTP</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script>
</head>
<body>
    <h4><p>OTP code will expire in <h1 id="countdown">2:00</h1></p></h4>
    <form action='' method='post'>
        <button type='submit' name='resend'>Resend OTP Code</button>
    </form>
    <form action="" method="post">
        <input type="text" name="code">
        <button type="submit" name="submit">Verify</button>
    </form>

    <script>
        // Set the countdown duration in minutes
        var countdownDuration = 2;
        
        // Calculate the end time in milliseconds
        var endTime = new Date().getTime() + countdownDuration * 60 * 1000;
        
        // Update the countdown every second
        var countdownInterval = setInterval(updateCountdown, 1000);
        
        // Function to update the countdown timer
        function updateCountdown() {
            // Get the current time
            var currentTime = new Date().getTime();
            
            // Calculate the remaining time
            var remainingTime = endTime - currentTime;
            
            // Calculate minutes and seconds
            var minutes = Math.floor(remainingTime / (1000 * 60));
            var seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);
            
            // Add leading zeros if necessary
            var formattedMinutes = ("0" + minutes).slice(-2);
            var formattedSeconds = ("0" + seconds).slice(-2);
            
            // Display the remaining time
            document.getElementById("countdown").innerHTML = formattedMinutes + ":" + formattedSeconds;
            
            // Check if the countdown has finished
            if (remainingTime <= 0) {
                clearInterval(countdownInterval);
                document.getElementById("countdown").innerHTML = "code has expired";
            }
        }
    </script>
</body>
</html>