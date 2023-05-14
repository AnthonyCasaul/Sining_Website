<?php
include 'condb.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$approve = $_POST['approve'];
$ship = $_POST['ship'];
$decline = $_POST['decline'];
$orderReceive = $_POST['orderReceive'];

$mail = new PHPMailer(true);

$mail -> isSMTP();
$mail -> Host = 'smtp.gmail.com';
$mail -> SMTPAuth = true;
$mail -> Username = 'sugaxxminyoongixxagustd@gmail.com';
$mail -> Password = 'ubagorbqalazafob';
$mail -> SMTPSecure = 'ssl';
$mail -> Port = 465;
$mail -> setFrom('sugaxxminyoongixxagustd@gmail.com');



if(isset($_POST['approve'])){


    $approved = mysqli_query($conn, "UPDATE `product_status` SET product_status = 'To pay' WHERE product_id = '$approve'");

    $getall = mysqli_query($conn, "SELECT * FROM `product_status` WHERE product_id = '$approve'");
    $row1 = mysqli_fetch_assoc($getall);
    $buyername = $row['buyer_name'];
    $sellerId = $row1['seller_id'];
    $buyerId = $row1['buyer_id'];
    $notificationBuyer = "The payment method of your order has been approved by the seller.";
    $notificationSeller = "You have approved the payment method for the order of ".$buyername.".";

    mysqli_query($conn, "INSERT INTO `notifications`(notification_id, buyer_id, seller_id, notificationSeller, notificationBuyer, date) VALUES ('', '$buyerId', '$sellerId', '$notificationSeller', '$notificationBuyer', NOW())");

    $getsellerId = mysqli_query($conn, "SELECT a.*, b.artistEmail, b.artistName, c.seller_name FROM `product_status` AS a LEFT JOIN `sining_artist` AS b ON a.buyer_id = b.artistId LEFT JOIN `sining_sellers` AS c ON a.seller_id = c.seller_id WHERE product_id = '$approve'");
    $row = mysqli_fetch_assoc($getsellerId);
    $buyerEmail = $row['artistEmail'];
    $buyerName = $row['artistName'];
    $productName = $row['product_name'];
    $sellerName = $row['seller_name'];


    $approveSUB = "Your order has been approved";
    $approveMSG = "<pre>Dear ".$buyerName.",

    We are pleased to inform you that your order for ".$productName." has been approved by the seller, and we are now ready to proceed with the payment process.
    
    We would like to take this opportunity to thank you for showing interest in our artwork. We are confident that you will be delighted with your purchase,
    and we look forward to completing this transaction with you.
    
    To continue with the process, please proceed with the payment as per the agreed terms and conditions. Once the payment has been received,
    we will arrange for the delivery of the artwork to your preferred address.
    
    We hope that you will enjoy your new artwork for many years to come. If you have any questions or concerns, please do not hesitate to contact us.
    
    Thank you again for your business.
    
    Sincerely,
    
    ".$sellerName."</pre>";

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

    $mail -> Subject = $approveSUB;

    $signature = "<html><body><br><img src='https://siningecommercewebsite.000webhostapp.com/img/Siningesign.jpg' alt='' class='img-responsive'></body></html>";
    $mail->Body = "<p>$approveMSG</p>$signature";

    $mail -> send();

    echo "
            <script>
                alert('Sent Successfully');
                document.location.href = 'seller.php';
            </script>
    ";
}
if(isset($_POST['ship'])){
    $shipped = mysqli_query($conn, "UPDATE `product_status` SET product_status = 'To receive' WHERE product_id = '$ship'");

    $getall = mysqli_query($conn, "SELECT * FROM `product_status` WHERE product_id = '$ship'");
    $row1 = mysqli_fetch_assoc($getall);
    $buyername = $row1['buyer_name'];
    $sellerId = $row1['seller_id'];
    $buyerId = $row1['buyer_id'];
    $notificationBuyer = "Your order have been shipped by the seller.";
    $notificationSeller = "You have shipped the order of ".$buyername.".";

     mysqli_query($conn, "INSERT INTO `notifications`(notification_id, buyer_id, seller_id, notificationSeller, notificationBuyer, date) VALUES ('', '$buyerId', '$sellerId', '$notificationSeller', '$notificationBuyer', NOW())");

    $getsellerId = mysqli_query($conn, "SELECT a.*, b.artistEmail, b.artistName, c.seller_name FROM `product_status` AS a LEFT JOIN `sining_artists` AS b ON a.buyer_id = b.artistId LEFT JOIN `sining_sellers` AS c ON a.seller_id = c.seller_id WHERE product_id = '$ship'");
    $row = mysqli_fetch_assoc($getsellerId);
    $buyerEmail = $row['artistEmail'];
    $buyerName = $row['artistName'];
    $productName = $row['product_name'];
    $sellerName = $row['seller_name'];

    $shipSUB = "Your order has been shipped";
    $shipMSG = "<pre>Dear ".$buyerName.",

    We are pleased to inform you that your artwork, ".$productName.", has been shipped and is on its way to your preferred address.

    We would like to take this opportunity to thank you for your purchase and for choosing our artwork.
    We hope that you will be delighted with it and that it will bring you many years of enjoyment.

    As per our agreement, we have shipped the artwork via [Shipping Company] with tracking number [Tracking Number].
    You can use this number to track your shipment and estimate the expected delivery date.

    Please note that in some cases, there may be a delay in delivery due to unforeseen circumstances. 
    However, we will do our best to ensure that your artwork arrives at your doorstep in a timely manner.

    If you have any questions or concerns about your shipment, please do not hesitate to contact us. We are always here to assist you in any way possible.

    Once again, thank you for your business, and we look forward to hearing from you soon.

    Sincerely,

    ".$sellerName."</pre>";

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

    $mail -> Subject = $shipSUB;

    $signature = "<html><body><br><img src='https://siningecommercewebsite.000webhostapp.com/img/Siningesign.jpg' alt='' class='img-responsive'></body></html>";
    $mail->Body = "<p>$shipMSG</p>$signature";

    $mail -> send();

    echo "
            <script>
                alert('Sent Successfully');
                document.location.href = 'seller.php';
            </script>
    ";
}
if(isset($_POST['decline'])){
    $declined = mysqli_query($conn, "UPDATE `product_status` SET product_status = 'Cancelled' WHERE product_id = '$decline'");

    $getall = mysqli_query($conn, "SELECT * FROM `product_status` WHERE product_id = '$decline'");
    $row1 = mysqli_fetch_assoc($getall);
    $buyername = $row['buyer_name'];
    $sellerId = $row1['seller_id'];
    $buyerId = $row1['buyer_id'];
    $notificationBuyer = "Your payment method have been declined by the seller.";
    $notificationSeller = "You have declined the order of ".$buyername.".";

     mysqli_query($conn, "INSERT INTO `notifications`(notification_id, buyer_id, seller_id, notificationSeller, notificationBuyer, date) VALUES ('', '$buyerId', '$sellerId', '$notificationSeller', '$notificationBuyer', NOW())");

    $getsellerId = mysqli_query($conn, "SELECT a.*, b.artistEmail, b.artistName, c.seller_name FROM `product_status` AS a LEFT JOIN `sining_artists` AS b ON a.buyer_id = b.artistId LEFT JOIN `sining_sellers` AS c ON a.seller_id = c.seller_id WHERE product_id = '$decline'");
    $row = mysqli_fetch_assoc($getsellerId);
    $buyerEmail = $row['artistEmail'];
    $buyerName = $row['artistName'];
    $productName = $row['product_name'];
    $sellerName = $row['seller_name'];

    $declineSUB = "Your order has been declined";
    $declineMSG = "<pre>Dear ".$buyerName.",

    We regret to inform you that your order for ".$productName." has been declined by the seller.

    We understand that this may be disappointing news, and we apologize for any inconvenience this may have caused you. 
    Unfortunately, there may be various reasons why the seller decided to decline the order, such as availability or pricing issues.

    We appreciate your interest in our artwork and would like to assure you that we are always here to assist you in finding an alternative 
    that meets your requirements. Please do not hesitate to contact us if you need any further assistance.

    Thank you for your understanding, and we hope to have the opportunity to serve you in the future.

    Sincerely,

    ".$sellerName."</pre>";

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

    $mail -> Subject = $declineSUB;

    $signature = "<html><body><br><img src='https://siningecommercewebsite.000webhostapp.com/img/Siningesign.jpg' alt='' class='img-responsive'></body></html>";
    $mail->Body = "<p>$declineMSG</p>$signature";

    $mail -> send();

    echo "
            <script>
                alert('Sent Successfully');
                document.location.href = 'seller.php';
            </script>
    ";
}
if(isset($_POST['orderReceive'])){
    $receive = mysqli_query($conn, "UPDATE `product_status` SET product_status = 'Completed' WHERE product_id = '$orderReceive'");

    $getall = mysqli_query($conn, "SELECT * FROM `product_status` WHERE product_id = '$decline'");
    $row1 = mysqli_fetch_assoc($getall);
    $buyername = $row['buyer_name'];
    $sellerId = $row1['seller_id'];
    $buyerId = $row1['buyer_id'];
    $notificationBuyer = "You have receive your order .";
    $notificationSeller = "You have declined the order of ".$buyername.".";

     mysqli_query($conn, "INSERT INTO `notifications`(notification_id, buyer_id, seller_id, notificationSeller, notificationBuyer, date) VALUES ('', '$buyerId', '$sellerId', '$notificationSeller', '$notificationBuyer', NOW())");

    $getsellerId = mysqli_query($conn, "SELECT a.*, b.artistEmail, b.artistName, c.seller_name FROM `product_status` AS a LEFT JOIN `sining_artists` AS b ON a.buyer_id = b.artistId LEFT JOIN `sining_sellers` AS c ON a.seller_id = c.seller_id WHERE product_id = '$orderReceive'");
    $row = mysqli_fetch_assoc($getsellerId);
    $buyerEmail = $row['artistEmail'];
    $buyerName = $row['artistName'];
    $productName = $row['product_name'];
    $sellerName = $row['seller_name'];

    $getall = mysqli_query($conn, "SELECT * FROM `product_status` WHERE product_id = '$orderReceive'");
    $row1 = mysqli_fetch_assoc($getall);
    $buyername = $row['buyer_name'];
    $sellerId = $row1['seller_id'];
    $buyerId = $row1['buyer_id'];
    $notificationBuyer = "You have receive your order from ".$sellerName.".";
    $notificationSeller = "The order has been received by the client.";

    mysqli_query($conn, "INSERT INTO `notifications`(notification_id, buyer_id, seller_id, notificationSeller, notificationBuyer, date) VALUES ('', '$buyerId', '$sellerId', '$notificationSeller', '$notificationBuyer', NOW())");

    $receiveSUB = "Your order is completed";
    $receiveMSG = "<pre>Dear ".$buyerName.",

    We are pleased to inform you that your order for ".$productName." has been completed,
    and we would like to take this opportunity to thank you for choosing our artwork.

    We hope that you are delighted with your purchase and that it meets your expectations. 
    We would also like to express our gratitude for your business and for giving us the opportunity to serve you.

    We take great pride in our artwork and aim to provide our customers with a positive and satisfying experience. 
    We hope that you will enjoy your new artwork for many years to come.

    If you have any questions or concerns about your order or if there is anything else that we can assist you with, 
    please do not hesitate to contact us. We are always here to assist you in any way possible.

    Once again, thank you for your business, and we look forward to hearing from you soon.

    Sincerely,

    ".$sellerName."</pre>";

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

    $mail -> Subject = $receiveSUB;

    $signature = "<html><body><br><img src='https://siningecommercewebsite.000webhostapp.com/img/Siningesign.jpg' alt='' class='img-responsive'></body></html>";
    $mail->Body = "<p>$receiveMSG</p>$signature";

    $mail -> send();

    echo "
            <script>
                alert('Sent Successfully');
                document.location.href = 'seller.php';
            </script>
    ";
}
?>