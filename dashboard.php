<?php
session_start();
include 'db.php';

// ✅ User Login Check
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login first!'); window.location.href='login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];

// ✅ Fetch Gigs
$query = "SELECT * FROM gigs WHERE user_id = '$user_id' ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
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
            right: 140px;
            top: 20px;
        }
        .logout-btn {
            background: #ff3b30;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            position: absolute;
            right: 20px;
            top: 20px;
        }
        table {
            width: 90%;
            margin: 30px auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0px 2px 8px rgba(0,0,0,0.2);
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background: #1dbf73;
            color: white;
        }
        .action-btn {
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }
        .edit-btn {
            background: #007bff;
            color: white;
        }
        .delete-btn {
            background: red;
            color: white;
        }
        .no-data {
            text-align: center;
            font-size: 18px;
            margin-top: 40px;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Dashboard</h1>
    <a href="create_gig.php" class="create-btn">+ Create Gig</a>
    <a href="logout.php" class="logout-btn">Logout</a>
</div>

<?php if ($result && mysqli_num_rows($result) > 0): ?>
<table>
    <tr>
        <th>Title</th>
        <th>Category</th>
        <th>Price</th>
        <th>Actions</th>
    </tr>

    <?php while ($gig = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?php echo $gig['title']; ?></td>
        <td><?php echo $gig['category']; ?></td>
        <td>Rs <?php echo $gig['price']; ?></td>
        <td>
            <a href="edit_gig.php?id=<?php echo $gig['id']; ?>" class="action-btn edit-btn">Edit</a>
            <a href="delete_gig.php?id=<?php echo $gig['id']; ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
    </tr>
    <?php } ?>

</table>

<?php else: ?>
    <h3 class="no-data">You haven't created any gigs yet.</h3>
<?php endif; ?>

</body>
</html>
