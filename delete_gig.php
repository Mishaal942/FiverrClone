<?php
include 'db.php';
session_start();
if(!isset($_SESSION['user_id'])){
  echo "<script>window.location.href='login.php';</script>";
  exit;
}

$id = $_GET['id'];
$conn->query("DELETE FROM gigs WHERE id='$id' AND user_id='".$_SESSION['user_id']."'");
echo "<script>alert('Gig Deleted!'); window.location.href='dashboard.php';</script>";
?>
