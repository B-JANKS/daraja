<?php 
session_start();

include "dbconn.php";
if(isset($_POST['submit']) && isset($_POST['mobile']) ){

$phone =$_POST['mobile'];
$amount =$_POST['amount'];
$invoice =date('ymdhis');
$status ="unpaid";

//call mpesa stkpush function exist
$response = mpesa($phone,$amount,$invoice);
if($response ==0){
    //insert transaction to the invoice table
header("location: index.php?error=Please enter your mpesa pin ");

}else{
    header("location: index.php?error=An error occured ");

}









}else{
    echo"connection failed";
}