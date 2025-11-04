<?php
// ✅ Show PHP Errors (Fix HTTP ERROR 500 silently crashing issue)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'db.php';

// ✅ Fetch gigs
$query = "SELECT * FROM gigs ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fiverr Clone - Home</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .header {
            background: #1dbf73;
            color: white;
            padding: 15px;
            text-align: center;
            position: relative;
        }
        .create-btn {
            background: #007bff;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            position: absolute;
            right: 20px;
            top: 20px;
        }
        .gig-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 30px;
        }
        .gig-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            overflow: hidden;
            transition: 0.3s;
        }
        .gig-card:hover { transform: scale(1.03); }

        .gig-image img {
            width: 100%;
            height: 250px; /* ✅ Full image height */
            object-fit: cover; /* ✅ No crop issues */
            display: block;
        }
        .gig-info {
            padding: 15px;
        }
        .gig-info h3 {
            margin: 0 0 10px;
            font-size: 18px;
        }
        .gig-info p {
            font-size: 14px;
            margin: 5px 0;
        }
        .price {
            font-weight: bold;
            color: #1dbf73;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Fiverr Clone</h1>
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="create_gig.php" class="create-btn">+ Create Gig</a>
    <?php else: ?>
        <a href="login.php" class="create-btn">Login</a>
    <?php endif; ?>
</div>

<div class="gig-container">
<?php
if ($result && mysqli_num_rows($result) > 0) {
    while ($gig = mysqli_fetch_assoc($result)) {
        $img = !empty($gig['image']) ? $gig['image'] : 'default.jpg';
        echo "
        <div class='gig-card'>
            <div class='gig-image'>
                <img src='uploads/$img' alt='Gig Image'>
            </div>
            <div class='gig-info'>
                <h3>{$gig['title']}</h3>
                <p>{$gig['category']}</p>
                <p class='price'>Rs {$gig['price']}</p>
            </div>
        </div>";
    }
} else {
    echo "<h3 style='text-align:center;'>No gigs available yet.</h3>";
}
?>
</div>

</body>
</html>
