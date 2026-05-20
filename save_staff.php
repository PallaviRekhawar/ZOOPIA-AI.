<?php
// Force error display off
error_reporting(0);
ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');

$conn = mysqli_connect("localhost", "root", "", "zoo_planet");
$msg = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Use error suppression and fallback to empty string
    $name    = @$_POST['name']    ? trim($_POST['name'])    : '';
    $role    = @$_POST['role']    ? trim($_POST['role'])    : '';
    $contact = @$_POST['contact'] ? trim($_POST['contact']) : '';
    $email   = @$_POST['email']   ? trim($_POST['email'])   : '';
    $date    = @$_POST['join_date'] ? $_POST['join_date']   : date('Y-m-d');

    if ($name !== '' && $role !== '' && $contact !== '') {
        $sql = "INSERT INTO staff (name, role, contact, email, join_date)
                VALUES ('$name', '$role', '$contact', '$email', '$date')";
        if (mysqli_query($conn, $sql)) {
            $msg = "<div style='color:green; font-weight:bold; margin-bottom:15px;'>✔ Staff saved successfully!</div>";
        } else {
            $msg = "<div style='color:red; margin-bottom:15px;'>DB Error: " . mysqli_error($conn) . "</div>";
        }
    } else {
        $msg = "<div style='color:red; margin-bottom:15px;'>Please fill all required fields (Name, Role, Contact).</div>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Staff</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #2e7d32, #66bb6a);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
            width: 420px;
        }
        h2 { color: #2e7d32; text-align: center; }
        label { font-weight: bold; display: block; margin-top: 12px; }
        input[type="text"], input[type="email"], input[type="date"] {
            width: 100%; padding: 10px; margin-top: 5px;
            border: 1px solid #ccc; border-radius: 6px; font-size: 14px;
            box-sizing: border-box;
        }
        button {
            width: 100%; padding: 12px; margin-top: 20px;
            background: #2e7d32; color: white; border: none;
            border-radius: 6px; font-size: 16px; font-weight: bold; cursor: pointer;
        }
        button:hover { background: #1b5e20; }
        .dashboard-link {
            display: block; text-align: center; margin-top: 15px;
            color: #2e7d32; text-decoration: none; font-weight: bold;
        }
    </style>
</head>
<body>
<div class="card">
    <h2>👷 Add New Staff</h2>
    <?php echo $msg; ?>
    <form method="POST">
        <label>Staff Name *</label>
        <input type="text" name="name" required>

        <label>Role *</label>
        <input type="text" name="role" required>

        <label>Contact *</label>
        <input type="text" name="contact" required>

        <label>Email (optional)</label>
        <input type="email" name="email">

        <label>Join Date</label>
        <input type="date" name="join_date" value="<?php echo date('Y-m-d'); ?>">

        <button type="submit">Save Staff</button>
    </form>
    <a href="dashboard.php" class="dashboard-link">🏠 Go to Dashboard</a>
</div>
</body>
</html>