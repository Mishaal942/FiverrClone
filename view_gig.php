<?php
include 'db.php';
session_start();
$id = $_GET['id'];
$gig = $conn->query("SELECT g.*, u.name FROM gigs g JOIN users u ON g.user_id=u.id WHERE g.id='$id'")->fetch_assoc();
if(!$gig){ echo "Gig not found"; exit; }
?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $gig['title']; ?></title>
<style>
  body { font-family: Arial; background:#f5f5f5; margin:0; }
  .box { width:80%; margin:30px auto; background:white; padding:20px; box-shadow:0 0 10px rgba(0,0,0,0.2); border-radius:6px; }
  img { width:100%; max-height:350px; object-fit:cover; border-radius:6px; }
  .btn { padding:10px 20px; background:#00a868; color:white; border:none; cursor:pointer; border-radius:4px; margin-top:10px; }
</style>
<script>
function redirect(page){ window.location.href = page; }
</script>
</head>
<body>
<div class="box">
  <h2><?php echo $gig['title']; ?></h2>
  <img src="<?php echo $gig['image']; ?>" alt="gig">
  <p><strong>Seller:</strong> <?php echo $gig['name']; ?></p>
  <p><strong>Category:</strong> <?php echo $gig['category']; ?></p>
  <p><strong>Price:</strong> PKR <?php echo $gig['price']; ?></p>
  <p><?php echo nl2br($gig['description']); ?></p>
  <button class="btn" onclick="redirect('place_order.php?gig_id=<?php echo $gig['id']; ?>')">Order Now</button>
</div>
</body>
</html>
