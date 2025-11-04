<?php
include 'db.php';
session_start();
if(!isset($_SESSION['user_id'])){
  echo "<script>window.location.href='login.php';</script>";
  exit;
}

$id = $_GET['id'];
$gig = $conn->query("SELECT * FROM gigs WHERE id='$id' AND user_id='".$_SESSION['user_id']."'")->fetch_assoc();
if(!$gig){
  echo "<script>alert('Gig not found or not yours'); window.location.href='dashboard.php';</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Edit Gig</title>
<style>
  body { font-family: Arial; background:#f5f5f5; margin:0; }
  .box { width:450px; margin:50px auto; padding:25px; background:white; box-shadow:0 0 8px rgba(0,0,0,0.2); border-radius:6px; }
  input, textarea { width:100%; padding:10px; margin:10px 0; border:1px solid #ccc; border-radius:4px; }
  .btn { background:#007b57; color:white; padding:10px; border:none; cursor:pointer; border-radius:4px; width:100%; }
</style>
<script>
function redirect(page){ window.location.href = page; }
</script>
</head>
<body>
<div class="box">
  <h2>Edit Gig</h2>
  <?php
  if(isset($_POST['update'])){
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $image = $_POST['image'];

    $stmt = $conn->prepare("UPDATE gigs SET title=?, description=?, price=?, category=?, image=? WHERE id=? AND user_id=?");
    $stmt->bind_param("ssdssii", $title, $desc, $price, $category, $image, $id, $_SESSION['user_id']);
    if($stmt->execute()){
      echo "<script>alert('Gig Updated!'); redirect('dashboard.php');</script>";
    } else {
      echo "<p style='color:red;'>Error: ".$conn->error."</p>";
    }
  }
  ?>
  <form method="post">
    <input type="text" name="title" value="<?php echo $gig['title']; ?>" required>
    <textarea name="description" required><?php echo $gig['description']; ?></textarea>
    <input type="number" step="0.01" name="price" value="<?php echo $gig['price']; ?>" required>
    <input type="text" name="category" value="<?php echo $gig['category']; ?>" required>
    <input type="text" name="image" value="<?php echo $gig['image']; ?>">
    <button class="btn" name="update">Update Gig</button>
  </form>
</div>
</body>
</html>
