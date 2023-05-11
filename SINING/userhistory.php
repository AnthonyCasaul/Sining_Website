<?php

error_reporting(E_ERROR | E_PARSE);
@include 'condb.php';
session_start();
$user_id = $_SESSION['user_id'];
$artist = $_SESSION['artistid'];
$artid = $_SESSION['artid'];

if(!isset($user_id)){
   header('location:index.php');
};

if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy();
   header('location:index.php');
}

if(isset($_POST['selectedOption'])) {
  $selectedOption = $_POST['selectedOption'];
  $stmt = $conn->prepare("INSERT INTO `product_status` (payment_method) VALUES ('$selectedOption')");
  $stmt->bind_param("s", $selectedOption);
}

  if(isset($_GET['remove'])){
     $remove_id = $_GET['remove'];
     mysqli_query($conn, "UPDATE `product_status` SET `product_status`='Cancelled' WHERE product_id = '$remove_id'");
     header('location:userhistory.php');
  };
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>History</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
	<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/historystyle.css">
	<script async src="https://pay.google.com/gp/p/js/pay.js" onload="onGooglePayLoaded()"></script>
	<?php
		include("navbar.php");
	?>
</head>
<body>


<div class="container cont">
  <div class="tablinks-wrapper">
	<div class="opts">
  <button class="tablinks" onclick="openCity(event, 'tobeApproved')" id="defaultOpen">To be Approved</button>
	<button class="tablinks" onclick="openCity(event, 'toPay')">To Pay</button>
  	<button class="tablinks" onclick="openCity(event, 'toShip')">To Ship</button>
  	<button class="tablinks" onclick="openCity(event, 'toReceive')">To Receive</button>
    <button class="tablinks" onclick="openCity(event, 'completed')">Completed</button>
    <button class="tablinks" onclick="openCity(event, 'cancelled')">Cancelled</button>
    <button class="tablinks" onclick="openCity(event, 'tobePickup')">For Pick-up</button>
	</div>
  </div>

