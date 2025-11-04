<?php
include 'db.php';
session_start();
if(!isset($_SESSION['user_id'])){
  echo "<script>window.location.href='login.php';</script>"; exit;
}
$uid = $_SESSION['user_id'];
$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html>
<head>
<title>Your Orders</title>
<style>
  body { font-family: Arial; background:#f5f5f5; margin:0; }
  .header { background:#00a868; padding:15px; color:white; text-align:center; }
  table { width:90%; margin:20px auto; background:white; border-collapse:collapse; }
  th, td { border:1px solid #ccc; padding:10px; }
  .btn { padding:6px 15px; background:#007b57; color:white; border:none; cursor:pointer; border-radius:4px; }
</style>
<script>
function redirect(p){ window.location.href = p; }
</script>
</head>
<body>
<div class="header">
  <h2>Orders</h2>
  <button class="btn" onclick="redirect('dashboard.php')">Dashboard</button>
</div>
<table>
  <tr>
    <th>Gig</th><th>Seller</th><th>Buyer</th><th>Status</th><th>Action</th>
  </tr>
  <?php
    $orders = $role == 'seller'
      ? $conn->query("SELECT o.*, g.title, u.name as buyerName FROM orders o JOIN gigs g ON o.gig_id=g.id JOIN users u ON o.buyer_id=u.id WHERE seller_id='$uid'")
      : $conn->query("SELECT o.*, g.title, u.name as sellerName FROM orders o JOIN gigs g ON o.gig_id=g.id JOIN users u ON o.seller_id=u.id WHERE buyer_id='$uid'");

    while($o = $orders->fetch_assoc()){
      echo "<tr>
        <td>{$o['title']}</td>
        <td>".($role=='buyer'?$o['sellerName']:"You")."</td>
        <td>".($role=='seller'?$o['buyerName']:"You")."</td>
        <td>{$o['status']}</td>
        <td>
          <button class='btn' onclick=\"redirect('messages.php?order_id={$o['id']}')\">Message</button>
        </td>
      </tr>";
    }
  ?>
</table>
</body>
</html>
