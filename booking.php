<?php
$conn = mysqli_connect("localhost", "root", "", "zoo_planet");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $visitor_name = $_POST['visitor_name'] ?? '';
    $visitor_email = $_POST['visitor_email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $adult_count = intval($_POST['adult_count'] ?? 0);
    $child_count = intval($_POST['child_count'] ?? 0);
    
    $adult_price = $adult_count * 154.50;
    $child_price = $child_count * 103.00;
    $total = $adult_price + $child_price;
    $token = rand(1000, 9999);
    $visit_date = $_POST['visit_date'] ?? date('Y-m-d');
    
    $sql = "INSERT INTO tickets (visitor_name, visitor_email, adult_count, child_count, adult_price, child_price, total, token, booked_date) 
            VALUES ('$visitor_name', '$visitor_email', $adult_count, $child_count, $adult_price, $child_price, $total, '$token', '$visit_date')";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Ticket Booked! Token: $token\\nTotal: ₹$total'); window.location='booking.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Ticket</title>
    <style>
        body { font-family: Arial; background: #f2f7f2; margin: 0; padding: 20px; }
        .container { max-width: 500px; margin: 30px auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        h2 { color: #2e7d32; text-align: center; }
        label { font-weight: bold; display: block; margin-top: 12px; }
        input, select { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background: #2e7d32; color: white; border: none; border-radius: 6px; font-size: 16px; cursor: pointer; margin-top: 20px; }
        button:hover { background: #1b5e20; }
        .price-info { background: #e8f5e9; padding: 15px; border-radius: 8px; margin-top: 15px; }
        .back { display: block; text-align: center; margin-top: 15px; color: #2e7d32; text-decoration: none; }
    </style>
</head>
<body>
<div class="container">
    <h2>🎫 Online Ticket Booking</h2>
    <form method="POST">
        <label>Visitor Name:</label>
        <input type="text" name="visitor_name" required>
        
        <label>Email:</label>
        <input type="email" name="visitor_email" required>
        
        <label>Phone:</label>
        <input type="text" name="phone" required>
        
        <label>Visit Date:</label>
        <input type="date" name="visit_date" required>
        
        <label>Number of Adults (₹154.50 each with GST):</label>
        <input type="number" name="adult_count" value="0" min="0">
        
        <label>Number of Children (₹103.00 each with GST):</label>
        <input type="number" name="child_count" value="0" min="0">
        
        <div class="price-info">
            <strong>Pricing:</strong><br>
            Adult: ₹150 + 3% GST = ₹154.50<br>
            Child: ₹100 + 3% GST = ₹103.00
        </div>
        
        <button type="submit">Book Ticket</button>
    </form>
    <a href="dashboard.php" class="back">← Back to Dashboard</a>
</div>
</body>
</html>