<?php
session_start();
error_reporting(E_ALL);
ini_set(“display_errors”, 1);
require "database.php";
$index = new Database();
$db = new Database();
$Newprice= $_POST["Newprice"];
$Newprice= number_format((float)$Newprice, 2, '.', '');
$Newcompleteness= $_POST["Newcompleteness"];

$Total_price=0;
$stmt = $db->prepare("SELECT * FROM Bill_detail WHERE Bill_ID=:Bill_ID AND Person_ID!=:Person_ID;");
$stmt->bindValue(':Bill_ID',$_SESSION['Bill_ID'],SQLITE3_INTEGER);
$stmt->bindValue(':Person_ID',$_SESSION["Person_ID"],SQLITE3_INTEGER);
$results = $stmt->execute();
while ($row = $results->fetchArray()) {
  $Total_price+=$row["price"];
}
$Total_price+=$Newprice;
if ($Total_price>$_SESSION["Bill_amount"]) {
  $_SESSION["OverBillAmount"]=true;
  header('Location:Edit_person.php');
}

else {
  if ($Newprice!=0) {
    $stmt = $db->prepare("UPDATE Bill_detail SET price =:price WHERE Bill_ID=:Bill_ID AND Person_ID=:Person_ID;");
    $stmt->bindValue(':price',$Newprice,SQLITE3_TEXT);
    $stmt->bindValue(':Bill_ID',$_SESSION["Bill_ID"],SQLITE3_INTEGER);
    $stmt->bindValue(':Person_ID',$_SESSION["Person_ID"],SQLITE3_INTEGER);
    $results = $stmt->execute();
  }

  $stmt = $db->prepare("UPDATE Bill_detail SET completeness =:completeness WHERE Bill_ID=:Bill_ID AND Person_ID=:Person_ID;");
  $stmt->bindValue(':completeness',$Newcompleteness,SQLITE3_TEXT);
  $stmt->bindValue(':Bill_ID',$_SESSION["Bill_ID"],SQLITE3_INTEGER);
  $stmt->bindValue(':Person_ID',$_SESSION["Person_ID"],SQLITE3_INTEGER);
  $results = $stmt->execute();

  $_SESSION["Edditperson"]=true;
  header('Location:Bill_detail.php');
}
 ?>
