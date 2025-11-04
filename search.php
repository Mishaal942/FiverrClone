<?php
include 'db.php';
session_start();
$q = $_GET['q'] ?? '';
$gigs = $conn->query("SELECT * FROM gigs WHERE title LIKE '%$q%' OR category LIKE '%$q%'");
?>
<!DOCTYPE html>
<html>
<head>
<title>Search</title>
<style>
  body { font-family: Arial; background:#f5f5f5; margin:0; }
  .container { width:80%; margin:30px auto; }
  .gig { background:white; padding:15px; margin:15px 0; box-shadow:0 0 6px rgba(0,0,0,0.2); border-radius:6px; }
  .btn { padding:8px 15px; background:#00a868; color:white; border:none; cursor:pointer; border-radius:4px; }
  input { padding:10px; width:70%; border:1px solid #ccc; border-radius:4px; }
</style>
<script>
function redirect(p){ window.location.href = p; }
</script>
</head>
<body>
<div class="container">
  <form>
    <input type="text" name="q" value="<?php echo $q; ?>" placeholder="Search gigs...">
    <button class="btn">Search</button>
  </form>
  <?php
  while($g = $gigs->fetch_assoc()){
    echo "<div class='gig'>
      <h3>{$g['title']}</h3>
      <p>{$g['description']}</p>
      <button class='btn' onclick=\"redirect('view_gig.php?id={$g['id']}')\">View</button>
    </div>";
  }
  ?>
</div>
</body>
</html>
