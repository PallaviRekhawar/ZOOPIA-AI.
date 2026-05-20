<?php
$conn = mysqli_connect("localhost","root","","zoo_planet");
?>

<!DOCTYPE html>
<html>
<head>
<title>View Staff</title>

<style>

body{
font-family:Arial;
background:#f2f7f2;
margin:0;
}

/* Header */
.header{
background:#2e7d32;
color:white;
padding:20px;
text-align:center;
}

/* Table */
table{
width:80%;
margin:40px auto;
border-collapse:collapse;
background:white;
box-shadow:0px 0px 10px gray;
}

th, td{
padding:12px;
border:1px solid #ccc;
text-align:center;
}

th{
background:#2e7d32;
color:white;
}

/* Button */
.back-btn{
display:block;
width:220px;
margin:20px auto;
text-align:center;
padding:10px;
background:#2e7d32;
color:white;
text-decoration:none;
border-radius:6px;
font-weight:bold;
}

.back-btn:hover{
background:#1b5e20;
}

</style>

</head>

<body>

<div class="header">
<h1>Staff Details</h1>
</div>

<table>

<tr>
<th>ID</th>
<th>Name</th>
<th>Role</th>
<th>Contact</th>
</tr>

<?php

$sql = "SELECT * FROM staff";
$result = mysqli_query($conn,$sql);

while($row = mysqli_fetch_assoc($result)){
echo "<tr>
<td>".$row['id']."</td>
<td>".$row['name']."</td>
<td>".$row['role']."</td>
<td>".$row['contact']."</td>
</tr>";
}

?>

</table>

<!-- 🔥 BACK BUTTON -->
<a href="dashboard.php" class="back-btn">⬅ Go to Dashboard</a>

</body>
</html>