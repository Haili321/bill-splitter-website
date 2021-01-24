 <?php
 session_start();
 error_reporting(E_ALL);
 ini_set(“display_errors”, 1);
 require "database.php";
 $index = new Database();
 $db = new Database();
 $Bill_ID=$_POST["Bill_ID"];

 $stmt = $db->prepare("SELECT * FROM User WHERE User_ID=:User_ID");
 $stmt->bindValue(':User_ID',$_SESSION["User_ID"],SQLITE3_INTEGER);
 $results = $stmt->execute();
 while ($row = $results->fetchArray()) {
   $Host_email=$row["User_Email"];
   $Host_name=$row["User_name"];
 }

 $stmt = $db->prepare("SELECT * FROM Bill_detail WHERE Bill_ID=:Bill_ID");
 $stmt->bindValue(':Bill_ID',$Bill_ID,SQLITE3_INTEGER);
 $results = $stmt->execute();
 while ($row = $results->fetchArray()) {
   $to =$row["Person_email"];
   $username=$row["Person_name"];
   $price=$row["price"];
   $status=$row["completeness"];
   $subject = "Your New Bill";
   $txt = "Hello ".$username."! You have a new Bill from ".$Host_name."\nPrice:".$price."\nYour status:".$status."\nFor more details, please login:\nhttp://cs139.dcs.warwick.ac.uk/~u1898019/cs139/coursework";
   $headers = "From: Haili.Yuan@warwick.ac.uk";
   echo "<br>to".$to;
   echo "<br>username".$username;
   echo "<br>price".$price;
   echo "<br>subject".$subject;
   echo "<br>txt".$txt;
   echo "<br>headers $headers";
   mail($to,$subject,$txt,$headers);
 }
  $_SESSION['Notify']=true;
  header('Location:bill_list.php');
  ?>
