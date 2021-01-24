<?php
session_start();
error_reporting(E_ALL);
ini_set(“display_errors”, 1);
require "database.php";
$index = new Database();
$db = new Database();
echo $_SESSION["Bill_ID"];

$stmt = $db->prepare("DELETE FROM Bill_list WHERE Bill_ID=:Bill_ID;");
$stmt->bindValue(':Bill_ID', $_SESSION['Bill_ID'],SQLITE3_INTEGER);
$results = $stmt->execute();

$stmt = $db->prepare("DELETE FROM Bill_detail WHERE Bill_ID=:Bill_ID;");
$stmt->bindValue(':Bill_ID', $_SESSION['Bill_ID'],SQLITE3_INTEGER);
$results = $stmt->execute();

header('Location:bill_list.php');
 ?>
