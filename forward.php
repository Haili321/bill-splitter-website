<?php
session_start();
if ($_SESSION['login']){
  header('Location:bill_list.php');
}
 ?>
