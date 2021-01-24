<?php
session_start();
error_reporting(E_ALL);
ini_set(“display_errors”, 1);
require "database.php";
$index = new Database();
$db = new Database();
$username = $_SESSION['$username'];
$useremail = $_SESSION['$useremail'];
$password = $_SESSION['$password'];
$ConfirmPassword = $_SESSION['$ConfirmPassword'];
$encrypted_password=$_SESSION['$encrypted_password'];
$salt=$_SESSION['$salt'];
$Pin = $_SESSION['$Pin'];
$code = $_POST["code"];

if ($Pin==$code){
  $stmt = $db->prepare("INSERT INTO User VALUES(NULL,:User_Email,:User_name,:User_password,:salt);");
  $stmt->bindValue(':User_Email',$useremail,SQLITE3_TEXT);
  $stmt->bindValue(':User_name',$username,SQLITE3_TEXT);
  $stmt->bindValue(':User_password',$encrypted_password,SQLITE3_TEXT);
  $stmt->bindValue(':salt',$salt,SQLITE3_TEXT);
  $results = $stmt->execute();

  $stmt = $db->prepare("SELECT * FROM User WHERE User_Email=:User_Email;");
  $stmt->bindValue(':User_Email',$useremail,SQLITE3_TEXT);
  $results = $stmt->execute();
  while ($row = $results->fetchArray()) {
    $user_ID=$row["User_ID"];
  }
  $_SESSION['login'] = true;
  $_SESSION['User_ID'] = $user_ID;
  header('Location:forward.php');
}
else {
  $_SESSION['VerifyCodeWrong'] = true;
  header('Location:verify.php');
}
 ?>
