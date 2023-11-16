<?php 
session_start();

function db_conn(){
$sname = "localhost";
$uname = "root";
$password = "";

$db_name = "user_information";

$conn = mysqli_connect($sname, $uname, $password, $db_name );


}

function mpesa($phone,$amount,$invoice){
//callback url
//define('CALLBACK_URL','https/location to folder/file');

//access token
$consumerKey = 'D3UA3HKyLZnNfARAtfUvXOmWIshYgG8A'; //fill with your app consumer key
$consumerSecret ='3DCN0V0GHTfeGBZY'; //fill with app secret

//provide the following details, this part is foundon your test credentials
$BussinessShotCode='174379';
$PassKey='bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
$phone=preg_replace('/^0/','255',str_replace("+","",$phone));
$PartA=$phone; // this is your phone number
$PartB='174379';
$TransactionDesc='Paying to B-janks enterprise';//insert your own description

//get the timestamp, format yymmddhhmmss
$Timestamp =date('YmdHis');
//get the based64 encoded string --> $password. The passkey is the mpesa public
$password = base64_encode($BussinessShotCode.$PassKey.$Timestamp);
//header for access token
$headers=['Content-Type:application/json; charset=utf8'];

//mpesa endpoint urls
$access_token_url='';
$initiate_url ='https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

$curl =curl_init($access_token_url);
curl_setopt($curl,CURLOPT_HTTPHEADER,$headers);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,TRUE);
curl_setopt($curl,CURLOPT_HEADER,FALSE);
curl_setopt($curl,CURLOPT_USERPWD,$consumerKey.':'.$consumerSecret);
$result =curl_exec($curl);
$status =curl_getinfo($curl,CURLINFO_HTTP_CODE);
$result =json_decode($result);
$access_token =$result->access_token;

curl_close($curl);


//a header for stk push
$stkheader=[''];

//initiate the transaction
$curl=curl_init();
curl_setopt($curl,CURLOPT_URL,$initiate_url);
curl_setopt($curl,CURLOPT_HTTPHEADER,$stkheader);//SETTING CUSTOM HEADER
$curl_post_data= array(
    //fill in the request parameters with valid values
    "BusinessShortCode"=> $BussinessShotCode,
    "Password"=>"MTc0Mzc5YmZiMjc5ZjlhYTliZGJjZjE1OGU5N2RkNzFhNDY3Y2QyZTBjODkzMDU5YjEwZjc4ZTZiNzJhZGExZWQyYzkxOTIwMjMxMTE2MDIwODMz",
    "Timestamp"=> $Timestamp,
    "TransactionType"=> "CustomerPayBillOnline",
    "Amount"=> $amount,
    "PartyA"=> $PartA,
    "PartyB"=> $PartB,
    "PhoneNumber"=> $PartA,
    //"CallBackURL"=> CALLBACK_URL.$ordernum,
    //"AccountReference"=> $ordernum,
    "TransactionDesc"=>$TransactionDesc

);
$data_string =json_decode("$curl_post_data");
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl,CURLOPT_POST,true);
curl_setopt($curl,CURLOPT_POSTFIELDS,$data_string);
$curl_response =curl_exec($curl);

$res =(array)(json_decode($curl_response));
$ResponseCode= $res['ResponseCode'];
return $ResponseCode;


function sendSms($phone,$message){

    $apiakey ="";
    $senderName ="ASSIGNED SENDER NAME";

    $bodyRequest =array(
        "mobile"=>$phone,
        "mobile"=>"jason",
        "sender_name"=>$senderName,
        "service_id"=>0,
        "message"=>$message,

    );
}








}