<?php include 'db.php'; session_start(); ?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <style>
    body { font-family: Arial; background:#f0f0f0; margin:0; }
    .box { width:350px; margin:80px auto; background:white; padding:25px; box-shadow:0 0 8px rgba(0,0,0,0.3); border-radius:6px; }
    input { width:100%; padding:10px; margin:10px 0; border:1px solid #ccc; border-radius:4px; }
    .btn { width:100%; padding:10px; background:#00a868; color:white; border:none; cursor:pointer; border-radius:4px; }
  </style>
  <script>
    function redirect(page){ window.location.href = page; }
  </script>
</head>
<body>
<div class="box">
  <h2>Login</h2>
  <?php
    if(isset($_POST['login'])){
      $email = $_POST['email'];
      $pass = $_POST['password'];

      $result = $conn->query("SELECT * FROM users WHERE email='$email' LIMIT 1");
      if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        if(password_verify($pass, $row['password'])){
          $_SESSION['user_id'] = $row['id'];
          $_SESSION['role'] = $row['role'];
          echo "<script>alert('Login Successful!'); redirect('dashboard.php');</script>";
        } else {
          echo "<p style='color:red;'>Incorrect password.</p>";
        }
      } else {
        echo "<p style='color:red;'>Email not found.</p>";
      }
    }
  ?>
  <form method="post">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button class="btn" name="login">Login</button>
    <p style="text-align:center;margin-top:15px;">
      Don't have an account? <a href="signup.php">Sign Up</a>
    </p>
  </form>
</div>
</body>
</html>
