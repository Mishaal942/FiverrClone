<?php
include 'db.php';
session_start();
if(!isset($_SESSION['user_id'])){
  echo "<script>window.location.href='login.php';</script>"; exit;
}
$order_id = $_POST['order_id'];
$msg = $_POST['message'];
$uid = $_SESSION['user_id'];

$conn->query("INSERT INTO messages (order_id, sender_id, message) VALUES ('$order_id', '$uid', '$msg')");
echo "<script>window.location.href='messages.php?order_id=$order_id';</script>";
?>
