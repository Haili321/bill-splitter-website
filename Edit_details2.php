<?php
session_start();
error_reporting(E_ALL);
ini_set(“display_errors”, 1);
require "database.php";
$index = new Database();
$db = new Database();

$stmt = $db->prepare("DELETE FROM Bill_detail WHERE Bill_ID=:Bill_ID AND Person_ID=:Person_ID;");
$stmt->bindValue(':Bill_ID', $_SESSION['Bill_ID'],SQLITE3_INTEGER);
$stmt->bindValue(':Person_ID', $_SESSION['Person_ID'],SQLITE3_INTEGER);
$results = $stmt->execute();

#$sql="DELETE FROM Bill_detail WHERE Bill_ID={$_SESSION["Bill_ID"]} AND Person_ID={$_SESSION["Person_ID"]};";
#$result = $index->exec($sql);

$_SESSION["Edditperson"]=true;
header('Location:Bill_detail.php');
?>
