<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>Sign Up</title>
  <style>
    body { font-family: Arial; background:#f0f0f0; margin:0; }
    .box { width:350px; margin:80px auto; background:white; padding:25px; box-shadow:0 0 8px rgba(0,0,0,0.3); border-radius:6px; }
    input, select { width:100%; padding:10px; margin:10px 0; border:1px solid #ccc; border-radius:4px; }
    .btn { width:100%; padding:10px; background:#00a868; color:white; border:none; cursor:pointer; border-radius:4px; }
  </style>
  <script>
    function redirect(page){ window.location.href = page; }
  </script>
</head>
<body>
<div class="box">
  <h2>Create Account</h2>
  <?php
    if(isset($_POST['signup'])){
      $name = $_POST['name'];
      $email = $_POST['email'];
      $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
      $role = $_POST['role'];

      $stmt = $conn->prepare("INSERT INTO users (name,email,password,role) VALUES (?,?,?,?)");
      $stmt->bind_param("ssss", $name, $email, $pass, $role);
      if($stmt->execute()){
        echo "<script>alert('Signup successful!'); redirect('login.php');</script>";
      } else {
        echo "<p style='color:red;'>Error: ".$conn->error."</p>";
      }
    }
  ?>
  <form method="post">
    <input type="text" name="name" placeholder="Full Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <select name="role">
      <option value="buyer">Buyer</option>
      <option value="seller">Seller</option>
    </select>
    <button class="btn" name="signup">Sign Up</button>
    <p style="text-align:center;margin-top:15px;">
      Already have an account? <a href="login.php">Login</a>
    </p>
  </form>
</div>
</body>
</html>
