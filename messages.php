<?php
include 'db.php';
session_start();
if(!isset($_SESSION['user_id'])){
  echo "<script>window.location.href='login.php';</script>"; exit;
}
$order_id = $_GET['order_id'];
$uid = $_SESSION['user_id'];

$msgs = $conn->query("SELECT m.*, u.name FROM messages m JOIN users u ON m.sender_id=u.id WHERE m.order_id='$order_id'");
?>
<!DOCTYPE html>
<html>
<head>
<title>Messages</title>
<style>
  body { font-family: Arial; background:#f0f0f0; margin:0; }
  .box { width:70%; margin:20px auto; background:white; padding:20px; box-shadow:0 0 10px rgba(0,0,0,0.2); border-radius:6px; }
  .msg { padding:10px; margin:8px 0; border-bottom:1px solid #ddd; }
  input { width:80%; padding:10px; margin-top:15px; }
  .btn { padding:10px; background:#007b57; color:white; border:none; border-radius:4px; cursor:pointer; }
</style>
<script>
function redirect(p){ window.location.href = p; }
</script>
</head>
<body>
<div class="box">
  <h2>Chat</h2>
  <?php
  while($m = $msgs->fetch_assoc()){
    echo "<div class='msg'><b>{$m['name']}:</b> {$m['message']}</div>";
  }
  ?>
  <form method="post" action="send_message.php">
    <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
    <input type="text" name="message" placeholder="Type message..." required>
    <button class="btn" type="submit">Send</button>
  </form>
</div>
</body>
</html>
