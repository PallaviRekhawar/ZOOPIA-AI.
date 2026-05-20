<?php
$conn = mysqli_connect("localhost", "root", "", "zoo_planet");
$sql = "SELECT * FROM inquiries ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Inquiries</title>
    <style>
        body { font-family: Arial; background: #f2f7f2; margin: 0; padding: 20px; }
        .container { max-width: 900px; margin: 20px auto; background: white; padding: 25px; border-radius: 12px; }
        h2 { color: #2e7d32; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #2e7d32; color: white; padding: 12px; }
        td { padding: 10px; border-bottom: 1px solid #ddd; text-align: center; }
        .back { display: block; text-align: center; margin-top: 20px; color: #2e7d32; text-decoration: none; }
    </style>
</head>
<body>
<div class="container">
    <h2>📧 All Inquiries</h2>
    <table>
        <tr><th>ID</th><th>Name</th><th>Email</th><th>Subject</th><th>Message</th><th>Date</th></tr>
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['subject']}</td>
                    <td>{$row['message']}</td>
                    <td>{$row['created_at']}</td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No inquiries yet.</td></tr>";
        }
        ?>
    </table>
    <a href="dashboard.php" class="back">← Back to Dashboard</a>
</div>
</body>
</html>