<input type="hidden" id="price" value="20000"/>
<div id="tobeApproved" class="tabcontent">
  <h1>To be approved</h1>
  <?php
 		$user_info = mysqli_query($conn, "SELECT a.*, c.seller_name, c.seller_email FROM `product_status` AS a 
                                      LEFT JOIN `sining_sellers` AS c ON a.seller_id = c.seller_id
                                      WHERE buyer_id='$user_id' AND product_status = 'To be approved'");
 		if(mysqli_num_rows($user_info) > 0){
            while($fetch_artist = mysqli_fetch_assoc($user_info)){

 		echo '<img src="seller_file/artworks/seller_'.$fetch_artist['seller_id'].'/'.$fetch_artist['product_image'].'" alt="" width=300 class="img-fluid">';
 		echo '<h3>'.$fetch_artist['product_name'].'</h3>';
 		echo '<h3>x'.$fetch_artist['product_quantity'].'</h3>';
 		echo '<h3>'.$fetch_artist['seller_name'].'</h3>';
 		echo '<h2>₱'.$fetch_artist['product_price'].'</h2>';
    	echo '<a href="userhistory.php?remove='.$fetch_artist['product_id'].'" class="dlt" onclick="myFunction()">Cancel Order</a>';
 		echo '<hr>';   
 		}
 	}
   ?>

</div>

<div id="toPay" class="tabcontent">
<h1>To Pay</h1>
<?php
 		$user_info = mysqli_query($conn, "SELECT * FROM `product_status` WHERE buyer_id = '$user_id' AND product_status = 'To pay' AND payment_method = 'Bank Transfer'");
 		if(mysqli_num_rows($user_info) > 0){
            while($fetch_artist = mysqli_fetch_assoc($user_info)){
		echo '<div>';		
    echo '<input type="checkbox" name="myCheckbox[]" value="'.$fetch_artist['product_id'].'"/>';
 		echo '<img src="seller_file/artworks/seller_'.$fetch_artist['seller_id'].'/'.$fetch_artist['product_image'].'" alt="" width=300 class="img-fluid">';
 		echo '<h3>'.$fetch_artist['product_name'].'</h3>';
 		echo '<h3>x'.$fetch_artist['product_quantity'].'</h3>';
 		//echo '<h3>'.$fetch_artist['date'].'</h3>';
 		echo '<h2>₱'.$fetch_artist['product_price'].'</h2>';  
		echo '</div>';
 		}
    echo '<div id="container"></div>'; 
 	}

?>
</div>

<div id="toShip" class="tabcontent">
<h1>To be shipped</h1>
<?php
 		$user_info = mysqli_query($conn, "SELECT * FROM `product_status` WHERE buyer_id = '$user_id' AND product_status = 'To ship' AND payment_method = 'Bank Transfer'");
 		if(mysqli_num_rows($user_info) > 0){
            while($fetch_artist = mysqli_fetch_assoc($user_info)){
 		
 		echo '<img src="seller_file/artworks/seller_'.$fetch_artist['seller_id'].'/'.$fetch_artist['product_image'].'" alt="" width=300 class="img-fluid">';
 		echo '<h3>'.$fetch_artist['product_name'].'</h3>';
 		echo '<h3>x'.$fetch_artist['product_quantity'].'</h3>';
 		//echo '<h3>'.$fetch_artist['date'].'</h3>';
 		echo '<h2>₱'.$fetch_artist['product_price'].'</h2>';  
 		}
 	}
?>
</div>

<div id="toReceive" class="tabcontent">
 <h1>Shipped</h1>
 <?php
 		$user_info = mysqli_query($conn, "SELECT * FROM `product_status` WHERE buyer_id='$user_id' AND product_status = 'To receive' AND payment_method = 'Bank Transfer'");
 		if(mysqli_num_rows($user_info) > 0){
            while($fetch_artist = mysqli_fetch_assoc($user_info)){
 		
 	  echo '<img src="seller_file/artworks/seller_'.$fetch_artist['seller_id'].'/'.$fetch_artist['product_image'].'" alt="" width=300 class="img-fluid">';
 		echo '<h3>'.$fetch_artist['product_name'].'</h3>';
 		echo '<h3>x'.$fetch_artist['product_quantity'].'</h3>';
 		//echo '<h3>'.$fetch_artist['date'].'</h3>';
 		echo '<h2>₱'.$fetch_artist['product_price'].'</h2>';
    echo '<button type="button" class="dlt" onclick="orderReceive('.$fetch_artist['product_id'].')">ORDER RECEIVE</button>';

 		}
 	}
?>
</div>


<div id="completed" class="tabcontent">
  <h1>Completed Purchases</h1>
<?php
 		$user_info = mysqli_query($conn, "SELECT * FROM `product_status` WHERE buyer_id='$user_id' AND product_status = 'Completed' AND payment_method = 'Bank Transfer'");
 		if(mysqli_num_rows($user_info) > 0){
            while($fetch_artist = mysqli_fetch_assoc($user_info)){
 		
 		echo '<img src="seller_file/artworks/seller_'.$fetch_artist['seller_id'].'/'.$fetch_artist['product_image'].'" alt="" width=300 class="img-fluid">';
 		echo '<h3>'.$fetch_artist['product_name'].'</h3>';
 		echo '<h3>x'.$fetch_artist['product_quantity'].'</h3>';
 		//echo '<h3>'.$fetch_artist['date'].'</h3>';
 		echo '<h2>₱'.$fetch_artist['product_price'].'</h2>';   
 		}
 	}
?>
</div>

<div id="tobePickup" class="tabcontent">
 <h1>For Pick-up</h1>
 <?php
 		$user_info = mysqli_query($conn, "SELECT * FROM `product_status` WHERE buyer_id='$user_id' AND product_status = 'To pay' AND payment_method = 'Pick-up'");
 		if(mysqli_num_rows($user_info) > 0){
            while($fetch_artist = mysqli_fetch_assoc($user_info)){
 		
 	  echo '<img src="seller_file/artworks/seller_'.$fetch_artist['seller_id'].'/'.$fetch_artist['product_image'].'" alt="" width=300 class="img-fluid">';
 		echo '<h3>'.$fetch_artist['product_name'].'</h3>';
 		echo '<h3>x'.$fetch_artist['product_quantity'].'</h3>';
 		//echo '<h3>'.$fetch_artist['date'].'</h3>';
 		echo '<h2>₱'.$fetch_artist['product_price'].'</h2>';
 		}
 	}
?>
</div>

<div id="cancelled" class="tabcontent">
  <h1>Cancelled Orders</h1>
<?php
 		$user_info = mysqli_query($conn, "SELECT * FROM `product_status` WHERE buyer_id='$user_id' AND product_status = 'Cancelled'");
 		if(mysqli_num_rows($user_info) > 0){
            while($fetch_artist = mysqli_fetch_assoc($user_info)){
 		
 		echo '<img src="seller_file/artworks/seller_'.$fetch_artist['seller_id'].'/'.$fetch_artist['product_image'].'" alt="" width=300 class="img-fluid">';
 		echo '<h3>'.$fetch_artist['product_name'].'</h3>';
 		echo '<h3>x'.$fetch_artist['product_quantity'].'</h3>';
 		//echo '<h3>'.$fetch_artist['date'].'</h3>';
 		echo '<h2>₱'.$fetch_artist['product_price'].'</h2>';
    echo '<hr>';
 		}
 	}
?>
</div>

</div>
<script>
  function orderReceive(product_id){
    alert("Are you sure you have received the right product?");
    console.log(product_id);
    $.ajax({
            type: "POST",
            url: "update_status.php",
            data: {"orderReceive": product_id},
            success: function(result){
            window.location.reload();
    }
  });	
}
</script>
<script>
  const myCheckboxes = document.querySelectorAll('input[name="myCheckbox[]"]');
  var checklist = [];
 function validateCheckboxes() {
    const checkboxes = document.querySelectorAll('input[name="myCheckbox[]"]');
    let isChecked = false;
    checkboxes.forEach((checkbox) => {
      if (checkbox.checked) {
        isChecked = true;
      }
    });
    if (!isChecked) {
      alert('Select at least one artwork before proceeding to checkout.');
      return false;
    }
    return true;
  }

myCheckboxes.forEach(function(myCheckbox) {
  myCheckbox.addEventListener('change', function() {
      if (this.checked) {
        var checked = this.value; // Get the value of the clicked checkbox
        checklist.push(this.value);
        console.log(checklist);

      } 
      else {
        console.log("not checked");
        var unchecked = this.value; 
        var index = checklist.indexOf(unchecked);
          if (index !== -1) {
            checklist.splice(index, 1);
          }
        console.log(checklist);
      }
  });
});
</script>

<script>
function myFunction() {
  confirm("Are you sure you want to cancel?");
}

function openCity(evt, toAction) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(toAction).style.display = "block";
  evt.currentTarget.className += " active";
}
document.getElementById("defaultOpen").click();
</script>
<style>
	header{
		background: #212529
	}
