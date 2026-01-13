<?php
// Connect to DB
$con = mysqli_connect("sql213.byethost22.com", "b22_39801860", "Salman@56", "b22_39801860_main");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Collect other product form data
$name = $_POST["name"];
$price = $_POST["price"];
$cat = $_POST["category"];
$dis = $_POST["discount"];
$desc = $_POST["description"];
$s = $_POST["stock"];

// Handle image upload
$image = $_FILES['image']; // 'image' should match the input name in your HTML form
$uploadDir = __DIR__ . '/../home/product/';

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

if (!in_array($image['type'], $allowedTypes)) {
    echo "Only JPG, PNG, and GIF images are allowed.";
    exit;
} elseif ($image['error'] !== UPLOAD_ERR_OK) {
    echo "Error uploading image.";
    exit;
} elseif ($image['size'] > 5 * 1024 * 1024) {
    echo "Image size must not exceed 5MB.";
    exit;
} else {
    $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
$filename = 'product_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
    $destination = $uploadDir . $filename;
    $imagePath = 'product/' . $filename; // Save relative path in DB

    if (!move_uploaded_file($image['tmp_name'], $destination)) {
        echo "Failed to move uploaded file.";
        exit;
    }

    // All good, insert into DB
    $query = "INSERT INTO Product 
        (product_name, product_price, category, product_image, product_discount, product_description,stock) 
        VALUES 
        ('$name', '$price', '$cat', '$imagePath', '$dis', '$desc','$s')";

    try {
        if (!mysqli_query($con, $query)) {
            throw new Exception(mysqli_error($con), mysqli_errno($con));
        }
        header("refresh:2;url=addproduct.html");
        echo "✅ Product Added Successfully!";
    } catch (Exception $e) {
        if ($e->getCode() == 1062) {
            echo "⚠️ Product with this name already exists!";
        } else {
            echo "❌ Error adding product: " . $e->getMessage();
        }
        header("refresh:3;url=addproduct.html");
    }
}
?>
