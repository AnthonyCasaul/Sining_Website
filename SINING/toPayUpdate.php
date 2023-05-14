<?php
include 'condb.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$id=$_POST['product_id'];
    $query = mysqli_query($conn, "UPDATE product_status SET product_status = 'To ship' WHERE product_id = '$id'");

    $getsellerId = mysqli_query($conn, "SELECT a.*, b.artistEmail, b.artistName, c.seller_name FROM `product_status` AS a LEFT JOIN `sining_artists` AS b ON a.buyer_id = b.artistId LEFT JOIN `sining_sellers` AS c ON a.seller_id = c.seller_id WHERE product_id = '$id'");
    $row = mysqli_fetch_assoc($getsellerId);
    $buyerEmail = $row['artistEmail'];
    $buyerName = $row['artistName'];
    $productName = $row['product_name'];
    $sellerName = $row['seller_name'];

    $getall = mysqli_query($conn, "SELECT * FROM `product_status` WHERE product_id = '$id'");
    $row1 = mysqli_fetch_assoc($getall);
    $buyername = $row['buyer_name'];
    $sellerId = $row1['seller_id'];
    $buyerId = $row1['buyer_id'];
    $notificationBuyer = "Your payment was successful.";
    $notificationSeller = "The client has successfully completed the payment through Google Pay services.";

    mysqli_query($conn, "INSERT INTO `notifications`(notification_id, buyer_id, seller_id, notificationSeller, notificationBuyer, date) VALUES ('', '$buyerId', '$sellerId', '$notificationSeller', '$notificationBuyer', NOW())");

    $paidSUB = "The buyer has paid";
    $paidMSG = "<pre>Dear ".$buyerName.",

    We are pleased to inform you that the buyer for ".$productName." has paid for their order.

    We would like to take this opportunity to congratulate you on the successful sale of your artwork, 
    and we thank you for choosing our platform to sell it.We hope that this is the start of a long and fruitful partnership between us.

    As per our agreement, we will now proceed with arranging the delivery of the artwork to the buyer's preferred address. 
    We will keep you updated on the progress of the shipment and provide you with the necessary tracking information once the artwork has been shipped.

    If you have any questions or concerns about the delivery or any other aspect of the transaction, 
    please do not hesitate to contact us. We are always here to assist you in any way possible.

    Once again, thank you for choosing our platform, and we look forward to working with you again in the future.
    
    Sincerely,
    
    JCRA Studio
    SINING Team</pre>";

    $mail = new PHPMailer(true);

    $mail -> isSMTP();
    $mail -> Host = 'smtp.gmail.com';
    $mail -> SMTPAuth = true;
    $mail -> Username = 'sugaxxminyoongixxagustd@gmail.com';
    $mail -> Password = 'ubagorbqalazafob';
    $mail -> SMTPSecure = 'ssl';
    $mail -> Port = 465;

    $mail -> setFrom('sugaxxminyoongixxagustd@gmail.com');

    $mail -> addAddress($buyerEmail);

    $mail -> isHTML(true);

    $mail -> Subject = $paidSUB;

    $signature = "<html><body><br><img src='https://siningecommercewebsite.000webhostapp.com/img/Siningesign.jpg' alt='' class='img-responsive'></body></html>";
    $mail->Body = "<p>$paidMSG</p>$signature";

    $mail -> send();

    echo "
            <script>
                alert('Sent Successfully');
                document.location.href = 'seller.php';
            </script>
    ";
echo $id;
?>