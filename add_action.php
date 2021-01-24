 <?php
 session_start();
 error_reporting(E_ALL);
 ini_set(“display_errors”, 1);
 require "database.php";
 $index = new Database();
 $db = new Database();
 $listItem = $_POST["NewBill"];
 $Bill_amount= $_POST["amount"];
 $Bill_amount= number_format((float)$Bill_amount, 2, '.', '');
 $People_number= $_POST["number"];
 if ($People_number==null) {
   $People_number=0;
 }
 if ($listItem!=null&&$Bill_amount!=null) {
   $stmt = $db->prepare("INSERT INTO Bill_list VALUES(NULL,:User_ID,:Bill_description,:Bill_amount,:People_number);");
   $stmt->bindValue(':User_ID',$_SESSION['User_ID'],SQLITE3_INTEGER);
   $stmt->bindValue(':Bill_description',$listItem,SQLITE3_TEXT);
   $stmt->bindValue(':Bill_amount',$Bill_amount,SQLITE3_TEXT);
   $stmt->bindValue(':People_number',$People_number,SQLITE3_INTEGER);
   $results = $stmt->execute();
 }
 else {
   $_SESSION["AddBillFail"]=true;
 }
 header('Location:bill_list.php');
  ?>
