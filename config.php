<?Php
session_start();
$Server = 'localhost';
$username = 'sdf';
$password = 'dsf#';
$database = 's';
//echo $Server;
$connection = mysqli_connect($Server,$username,$password);

if($connection)
{
    mysqli_select_db($connection,$database);
}
else
{
    echo "Could not connect to server";
}

?>
