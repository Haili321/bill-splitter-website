<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="css/main.css" type="text/css" charset="utf-8">
  <link href="https://fonts.googleapis.com/css?family=Muli&display=swap" rel="stylesheet">
<title>Bill Spitter!</title>
</head>

<body>
  <?php
  session_start();
  error_reporting(E_ALL);
  ini_set(“display_errors”, 1);
  require "database.php";
  $index=new Database();
  if ($_SESSION['PasswordChangeprocess']) {
    echo "<script>alert('Password changed!') </script>";
    $_SESSION['PasswordChangeprocess']=false;
    session_start();
    $_SESSION = array();
    session_destroy();
  }
  if ($_SESSION['Loginfail']) {
    echo "<script>alert('Email or password is wrong') </script>";
    $_SESSION['Loginfail'] = false;
  }
   ?>
  <img src="Logo2.png" alt="">
  <br>
  <form action="login.php" method="post">
  <div class="Input">
    <label>Email</label> <br>
    <input name="email" type="text"><br>
    <label>User password</label> <br>
    <input type="password" name="user_password">
  </div>
<button class="button button1">Log in</button><br>
<button class="button button5" type="submit" formaction="forgetpassword.php">Forget password?</button>
</form>
<br>

<form action="register.php">
Click here if you have not registered yet: <br>
<button class="buttonRegister" style="vertical-align:middle"><span>Register </span></button>
</form>
<br>

</body>
</html>