</style>


<script>
// function toPay(){
// 	const productId = $('#productId').val();
// 	console.log(productId);
  /**
   * Define the version of the Google Pay API referenced when creating your
   * configuration
   *
   * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#PaymentDataRequest|apiVersion in PaymentDataRequest}
   */
  const baseRequest = {
    apiVersion: 2,
    apiVersionMinor: 0,
  };

  /**
   * Card networks supported by your site and your gateway
   *
   * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#CardParameters|CardParameters}
   * @todo confirm card networks supported by your site and gateway
   */
  const allowedCardNetworks = [
    "AMEX",
    "DISCOVER",
    "INTERAC",
    "JCB",
    "MASTERCARD",
    "VISA",
  ];

  /**
   * Card authentication methods supported by your site and your gateway
   *
   * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#CardParameters|CardParameters}
   * @todo confirm your processor supports Android device tokens for your
   * supported card networks
   */
  const allowedCardAuthMethods = ["PAN_ONLY", "CRYPTOGRAM_3DS"];

  /**
   * Identify your gateway and your site's gateway merchant identifier
   *
   * The Google Pay API response will return an encrypted payment method capable
   * of being charged by a supported gateway after payer authorization
   *
   * @todo check with your gateway on the parameters to pass
   * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#gateway|PaymentMethodTokenizationSpecification}
   */
  const tokenizationSpecification = {
    type: "PAYMENT_GATEWAY",
    parameters: {
      gateway: "example",
      gatewayMerchantId: "exampleGatewayMerchantId",
    },
  };

  /**
   * Describe your site's support for the CARD payment method and its required
   * fields
   *
   * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#CardParameters|CardParameters}
   */
  const baseCardPaymentMethod = {
    type: "CARD",
    parameters: {
      allowedAuthMethods: allowedCardAuthMethods,
      allowedCardNetworks: allowedCardNetworks,
    },
  };

  /**
   * Describe your site's support for the CARD payment method including optional
   * fields
   *
   * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#CardParameters|CardParameters}
   */
  const cardPaymentMethod = Object.assign({}, baseCardPaymentMethod, {
    tokenizationSpecification: tokenizationSpecification,
  });

  /**
   * An initialized google.payments.api.PaymentsClient object or null if not yet set
   *
   * @see {@link getGooglePaymentsClient}
   */
  let paymentsClient = null;

  /**
   * Configure your site's support for payment methods supported by the Google Pay
   * API.
   *
   * Each member of allowedPaymentMethods should contain only the required fields,
   * allowing reuse of this base request when determining a viewer's ability
   * to pay and later requesting a supported payment method
   *
   * @returns {object} Google Pay API version, payment methods supported by the site
   */
  function getGoogleIsReadyToPayRequest() {
    return Object.assign({}, baseRequest, {
      allowedPaymentMethods: [baseCardPaymentMethod],
    });
  }

  /**
   * Configure support for the Google Pay API
   *
   * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#PaymentDataRequest|PaymentDataRequest}
   * @returns {object} PaymentDataRequest fields
   */
  function getGooglePaymentDataRequest() {
    const paymentDataRequest = Object.assign({}, baseRequest);
    paymentDataRequest.allowedPaymentMethods = [cardPaymentMethod];
    paymentDataRequest.transactionInfo = getGoogleTransactionInfo();
    paymentDataRequest.merchantInfo = {
      // @todo a merchant ID is available for a production environment after approval by Google
      // See {@link https://developers.google.com/pay/api/web/guides/test-and-deploy/integration-checklist|Integration checklist}
      // merchantId: '01234567890123456789',
      merchantName: "SINING PAYMENT",
    };

    paymentDataRequest.callbackIntents = ["PAYMENT_AUTHORIZATION"];

    return paymentDataRequest;
  }

  /**
   * Return an active PaymentsClient or initialize
   *
   * @see {@link https://developers.google.com/pay/api/web/reference/client#PaymentsClient|PaymentsClient constructor}
   * @returns {google.payments.api.PaymentsClient} Google Pay API client
   */
  function getGooglePaymentsClient() {
    if (paymentsClient === null) {
      paymentsClient = new google.payments.api.PaymentsClient({
        environment: "TEST",
        paymentDataCallbacks: {
          onPaymentAuthorized: onPaymentAuthorized,
        },
      });
    }
    return paymentsClient;
  }

  /**
   * Handles authorize payments callback intents.
   *
   * @param {object} paymentData response from Google Pay API after a payer approves payment through user gesture.
   * @see {@link https://developers.google.com/pay/api/web/reference/response-objects#PaymentData object reference}
   *
   * @see {@link https://developers.google.com/pay/api/web/reference/response-objects#PaymentAuthorizationResult}
   * @returns Promise<{object}> Promise of PaymentAuthorizationResult object to acknowledge the payment authorization status.
   */
  function changeStatus(){
    checklist.forEach(element => $.ajax({
    type: "POST",
    url: "toPayUpdate.php",
    data: {"product_id": element},
    success: function(result){
    }
})
);
  }

 function onPaymentAuthorized(paymentData) {
    return new Promise(function (resolve, reject) {
      // handle the response
      processPayment(paymentData)
        .then(function () {
          resolve({ transactionState: "SUCCESS" });
        })
        .catch(function () {
          changeStatus();
          resolve({
            transactionState: "ERROR",
            error: {
              intent: "PAYMENT_AUTHORIZATION",
              message:
                "PAYMENT SUCCESS",
              reason: "PAYMENT_DATA_INVALID",
            },
          });
        });
    });
  }

  /**
   * Initialize Google PaymentsClient after Google-hosted JavaScript has loaded
   *
   * Display a Google Pay payment button after confirmation of the viewer's
   * ability to pay.
   */
  function onGooglePayLoaded() {
    const paymentsClient = getGooglePaymentsClient();
    paymentsClient
      .isReadyToPay(getGoogleIsReadyToPayRequest())
      .then(function (response) {
        if (response.result) {
          addGooglePayButton();
        }
      })
      .catch(function (err) {
        // show error in developer console for debugging
        console.error(err);
      });
  }

  /**
   * Add a Google Pay purchase button alongside an existing checkout button
   *
   * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#ButtonOptions|Button options}
   * @see {@link https://developers.google.com/pay/api/web/guides/brand-guidelines|Google Pay brand guidelines}
   */
  function addGooglePayButton() {
    const paymentsClient = getGooglePaymentsClient();
    const button = paymentsClient.createButton({
      onClick: onGooglePaymentButtonClicked,
    });
    // document.getElementById("container").appendChild(button);
	$('#container').html(button);
  }

  /**
   * Provide Google Pay API with a payment amount, currency, and amount status
   *
   * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#TransactionInfo|TransactionInfo}
   * @returns {object} transaction info, suitable for use as transactionInfo property of PaymentDataRequest
   */
  function getGoogleTransactionInfo() {
	const price = $('#price').val();
    return {
      displayItems: [
        {
          label: "Subtotal",
          type: "SUBTOTAL",
          price: "11.00",
        },
        {
          label: "Tax",
          type: "TAX",
          price: "1.00",
        },
      ],
      countryCode: 'US',
    currencyCode: "USD",
    totalPriceStatus: "FINAL",
    totalPrice: price,
    totalPriceLabel: "Total"
    };
  }

  /**
   * Show Google Pay payment sheet when Google Pay payment button is clicked
   */
  function onGooglePaymentButtonClicked() {

    console.log("hello");
    const paymentDataRequest = getGooglePaymentDataRequest();
    paymentDataRequest.transactionInfo = getGoogleTransactionInfo();

    const paymentsClient = getGooglePaymentsClient();
    paymentsClient.loadPaymentData(paymentDataRequest);
  }

  let attempts = 0;
  /**
   * Process payment data returned by the Google Pay API
   *
   * @param {object} paymentData response from Google Pay API after user approves payment
   * @see {@link https://developers.google.com/pay/api/web/reference/response-objects#PaymentData|PaymentData object reference}
   */
  function processPayment(paymentData) {
    return new Promise(function (resolve, reject) {
      setTimeout(function () {
        // @todo pass payment token to your gateway to process payment
        paymentToken = paymentData.paymentMethodData.tokenizationData.token;

        if (attempts++ % 2 == 0) {
          reject(
            new Error("Every other attempt fails, next one should succeed")
          );
        } else {
          resolve({});
        }
      }, 500);
    });
  }
// }
</script>

</body>
</html>