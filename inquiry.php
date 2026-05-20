<?php
$conn = mysqli_connect("localhost", "root", "", "zoo_planet");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'] ?? '';
    
    $sql = "INSERT INTO inquiries (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Inquiry submitted successfully!'); window.location='inquiry.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>New Inquiry</title>
    <style>
        body { font-family: Arial; background: #f2f7f2; margin: 0; padding: 20px; }
        .container { max-width: 500px; margin: 30px auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        h2 { color: #2e7d32; text-align: center; }
        label { font-weight: bold; display: block; margin-top: 12px; }
        input, textarea { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; box-sizing: border-box; }
        textarea { height: 100px; resize: vertical; }
        button { width: 100%; padding: 12px; background: #2e7d32; color: white; border: none; border-radius: 6px; font-size: 16px; cursor: pointer; margin-top: 20px; }
        button:hover { background: #1b5e20; }
        .back { display: block; text-align: center; margin-top: 15px; color: #2e7d32; text-decoration: none; }
    </style>
</head>
<body>
<div class="container">
    <h2>📧 New Inquiry</h2>
    <form method="POST">
        <label>Your Name:</label>
        <input type="text" name="name" required>
        
        <label>Your Email:</label>
        <input type="email" name="email" required>
        
        <label>Subject:</label>
        <input type="text" name="subject">
        
        <label>Message:</label>
        <textarea name="message" required></textarea>
        
        <button type="submit">Submit Inquiry</button>
    </form>
    <a href="dashboard.php" class="back">← Back to Dashboard</a>
</div>
</body>
</html>