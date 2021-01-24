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
  if ($_SESSION['UserExisted']) {
    $_SESSION['UserExisted']=false;
    echo "<script>alert('This email has been registered!') </script>";
  }
  if ($_SESSION['EmailInvalid']) {
    $_SESSION['EmailInvalid']=false;
    echo "<script>alert('This email is not valid!') </script>";
  }
  if ($_SESSION['PasswordWeak']) {
    $_SESSION['PasswordWeak']=false;
    echo "<script>alert('Password Strength is low!') </script>";
  }
  if ($_SESSION['DifferntPassword']) {
    $_SESSION['DifferntPassword']=false;
    echo "<script>alert('Two Password is different!') </script>";
  }
  if ($_SESSION['LeaveSpace']) {
    $_SESSION['LeaveSpace']=false;
    echo "<script>alert('Please fill in all the space') </script>";
  }
   ?>
<form action="Registration.php" method="post">
  <div class="Input">
    </select>
    <br>
    <label>Your email address</label><input name="email" type="text" value="<?php echo $_SESSION['fillemail'];
    $_SESSION['fillemail']=""; ?>"> <br/>
    <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Your user name</label><input type="text" name="Username" value=<?php echo $_SESSION['fillname'];
    $_SESSION['fillname']=""; ?>><br/>
    <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Your password</label><input type="password" name="Password"><br/>
    <label>Confirmed password</label><input type="password" name="ConfirmedPassword"><br/>
    <p>Note: the Password should contain:<br>
    1.At least one capital letter(ABC..) <br>
    2.At least one small letter(abc..)<br>
    3.At least one special character (!"$..)<br>
    4.At least one number (123..)<br>
    5.Digits number of password: at least 6 digits</p>
  </div>
<button class="buttonRegister" style="vertical-align:middle" type="submit"><span>Create account </span></button>
</form>
<br>
<form action="index.php">
<button class="button button5" type="submit">Back</button>
</form>

</body>
</html>
