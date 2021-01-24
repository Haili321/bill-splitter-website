<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="css/main.css" type="text/css" charset="utf-8">
  <link href="https://fonts.googleapis.com/css?family=Muli&display=swap" rel="stylesheet">
<title>Register web page</title>
</head>
<body>
  <img src="Logo2.png" alt="Italian Trulli">
  <?php
  session_start();
  error_reporting(E_ALL);
  ini_set(“display_errors”, 1);
  if ($_SESSION["LeaveSpace2"]) {
    $_SESSION["LeaveSpace2"]=false;
    echo "<script>alert('You should fill all spaces') </script>";
  }
  if ($_SESSION["NotRegistered"]) {
    $_SESSION["NotRegistered"]=false;
    echo "<script>alert('This email is not registered') </script>";
  }
   ?>
  <form action="changepasswordverify.php" method="post">
  <div class="Input">
    <p>Check personal information</p> <br>
    <br>
    <label>Your Email </label><input name="email" type="text"><br/>
    <label>New password</label><input type="password"  name="Newpassword"><br/>
  </div>
  <br>
  <button class="button button1" type="submit">Change Password!</button>
  </form>
  <br>
  <form action="index.php">
    <button class="button button5" type="submit">Back</button>
  </form>
</body>
</html>
