<?php
session_start();
error_reporting(E_ALL);
ini_set(“display_errors”, 1);
require "database.php";
$index = new Database();
$db = new Database();
$person_name = $_SESSION["User_name"];
$Bill_ID= $_SESSION["Bill_ID"];
$price= number_format((float)$_POST["price"], 2, '.', '');
$person_email= "";
$completeness=$_POST["completeness"];
$Total_price=0;
$current_person_number=0;
$stmt = $db->prepare("SELECT * FROM Bill_detail WHERE Bill_ID=:Bill_ID");
$stmt->bindValue(':Bill_ID',$Bill_ID,SQLITE3_INTEGER);
$results = $stmt->execute();
while ($row = $results->fetchArray()) {
  $counts= $row["Person_ID"];
  $Total_price+=$row["price"];
  $current_person_number++;
}
$location=$counts+1;
$Total_price+=$price;
if ($Total_price>$_SESSION["Bill_amount"]) {
  $_SESSION["OverBillAmount"]=true;
  header('Location:add_person.php');
}
elseif ($Total_price<$_SESSION["Bill_amount"]&&$current_person_number==$_SESSION["People_number"]-1) {
  $_SESSION["BellowBillAmount"]=true;
  header('Location:add_person.php');
}
else {
  $stmt = $db->prepare("SELECT * FROM User WHERE User_name=:User_name");
  $stmt->bindValue(':User_name',$person_name,SQLITE3_TEXT);
  $results = $stmt->execute();
  while ($row = $results->fetchArray()) {
    $person_email= $row["User_Email"];
  }
  $stmt = $db->prepare("INSERT INTO Bill_detail VALUES(:Bill_ID,:Person_ID,:Person_name,:Person_email,:price,:completeness);");
  $stmt->bindValue(':Bill_ID',$Bill_ID,SQLITE3_INTEGER);
  $stmt->bindValue(':Person_ID',$location,SQLITE3_INTEGER);
  $stmt->bindValue(':Person_name',$person_name,SQLITE3_TEXT);
  $stmt->bindValue(':Person_email',$person_email,SQLITE3_TEXT);
  $stmt->bindValue(':price',$price,SQLITE3_TEXT);
  $stmt->bindValue(':completeness',$completeness,SQLITE3_TEXT);
  $results = $stmt->execute();

  $_SESSION["Addperson"]=true;
  header('Location:Bill_detail.php');
}

 ?>
