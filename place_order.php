<?php
include 'db.php';
session_start();
if(!isset($_SESSION['user_id'])){
  echo "<script>window.location.href='login.php';</script>"; exit;
}
$gig_id = $_GET['gig_id'];
$user_id = $_SESSION['user_id'];

$gig = $conn->query("SELECT * FROM gigs WHERE id='$gig_id'")->fetch_assoc();
if(!$gig){ echo "Invalid Gig"; exit; }

$seller_id = $gig['user_id'];

$conn->query("INSERT INTO orders (buyer_id, seller_id, gig_id, status) VALUES ('$user_id','$seller_id','$gig_id','pending')");
echo "<script>alert('Order Placed!'); window.location.href='orders.php';</script>";
?>
