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
    if ($_SESSION["OverBillAmount"]) {
      $_SESSION["OverBillAmount"]=false;
      echo "<script>alert('The Total price is higher than expect') </script>";
      $User_name=$_SESSION["User_name"];
    }
    elseif ($_SESSION["BellowBillAmount"]) {
      $_SESSION["BellowBillAmount"]=false;
      echo "<script>alert('The Total price is lower than expect') </script>";
      $User_name=$_SESSION["User_name"];
    }
    else {
      $User_name=$_POST["User_name"];
      $_SESSION["User_name"]=$User_name;
    }
    $_SESSION["Addperson"]=true;

    $Bill_amount=$_SESSION["Bill_amount"];
    $sql = "SELECT COUNT(*) as c FROM Bill_detail WHERE Bill_ID={$_SESSION['Bill_ID']};";
    $result = $index->querySingle($sql);
    $counts= $result["c"];
    if ($counts==0) {
      $Suggestion=$Bill_amount/$_SESSION["People_number"];
    }
    else {
      $stmt = $db->prepare("SELECT * FROM Bill_detail WHERE Bill_ID=:Bill_ID;");
      $stmt->bindValue(':Bill_ID', $_SESSION['Bill_ID'],SQLITE3_INTEGER);
      $results = $stmt->execute();
      while ($row = $results->fetchArray()) {
        $Bill_amount=$Bill_amount-$row["price"];
      }
      $Suggestion=$Bill_amount/($_SESSION["People_number"]-$counts);
    }
    $Suggestion=number_format((float)$Suggestion, 2, '.', '');
     ?>
 <form action="add_person_action.php" method="post">
   <?php
   echo $User_name."<br>";
   echo "Bill amount:".$Bill_amount;
   echo "<br>";
   echo "Suggest:".$Suggestion."(average value)";
   ?>
   <div class="Input">
     <br>
     <label>The price </label><input type="text" name="price" value="<?php echo $Suggestion; ?>"><br/>
     <label for="completeness">Payment Status:</label>
     <select name="completeness">
       <option value="Not paid">Not paid</option>
       <option value="paid">paid</option>
     </select>
   </div>
   <br>
 <button class= 'button button1' type='submit'>ADD a new Person</button>
 </form>
 <br>
 <form class="" action="Bill_detail.php">
   <button class="button button5" type="submit">Back</button>
 </form>

</body>
</html>
