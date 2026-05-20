<?php
$conn = mysqli_connect("localhost","root","","zoo_planet");
$result = mysqli_query($conn,"SELECT * FROM tickets");
?>

<!DOCTYPE html>
<html>
<head>
<title>Ticket Management</title>

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
text-align:center;
padding:20px;
}

/* Table */
table{
width:90%;
margin:30px auto;
border-collapse:collapse;
background:white;
box-shadow:0px 5px 15px rgba(0,0,0,0.2);
}

th,td{
padding:12px;
border:1px solid #ccc;
text-align:center;
}

th{
background:#2e7d32;
color:white;
}

/* Token Style */
.token{
color:red;
font-weight:bold;
}

/* Back Button */
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
<h2>Booked Tickets</h2>
</div>

<table>

<tr>
<th>ID</th>
<th>Name</th>
<th>Mobile</th>
<th>Type</th>
<th>Qty</th>
<th>Date</th>
<th>Total</th>
<th>Token</th> <!-- 🔥 NEW COLUMN -->
</tr>

<?php
while($row=mysqli_fetch_assoc($result))
{
echo "<tr>";
echo "<td>".$row['id']."</td>";
echo "<td>".$row['name']."</td>";
echo "<td>".$row['mobile']."</td>";
echo "<td>".$row['ticket_type']."</td>";
echo "<td>".$row['quantity']."</td>";
echo "<td>".$row['visit_date']."</td>";
echo "<td>".$row['total_amount']."</td>";
echo "<td class='token'>".$row['token']."</td>"; // 🔥 TOKEN SHOW
echo "</tr>";
}
?>

</table>

<!-- BACK BUTTON -->
<a href="dashboard.php" class="back-btn">⬅ Back to Dashboard</a>

</body>
</html>