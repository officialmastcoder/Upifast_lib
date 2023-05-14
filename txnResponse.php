<?php
error_reporting(0);
require_once('config.php');
require_once('lib/AhkWeb_Config.php');
require_once('lib/AhkWebCheckSum.php');

if(isset($_POST['status']) && $_POST['status']!=NULL){
    $verifySignature = '';
    $array = array();
    $paramList = array();
    $secret = ' '; // Your Secret Key.
    $status = $_POST['status']; // Its Payment Status Only, Not Txn Status.
    $hash = $_POST['hash']; // Encrypted Hash / Generated Only SUCCESS Status.
    $checksum = $_POST['checksum'];  // Checksum verifySignature / Generated Only SUCCESS Status.
    
    // Payment Status.
    if($status=="SUCCESS"){
    	
    $paramList = hash_decrypt($hash,$secret);
    $verifySignature = AhkWebCheckSum::verifySignature($paramList, $secret, $checksum);
    
    // Checksum verify.
    if($verifySignature){
        $resdata = json_decode($paramList,true);
        $orderid = $resdata['orderId'];
        if($resdata['txnStatus']=="TXN_SUCCESS"){
            $res = mysqli_query($connection,"SELECT * FROM upifast WHERE txn_id='$orderid' AND status='pending' LIMIT 1");
            if(mysqli_num_rows($res)==1){
                $udata = mysqli_fetch_assoc($res);
                $amount = $udata['amount'];
                $userid = $udata['userid'];
                // Set Amount Wise Point here 
                $point = 0;
                $usertype = "RETAILER";
                if($amount == 149){
                    $usertype = "RETAILER";
                    $point  = 750;
                }else if($amount == 549){
                    $usertype = "DISTRIBUTER";
                    $point  = 2750;
                }else if($amount == 799){
                    $usertype = "SUPER DISTRIBUTER";
                    $point  = 5000;
                }else if($amount == 1499){
                    $usertype = "MASTER ADMIN";
                    $point  = 9999999999;
                }else{
                    $usertype = "RETAILER";
                    $point  = $amount;
                }
                $bankTxnId = $resdata['bankTxnId'];
                $updatepg = mysqli_query($connection,"UPDATE upifast SET bank_ref_id='$bankTxnId', status='success'  WHERE txn_id='$orderid' ");
                if($updatepg){
                    $update = mysqli_query($connection,"UPDATE tbluser SET walletamount=walletamount+$point, usertype='$usertype'  WHERE userid='$userid'");
                    if($update){
                        ?>
                        <form action="../panel.php" method="POST" name="f1">
                            <input type="hidden" name="success" value="true">
                        </form>
                        <script>
                            document.f1.submit();
                        </script>
                        <?php 
                    }else{
                        ?>
                        <form action="../panel.php" method="POST" name="f1">
                            <input type="hidden" name="updateerror" value="true">
                        </form>
                        <script>
                            document.f1.submit();
                        </script>
                        <?php 
                    }
                }else{
                    ?>
                        <form action="../panel.php" method="POST" name="f1">
                            <input type="hidden" name="updateerror" value="true">
                        </form>
                        <script>
                            document.f1.submit();
                        </script>
                        <?php 
                }
                
            }else{
                ?>
                <form action="../panel.php" method="POST" name="f1">
                    <input type="hidden" name="alreadydone" value="true">
                </form>
                <script>
                    document.f1.submit();
                </script>
                <?php 
            }
        }else{
            ?>
                <form action="../panel.php" method="POST" name="f1">
                    <input type="hidden" name="notdone" value="true">
                </form>
                <script>
                    document.f1.submit();
                </script>
                <?php 
        }
    
        
    }else{
        ?>
            <form action="../panel.php" method="POST" name="f1">
                <input type="hidden" name="failed" value="true">
            </form>
            <script>
                document.f1.submit();
            </script>
            <?php 
    }	
    	
    
    }else{
         ?>
            <form action="../panel.php" method="POST" name="f1">
                <input type="hidden" name="error" value="true">
            </form>
            <script>
                document.f1.submit();
            </script>
            <?php 
    }
}else{
    ?>
            <form action="../panel.php" method="POST" name="f1">
                <input type="hidden" name="error" value="true">
            </form>
            <script>
                document.f1.submit();
            </script>
            <?php 
}



?>
