<!DOCTYPE html>
 <html>
 <head>
   <link rel="stylesheet" href="css/main.css" type="text/css" charset="utf-8">
   <link href="https://fonts.googleapis.com/css?family=Muli&display=swap" rel="stylesheet">
 <title>Register web page</title>
 </head>
 <body>
   <img src="Logo2.png" alt="Italian Trulli">
   <br>
   <?php
   session_start();
   error_reporting(E_ALL);
   ini_set(“display_errors”, 1);
   require "database.php";
   $index = new Database();
   if ($_SESSION['Verify_CodeWrong']) {
     $_SESSION['Verify_CodeWrong'] = false;
     echo "<script>alert('The verify code is wrong')</script>";
   }
    ?>

 <form action="changepassword.php" method="post">
   <div class="Input">
     </select>
     <br>
     <h2>Verify Code: (Check your email)</h2><input type="text" name="code"><br/>
   </div>
 <button class="button button1">change password!</button><br>
 </form>
 </body>
 </html>
