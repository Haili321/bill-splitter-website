<?php
session_start();
error_reporting(E_ALL);
ini_set(“display_errors”, 1);
require "database.php";
$index = new Database();
$db = new Database();
$email = $_POST["email"];
$password = $_POST["user_password"];

$a=0;
$stringName="";
$stringPassword="";
$flag=false;
$sql = "SELECT COUNT(*) as c FROM User;";
$result = $index->querySingle($sql);
$counts= $result["c"];

$salt = "";
$encrypted_password = "";

do {
  $a++;
  $stmt = $db->prepare("SELECT * FROM User WHERE User_ID=:User_ID;");
  $stmt->bindValue(':User_ID',$a,SQLITE3_INTEGER);
  $results = $stmt->execute();
  while ($row = $results->fetchArray()) {
    $stringName= $row["User_Email"];
    $stringPassword= $row["User_password"];
    $salt=$row["salt"];
  }
  $encrypted_password=sha1($salt."--".$password);
  if ($stringName==$email&&$stringPassword==$encrypted_password){
    $flag=true;
  }
  } while ($a <= $counts&&$flag==false);
  
if ($flag==true){
  $_SESSION['User_ID'] = $a;
  $_SESSION['FirstEntry']=true;
  header('Location:bill_list.php');
}
else {
  $_SESSION['Loginfail'] = true;
  header('Location:index.php');
}

 ?>
