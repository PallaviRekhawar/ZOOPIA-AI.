<?php
$conn = mysqli_connect("localhost", "root", "", "zoo_planet");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? '';
    $species = $_POST['species'] ?? '';
    $cage = $_POST['cage'] ?? '';
    $category = $_POST['category'] ?? 'Mammal';
    $habitat = $_POST['habitat'] ?? 'Zoo';
    
    // Handle photo upload
    $photo = '';
    if (isset($_FILES['photo']) && $_FILES['photo']['name'] != '') {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $photo = $target_dir . basename($_FILES['photo']['name']);
        move_uploaded_file($_FILES['photo']['tmp_name'], $photo);
    }
    
    // Insert into animals table (changed from animal to animals)
    $sql = "INSERT INTO animals (name, species, category, habitat, image_path, added_date) 
            VALUES ('$name', '$species', '$category', '$habitat', '$photo', CURDATE())";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Animal added successfully!'); window.location='dashboard.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Animal</title>
    <style>
        body { font-family: Arial; background: #f2f7f2; margin: 0; padding: 20px; }
        .container { max-width: 500px; margin: 30px auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        h2 { color: #2e7d32; text-align: center; }
        label { font-weight: bold; display: block; margin-top: 12px; color: #333; }
        input, select { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background: #2e7d32; color: white; border: none; border-radius: 6px; font-size: 16px; cursor: pointer; margin-top: 20px; }
        button:hover { background: #1b5e20; }
        .back { display: block; text-align: center; margin-top: 15px; color: #2e7d32; text-decoration: none; }
    </style>
</head>
<body>
<div class="container">
    <h2>🦁 Add New Animal</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Animal Name:</label>
        <input type="text" name="name" required>
        
        <label>Species:</label>
        <input type="text" name="species" required>
        
        <label>Cage Number:</label>
        <input type="text" name="cage">
        
        <label>Category:</label>
        <select name="category">
            <option>Mammal</option>
            <option>Bird</option>
            <option>Reptile</option>
            <option>Amphibian</option>
            <option>Fish</option>
        </select>
        
        <label>Habitat:</label>
        <input type="text" name="habitat" value="Zoo">
        
        <label>Photo:</label>
        <input type="file" name="photo" accept="image/*">
        
        <button type="submit">Save Animal</button>
    </form>
    <a href="dashboard.php" class="back">← Back to Dashboard</a>
</div>
</body>
</html>