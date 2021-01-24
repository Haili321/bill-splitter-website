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
$_SESSION["Edditperson"]=true;
if ($_SESSION["OverBillAmount"]) {
  $_SESSION["OverBillAmount"]=false;
  echo "<script>alert('The Total price is higher than expect') </script>";
  $Person_ID=$_SESSION["Person_ID"];
}
else {
  $Person_ID=$_POST["Person_ID"];
  $_SESSION["Person_ID"]=$Person_ID;
}

$Bill_ID=$_SESSION["Bill_ID"];
$stmt = $db->prepare("SELECT * FROM Bill_detail WHERE Bill_ID=:Bill_ID and Person_ID=:Person_ID;");
$stmt->bindValue(':Bill_ID',$Bill_ID,SQLITE3_INTEGER);
$stmt->bindValue(':Person_ID',$Person_ID,SQLITE3_INTEGER);
$results = $stmt->execute();
while ($row = $results->fetchArray()) {
  $Person_name= $row["Person_name"];
  $Person_email= $row["Person_email"];
  $price = $row["price"];
  $completeness= $row["completeness"];
}
 ?>
 <div class="todolist">
   <table id='customers'>
     <br>
   <CAPTION>Person information</CAPTION>
   <TR><TH>person name<TH>person email<TH>price<TH>completeness</TR>
   <?php echo "<TD>".$Person_name."<TD>".$Person_email."<TD>".$price."<TD>".$completeness."</TR>"; ?>
   </tr>
 </table>
</div>
   <form action="Edit_details.php" method="post">
     <div class="Input">
       <br>
       <label>New price(optional)<br> </label><input type="text" name="Newprice" value="<?php echo $Suggestion; ?>"><br/>
       <label for="Newcompleteness">Payment Status:</label><br>
       <select name="Newcompleteness">
         <option value="Not paid">Not paid</option>
         <option value="paid">paid</option>
       </select> <br><br>
     </div>
   <button class="button button1" type="submit">Change Details</button><br><br><br>
   <button class="button button3" type="submit" formaction="Edit_details2.php">Delete this person</button>
   <br><br><br>
   </form>
   <form class="" action="Bill_detail.php">
     <button class="button button5" type="submit">Back</button>
   </form>
</body>
</html>
