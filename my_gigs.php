<?php
session_start();
include 'db.php';

// ✅ User Login Check
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login first!'); window.location.href='login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM gigs WHERE user_id = '$user_id' ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Gigs</title>
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
            height: 250px;
            object-fit: cover;
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
        .manage-btn {
            display: inline-block;
            background: #007bff;
            color: white;
            padding: 8px 10px;
            margin-top: 10px;
            text-decoration: none;
            border-radius: 5px;
        }
        .delete-btn {
            background: red;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>My Gigs</h1>
    <a href="create_gig.php" class="manage-btn">+ Create New Gig</a>
</div>

<div class="gig-container">
<?php
if ($result && mysqli_num_rows($result) > 0) {
    while ($gig = mysqli_fetch_assoc($result)) {
        $img = !empty($gig['image']) ? $gig['image'] : 'default.jpg';
        echo "
        <div class='gig-card'>
            <div class='gig-image'>
                <img src='uploads/{$gig['image']}' alt='Gig Image'>
            </div>
            <div class='gig-info'>
                <h3>{$gig['title']}</h3>
                <p>{$gig['category']}</p>
                <p class='price'>Rs {$gig['price']}</p>
                <a href='edit_gig.php?id={$gig['id']}' class='manage-btn'>Edit</a>
                <a href='delete_gig.php?id={$gig['id']}' class='manage-btn delete-btn' onclick='return confirm(\"Are you sure?\")'>Delete</a>
            </div>
        </div>";
    }
} else {
    echo "<h3 style='text-align:center;'>You haven't created any gigs yet.</h3>";
}
?>
</div>

</body>
</html>
