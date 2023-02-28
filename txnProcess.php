<?php
error_reporting(0);
require_once('config.php');
require_once('lib/AhkWeb_Config.php');
require_once('lib/AhkWebCheckSum.php');
if(isset($_POST['amount']) && $_POST['amount']!= NULL ){
$amount = $_POST['amount'];
$checkSum = "";
$upiuid = "";
$paramList = array();

$orderId = "TXN".time();
$txnAmount = $amount;
$txnNote = "Note SImple";
$callback_url = "https://domain//upifast/txnResponse.php";
$AHKWEB_TXN_URL='https://upifast.in/order/payment';
$upiuid = 'upi@paytm'; // Its Your Self UPI ID.
$token = "";
$secret = "s";
$userid = $_SESSION['userid'];
$insert = mysqli_query($connection,"INSERT INTO `upifast`(`userid`, `txn_id`, `amount`, `status`) VALUES ('$userid','$orderId','$txnAmount','pending')");
if($insert){
        // Create an array having all required parameters for creating checksum.
    $paramList["upiuid"] = $upiuid;
    $paramList["token"] = $token;
    $paramList["orderId"] = $orderId ;
    $paramList["txnAmount"] = $txnAmount;
    $paramList["txnNote"] = $txnNote;
    $paramList["callback_url"] = $callback_url;
    
    $checkSum = AhkWebCheckSum::generateSignature($paramList,$secret);
    if($checkSum!=NULL){
        ?>
        <html>
    <head>
    <title>Gateway Check Out Page</title>
    </head>
    <body>
    	<center><h1>Please do not refresh this page...</h1></center>
    		<form method="post" action="<?php echo $AHKWEB_TXN_URL ?>" name="f1">
    		<table border="1">
    			<tbody>
    			<?php
    			foreach($paramList as $name => $value) {
    				echo '<input type="hidden" name="' . $name .'" value="' . $value . '">';
    			}
    			?>
    			<input type="hidden" name="checksum" value="<?php echo $checkSum ?>">
    			</tbody>
    		</table>
    		<script type="text/javascript">
    			document.f1.submit();
    		</script>
    	</form>
    </body>
    </html>
        <?php
    }
}else{
    echo "data Coult Not  be Insert";
}


}
?>