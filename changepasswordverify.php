<?php
session_start();
error_reporting(E_ALL);
ini_set(“display_errors”, 1);
require "database.php";
$index = new Database();
$useremail = $_POST["email"];
$Newpassword = $_POST["Newpassword"];
$sql = "SELECT COUNT(*) as c FROM User WHERE User_Email= '$useremail';";
$result = $index->querySingle($sql);
$counts= $result["c"];

if ($useremail==null||$Newpassword==null) {
  header('Location:forgetpassword.php');
  $_SESSION["LeaveSpace2"]=true;
}
elseif ($counts==0) {
  header('Location:forgetpassword.php');
  $_SESSION["NotRegistered"]=true;
}
else {
  $to = $useremail;
  $subject = "Your Verify Code Here";
  $Pin = rand(11111,99999);
  $txt = "Hello, you're changing your password! Don't tell others the code.\nThe verify code is: ".$Pin;
  $headers = "From: Haili.Yuan@warwick.ac.uk";

  mail($to,$subject,$txt,$headers);
  $_SESSION['$useremail'] = $useremail;
  $_SESSION['$Newpassword'] = $Newpassword;
  $_SESSION['$Pin'] = $Pin;
  header('Location:changepasswordEmailverify.php');
}
 ?>
