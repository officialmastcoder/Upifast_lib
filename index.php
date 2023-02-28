<!DOCTYPE html>
<html>
<head>
<title>Payment Gateway - Test Demo</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container p-5">
    
<div class="row">
    
<div class="col-md-4 mb-2 card p-4">    

          
<img class="img-fluid" src="https://www.ahkwebsolutions.com/public/uploads/all/V1Nhk6tW8FrtCAzxbkDHdYy1x3LX4bj1toFV4AUs.svg" alt="alternative">

<img class="img-fluid mt-2" src="../images/step1-illus.svg">

</div>    
    
<div class="col-md-7 mb-2">
    
<h2>Test Demo</h2>
<span>Fill Payment Detail and Pay</span><hr>
<form action="txnProcess.php" method="post">
<h4>Gateway Type:</h4>
<select type="text" name="gateway_type" class="form-control" required>
<option "Advanced">Advanced</option>
<option "Robotics">Robotics</option>
<option "Normal">Normal</option>
</select>    
<br>
<h4>Txn Amount:</h4>
<input type="text" name="txnAmount" value="1" class="form-control" required><br>
<h4>Txn Note:</h4>
<input type="text" name="txnNote" value="Test Payment" placeholder="Enter Txn Note" class="form-control" required><br>
<h4>Mobile No:</h4>
<input type="text" name="cust_Mobile" placeholder="Enter Your Mobile"  maxlength="10" class="form-control" required><br>
<h4>Email:</h4>
<input type="email" name="cust_Email" placeholder="Enter Your Email"  class="form-control" required><br>
<input type="submit" value="Payment" class="btn btn-primary">
</form>
</div> 

    
<div class="col-md-12 mt-5 mb-4 card p-4">    
<h2>Video Tutorial</h2>
<span>Video tutorial help to understand how to rechpay gateway work</span><hr>


</div>  

</div>

</div>    
</body>
</html>