<!DOCTYPE html>
<html>
<head>
<title>Payment Status Check</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container p-5">
<h1>Payment Status Check</h1><hr>
<form action="" method="post">
<h4>Order Id:</h4>
<input type="text" name="orderId" placeholder="Order Id" class="form-control"><br>
<input type="submit" value="Submit" class="btn btn-primary">
</form><br>
<?php
error_reporting(0);
require_once('lib/AhkWeb_Config.php');
require_once('lib/AhkWebCheckSum.php');
if(isset($_POST['orderId'])){
$post = array(
    'token' => $token,
    'orderId' => $_POST['orderId']
	);

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => $AHKWEB_STATUS_URL,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => $post
));
$response = curl_exec($curl);
curl_close($curl);
//echo $response;
$array = json_decode($response);
echo "Payment Status: ".$array->status."<br>";	
echo "Payment Message: ".$array->message."<hr>";	
foreach ($array->result as $key => $value) {
  echo "<b>$key:</b> <b style='color:green'>$value</b><hr>";
}
}
?>
</div>
</body>
</html>