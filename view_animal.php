<?php
$conn = mysqli_connect("localhost", "root", "", "zoo_planet");
$sql = "SELECT * FROM animals ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Animals</title>
    <style>
        body { font-family: Arial; background: #f2f7f2; margin: 0; padding: 20px; }
        .container { max-width: 900px; margin: 20px auto; background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        h2 { color: #2e7d32; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #2e7d32; color: white; padding: 12px; }
        td { padding: 10px; border-bottom: 1px solid #ddd; text-align: center; }
        img { width: 80px; height: 60px; object-fit: cover; border-radius: 5px; }
        tr:hover { background: #f5f5f5; }
        .no-data { text-align: center; color: #888; padding: 40px; }
        .back { display: block; text-align: center; margin-top: 20px; color: #2e7d32; text-decoration: none; font-size: 16px; }
    </style>
</head>
<body>
<div class="container">
    <h2>📋 All Animals</h2>
    
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Species</th>
            <th>Category</th>
            <th>Habitat</th>
            <th>Photo</th>
        </tr>
        
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['species'] . "</td>";
                echo "<td>" . $row['category'] . "</td>";
                echo "<td>" . $row['habitat'] . "</td>";
                echo "<td>";
                if (!empty($row['image_path'])) {
                    echo "<img src='" . $row['image_path'] . "' alt='animal photo'>";
                } else {
                    echo "No photo";
                }
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6' class='no-data'>No animals found. <a href='save_animal.php'>Add one now!</a></td></tr>";
        }
        ?>
    </table>
    
    <a href="dashboard.php" class="back">← Back to Dashboard</a>
</div>
</body>
</html>