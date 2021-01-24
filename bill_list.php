<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="css/main.css" type="text/css" charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Muli&display=swap" rel="stylesheet">
  </head>
  <body>

    <img src="Logo2.png" alt="Italian Trulli">
    <br>
    <div class="Input">
      <h2 style="margin:5px"><?php
      session_start();
      error_reporting(E_ALL);
      ini_set(“display_errors”, 1);
      if ($_SESSION['FirstEntry']){
        $_SESSION['FirstEntry']=false;
        echo "<script>alert('Hello from your Bill Splitter~') </script>";
      }
      if ($_SESSION['AddBillFail']) {
        $_SESSION['AddBillFail']=false;
        echo "<script>alert('Bill description and bill amount is necessary') </script>";
      }
      if ($_SESSION['Notify']) {
        $_SESSION['Notify']=false;
        echo "<script>alert('Succesfully send email') </script>";
      }
      require "database.php";
      $index = new Database();
      $db = new Database();
      $Bill_name="";
      $person_name="";
      $price=0;
      $completeness="";
      $Bill_name="";
      $Bill_amount=0;
      $Total_amount=0;
      $homemate="";

      $stmt = $db->prepare("SELECT * FROM User WHERE User_ID=:User_ID");
      $stmt->bindValue(':User_ID', $_SESSION['User_ID'],SQLITE3_INTEGER);
      $results = $stmt->execute();
      while ($row = $results->fetchArray()) {
        $User_name= $row["User_name"];
        echo "Welcome to your Bill Splitter, ".$row["User_name"];
      }
      echo "<br>";
      $stmt = $db->prepare("SELECT * FROM Bill_list WHERE User_ID=:User_ID");
      $stmt->bindValue(':User_ID', $_SESSION['User_ID'],SQLITE3_INTEGER);
      $results = $stmt->execute();
      while ($row = $results->fetchArray()) {
        $Bill_name=$row["Bill_description"];
        $Bill_amount=$row["Bill_amount"];
        $People_number=$row["People_number"];
        $Total_amount+=$row["Bill_amount"];
        echo "<form action='Bill_detail.php' method='POST'>
        <button class='button button1' name='list_name' type ='submit' value='$Bill_name'>$Bill_name</button>
        Amount:$Bill_amount&pound; People:$People_number
        </form>";
      }
      $_SESSION['$Bill_name'] = $Bill_name;
      $_SESSION['People_number'] = $People_number;
      $_SESSION['Bill_amount'] = $Bill_amount;
      ?>
      <br></h2>
        <form action="add_action.php" method="post">
        Bill description<input type="text" name="NewBill" value="">
        <br>
        Bill amount<input type="text" name="amount" value="">&pound;
        <br>
        Total number of people
        <select name="number" type="text">
          <?php
          $sql = "SELECT COUNT(*) as c FROM User;";
          $result = $index->querySingle($sql);
          $counts= $result["c"];
          for ($i=1; $i <=$counts; $i++) {
            echo "<option value=".$i.">".$i."</option>";
          }
           ?>
        </select> <br>
        <button class="button button1">Add a new bill</button><br>
        </form>
        <br>
    </div>

    <div class="todolist">
      Here is your homemates: <br>
      <?php
      $stmt = $db->prepare("SELECT * FROM User WHERE User_ID!=:User_ID");
      $stmt->bindValue(':User_ID', $_SESSION['User_ID'],SQLITE3_INTEGER);
      $results = $stmt->execute();
      while ($row = $results->fetchArray()) {
        $homemate=$row["User_name"]." ";
        echo "<li>".$homemate."</li>";
      }
       ?>
      <br>
      <br>
      <?php

      echo "<div class='todolist'>
      <table id='customers'>
         <CAPTION><p>Your relevant bills</p></CAPTION>
         <TR><TH>price(&pound;)<TH>status<TH>Bill name<TH>Bill creator</TR>";
      $relevent_money=0;
      $stmt = $db->prepare("SELECT * FROM Bill_detail WHERE Person_name=:User_name");
      $stmt->bindValue(':User_name', $User_name,SQLITE3_TEXT);
      $results = $stmt->execute();
      while ($row = $results->fetchArray()) {
        echo "<TR><TD>".$row["price"];
        echo "<TD>".$row["completeness"];
        $relevent_bill_id=$row["Bill_ID"];
        $relevent_money+=$row["price"];

        $stmt2 = $db->prepare("SELECT * FROM Bill_list WHERE Bill_ID=:relevent_bill_id");
        $stmt2->bindValue(':relevent_bill_id', $relevent_bill_id,SQLITE3_INTEGER);
        $results2 = $stmt2->execute();
        while ($row2 = $results2->fetchArray()) {
          $relevent_bill_creater_ID=$row2["User_ID"];
          $relevent_bill_name=$row2["Bill_description"];
          echo "<TD>".$relevent_bill_name;
          $stmt3 = $db->prepare("SELECT * FROM User WHERE User_ID=:relevent_bill_creater_ID");
          $stmt3->bindValue(':relevent_bill_creater_ID', $relevent_bill_creater_ID,SQLITE3_INTEGER);
          $results3 = $stmt3->execute();
          while ($row3 = $results3->fetchArray()) {
            $relevent_bill_creater_name=$row3["User_name"];
            echo "<TD>".$relevent_bill_creater_name."</TR>";
          }
        }
      }
      $relevent_pending=0;
      $stmt = $db->prepare("SELECT * FROM Bill_detail WHERE Person_name=:User_name AND completeness=:completeness");
      $stmt->bindValue(':User_name', $User_name,SQLITE3_TEXT);
      $stmt->bindValue(':completeness', 'Not paid',SQLITE3_TEXT);
      $results = $stmt->execute();
      while ($row = $results->fetchArray()) {
        $total_pending+=$row["price"];
      }
      $total_paid=$relevent_money-$total_pending;
      $balance=$Total_amount-$relevent_money;

      echo "<TR><TD>Total not paid:"."<TD>".number_format((float)$total_pending, 2, '.', '')."&pound</TR>";
      echo "<TR><TD>Total paid:"."<TD>".number_format((float)$total_paid, 2, '.', '')."&pound</TR>";
      echo "<TR><TD>Bill amount from others:"."<TD>".number_format((float)$relevent_money, 2, '.', '')."&pound</TR>";
      echo "<TR><TD>Bill amount created by you :"."<TD>".number_format((float)$Total_amount, 2, '.', '')."&pound</TR>";
      echo "<TR><TD>Balance:"."<TD>".number_format((float)$balance, 2, '.', '')."&pound</TR></table>";
      ?>
      <br>
      <br>
      <form action="end_session.php">
        <button class="button button5" type="submit" name="button">Log Out</button>
      </form>

    </div>


  </body>
</html>
