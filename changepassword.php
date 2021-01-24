<!DOCTYPE html>
<head>
  <link rel="stylesheet" href="css/main.css" type="text/css" charset="utf-8">
  <link href="https://fonts.googleapis.com/css?family=Muli&display=swap" rel="stylesheet">
</head>
<body>
<?php
session_start();
error_reporting(E_ALL);
ini_set(“display_errors”, 1);
require "database.php";
$index = new Database();
$db = new Database();
$useremail = $_SESSION['$useremail'];
$Newpassword = $_SESSION['$Newpassword'];
$Pin = $_SESSION['$Pin'];
$code = $_POST["code"];

if ($Pin==$code){
  $stmt = $db->prepare("SELECT * FROM User WHERE User_Email=:User_Email");
  $stmt->bindValue(':User_Email',$useremail,SQLITE3_TEXT);
  $results = $stmt->execute();
  while ($row = $results->fetchArray()) {
    $salt=$row["salt"];
  }
  $Newpassword = sha1($salt."--".$Newpassword);

  $stmt = $db->prepare("UPDATE User SET User_password =:User_password WHERE User_Email=:User_Email;");
  $stmt->bindValue(':User_password',$Newpassword,SQLITE3_TEXT);
  $stmt->bindValue(':User_Email',$useremail,SQLITE3_TEXT);
  $results = $stmt->execute();

  $_SESSION['PasswordChangeprocess']=true;
  header('Location:index.php');
}
else {
  $_SESSION['Verify_CodeWrong']=true;
  header('Location:changepasswordEmailverify.php');
}
?>
</body>
</html>
