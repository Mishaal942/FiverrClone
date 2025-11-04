<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href = 'login.php';</script>";
    exit();
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $user_id = $_SESSION['user_id'];

    // Image upload
    $image_name = "";
    if (isset($_FILES['gig_image']) && $_FILES['gig_image']['error'] == 0) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $image_name = time() . "_" . basename($_FILES['gig_image']['name']);
        $targetFilePath = $targetDir . $image_name;

        if (!move_uploaded_file($_FILES['gig_image']['tmp_name'], $targetFilePath)) {
            $message = "Image upload failed!";
        }
    }

    $query = "INSERT INTO gigs (user_id, title, description, price, category, image) 
              VALUES ('$user_id', '$title', '$description', '$price', '$category', '$image_name')";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>window.location.href = 'my_gigs.php';</script>";
        exit();
    } else {
        $message = "Database Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Gig</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .gig-box {
            background: white;
            padding: 25px;
            width: 450px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0,0,0,0.2);
        }
        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background: #28a745;
            border: none;
            padding: 10px;
            width: 100%;
            color: white;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover { background: #218838; }
        .msg { color: red; text-align: center; }
    </style>
</head>
<body>

<div class="gig-box">
    <h2>Create New Gig</h2>
    <?php if ($message) echo "<p class='msg'>$message</p>"; ?>

    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Gig Title" required>
        
        <textarea name="description" placeholder="Describe your service" rows="4" required></textarea>
        
        <input type="number" name="price" placeholder="Price (Rs)" required>
        
        <select name="category" required>
            <option value="" disabled selected>Select Category</option>
            <option value="Graphic Design">Graphic Design</option>
            <option value="Writing & Translation">Writing & Translation</option>
            <option value="Video Editing">Video Editing</option>
            <option value="SEO">SEO</option>
            <option value="Programming & Tech">Programming & Tech</option>
        </select>

        <input type="file" name="gig_image" accept="image/*" required>

        <button type="submit">Create Gig</button>
    </form>
</div>

</body>
</html>
