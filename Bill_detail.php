<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="css/main.css" type="text/css" charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Muli&display=swap" rel="stylesheet">
  </head>
  <body>
    <img src="Logo2.png" alt="Italian Trulli">
<?php
session_start();
error_reporting(E_ALL);
ini_set(“display_errors”, 1);
require "database.php";
$index = new Database();
$db = new Database();
$Bill_name="";
$person_name="";
$price=0;
$completeness="";
$Bill_name="";
$Bill_name=$_POST["list_name"];
$Bill_amount=0;

if ($_SESSION["Addperson"]||$_SESSION["Edditperson"]) {
  $Bill_name=$_SESSION["Bill_description"];
  $_SESSION["Addperson"]=false;
  $_SESSION["Edditperson"]=false;
}
$_SESSION["Bill_description"]=$Bill_name;

$Bill_ID=0;
$stmt = $db->prepare("SELECT * FROM Bill_list WHERE Bill_description=:Bill_description;");
$stmt->bindValue(':Bill_description', $_SESSION['Bill_description'],SQLITE3_TEXT);
$results = $stmt->execute();
while ($row = $results->fetchArray()) {
  $Bill_ID=$row["Bill_ID"];
  $Bill_amount=$row["Bill_amount"];
  $People_number=$row["People_number"];
}
$_SESSION["Bill_ID"]=$Bill_ID;
$_SESSION["Bill_amount"]=$Bill_amount;
$_SESSION["People_number"]=$People_number;
 ?>
<div class="todolist">
  <table id='customers'>
   <CAPTION>Bill information</CAPTION>
   <TR><TH ROWSPAN=2><?php echo $Bill_name; ?>
   <TR><TH>person name<TH>person email<TH>price<TH>status</TR>
   <?php

   $stmt = $db->prepare("SELECT * FROM Bill_detail WHERE Bill_ID=:Bill_ID");
   $stmt->bindValue(':Bill_ID',$Bill_ID,SQLITE3_INTEGER);
   $results = $stmt->execute();
   while ($row = $results->fetchArray()) {
     $person_name=$row["Person_name"];
     $person_email=$row["Person_email"];
     $price=$row["price"];
     $completeness=$row["completeness"];
     $Person_ID=$row["Person_ID"];
     $a=$i+1;
     echo "<TR><TD ALIGN=LEFT ROWSPAN=1><form action='Edit_person.php' method='POST'>
     <button class= 'button button5' name='Person_ID' type ='submit' value='$Person_ID'>Edit</button>
     </form>";
     echo "<TD>".$person_name."<TD>".$person_email."<TD>".number_format((float)$price, 2, '.', '')."<TD>".$completeness."</TR>";
     }
     echo "<TR><TH ALIGN=LEFT ROWSPAN=1>Total not paid:";
     $stmt = $db->prepare("SELECT * FROM Bill_detail WHERE Bill_ID=:Bill_ID and completeness=:completeness;");
     $stmt->bindValue(':Bill_ID',$Bill_ID,SQLITE3_INTEGER);
     $stmt->bindValue(':completeness','Not paid',SQLITE3_TEXT);
     $results = $stmt->execute();
     $total_pending=0;
     while ($row = $results->fetchArray()) {
       $total_pending+=$row["price"];
     }
     echo "<TD>".number_format((float)$total_pending, 2, '.', '');
     echo "<TR><TH ALIGN=LEFT ROWSPAN=1>Total paid:";
     $stmt = $db->prepare("SELECT * FROM Bill_detail WHERE Bill_ID=:Bill_ID and completeness=:completeness;");
     $stmt->bindValue(':Bill_ID',$Bill_ID,SQLITE3_INTEGER);
     $stmt->bindValue(':completeness','paid',SQLITE3_TEXT);
     $results = $stmt->execute();
     $total_payment=0;
     while ($row = $results->fetchArray()) {
       $total_payment+=$row["price"];
     }
     echo "<TD>".number_format((float)$total_payment, 2, '.', '');
     echo "<TH ALIGN=LEFT ROWSPAN=1>Target:".$_SESSION['Bill_amount']."&pound";
   ?>
  </tr>
 <table>
 <br>
 <?php
 $sql = "SELECT COUNT(*) as c FROM Bill_detail WHERE Bill_ID=$Bill_ID;";
 $result = $index->querySingle($sql);
 $counts= $result["c"];

 if ($counts<$_SESSION['People_number']) {
   echo "Choose them to add into your bill<br>";

   $User_name="";
   $stmt = $db->prepare("SELECT * FROM User");
   $results = $stmt->execute();
   while ($row = $results->fetchArray()) {
     $User_name=$row["User_name"];
     echo "<form action='add_person.php' method='POST'>
     <button class= 'buttonRegister' name='User_name' type ='submit'
     style='vertical-align:middle' value='$User_name'><span>$User_name</span></button>
     </form>";
   }
 }
 else {
   echo "Check the details then you can notify them by email<br>";
   echo "<form class='' action='notify.php' method='POST'>
     <button class= 'button button1'
     type='submit' name='Bill_ID' value='$Bill_ID'>Notify them</button>
   </form>";
 }
  ?>
  <br><br><br>
  <form class="" action="Delete_bill.php" method="post">
    <button class="button button3" type="submit" value="123">Delete this bill</button>
  </form>
<br><br><br><br>
 <form class="" action="bill_list.php">
   <button class="button button5" type="submit" value="123">Back</button>
 </form>
</div>
</body>
</html>
