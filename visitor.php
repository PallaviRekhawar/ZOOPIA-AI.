<?php
$conn = mysqli_connect("localhost", "root", "", "zoo_planet");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $visit_date = $_POST['visit_date'] ?? date('Y-m-d');
    
    $sql = "INSERT INTO visitors (name, email, phone, visit_date) VALUES ('$name', '$email', '$phone', '$visit_date')";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Visitor added successfully!'); window.location='visitor.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Visitor</title>
    <style>
        body { font-family: Arial; background: #f2f7f2; margin: 0; padding: 20px; }
        .container { max-width: 500px; margin: 30px auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        h2 { color: #2e7d32; text-align: center; }
        label { font-weight: bold; display: block; margin-top: 12px; }
        input { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background: #2e7d32; color: white; border: none; border-radius: 6px; font-size: 16px; cursor: pointer; margin-top: 20px; }
        button:hover { background: #1b5e20; }
        .back { display: block; text-align: center; margin-top: 15px; color: #2e7d32; text-decoration: none; }
    </style>
</head>
<body>
<div class="container">
    <h2>👤 Add Visitor</h2>
    <form method="POST">
        <label>Visitor Name:</label>
        <input type="text" name="name" required>
        
        <label>Email:</label>
        <input type="email" name="email" required>
        
        <label>Phone:</label>
        <input type="text" name="phone" required>
        
        <label>Visit Date:</label>
        <input type="date" name="visit_date" required>
        
        <button type="submit">Save Visitor</button>
    </form>
    <a href="dashboard.php" class="back">← Back to Dashboard</a>
</div>
</body>
</html>