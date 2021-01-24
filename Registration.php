<?php
session_start();
error_reporting(E_ALL);
ini_set(“display_errors”, 1);
require "database.php";
$index = new Database();
$username = $_POST["Username"];
$useremail = $_POST["email"];
$password = $_POST["Password"];
$ConfirmPassword= $_POST["ConfirmedPassword"];

$salt = sha1(time());
$encrypted_password = sha1($salt."--".$password);

$uppercase = preg_match('@[A-Z]@', $password);
$lowercase = preg_match('@[a-z]@', $password);
$number    = preg_match('@[0-9]@', $password);
$specialChars = preg_match('@[^\w]@', $password);

$sql = "SELECT COUNT(*) as c FROM User WHERE User_Email= '$useremail';";
$result = $index->querySingle($sql);
$counts= $result["c"];
if ($counts>0) {
  $_SESSION['UserExisted']=true;
  $_SESSION['fillname']=$username;
  header('Location:register.php');
}
elseif (filter_var($useremail, FILTER_VALIDATE_EMAIL)==false) {
  $_SESSION['EmailInvalid']=true;
  $_SESSION['fillemail']=$useremail;
  $_SESSION['fillname']=$username;
  header('Location:register.php');
}
elseif ($username==null||$useremail==null||$password==null||$ConfirmPassword==null) {
  $_SESSION['LeaveSpace']=true;
  $_SESSION['fillemail']=$useremail;
  $_SESSION['fillname']=$username;
  header('Location:register.php');
}
elseif ($password!=$ConfirmPassword) {
  $_SESSION['DifferntPassword']=true;
  $_SESSION['fillemail']=$useremail;
  $_SESSION['fillname']=$username;
  header('Location:register.php');
}
elseif (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 6){
  $_SESSION['PasswordWeak']=true;
  $_SESSION['fillemail']=$useremail;
  $_SESSION['fillname']=$username;
  header('Location:register.php');
}
else {
  $to = $useremail;
  $subject = "Your Verify Code Here";
  $Pin = rand(11111,99999);
  $txt = "Hello ".$username."! Welcome to Bill Splitter~\nThe verify code is: ".$Pin;
  $headers = "From: Haili.Yuan@warwick.ac.uk";

  mail($to,$subject,$txt,$headers);
  $_SESSION['$username'] = $username;
  $_SESSION['$useremail'] = $useremail;
  $_SESSION['$password'] = $password;
  $_SESSION['$ConfirmPassword'] = $ConfirmPassword;
  $_SESSION['$Pin'] = $Pin;
  $_SESSION['$encrypted_password'] = $encrypted_password;
  $_SESSION['$salt'] = $salt;
  header('Location:verify.php');
}
 ?>
