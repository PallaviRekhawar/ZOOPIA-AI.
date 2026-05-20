<?php

$conn = mysqli_connect("localhost","root","","zoo_planet");

$name = $_POST['name'];
$mobile = $_POST['mobile'];
$type = $_POST['ticket_type'];
$qty = $_POST['quantity'];
$date = $_POST['visit_date'];

if($type=="Adult"){
$price = 150;
$image = "Lion.jpg";
}

if($type=="Child"){
$price = 100;
$image = "Deer.jpg";
}

$gst = $price * 0.03;
$final = $price + $gst;
$total = $final * $qty;

/* 🔥 TOKEN GENERATE */
$token = rand(1000,9999);

/* 🔥 SAVE TICKET (TOKEN ADD केलं) */
$sql = "INSERT INTO tickets(name,mobile,ticket_type,quantity,visit_date,total_amount,token)
VALUES('$name','$mobile','$type','$qty','$date','$total','$token')";

mysqli_query($conn,$sql);

/* SAVE VISITOR */
$visitor_sql = "INSERT INTO visitors(name,mobile,ticket_type,quantity,visit_date)
VALUES('$name','$mobile','$type','$qty','$date')";

mysqli_query($conn,$visitor_sql);

?>

<!DOCTYPE html>
<html>
<head>
<title>Zoo Ticket</title>

<style>

body{
font-family:Arial;
background:#f2f7f2;
display:flex;
justify-content:center;
align-items:center;
height:100vh;
}

.ticket{
width:450px;
background:white;
padding:25px;
border-radius:10px;
border:4px solid #2e7d32;
box-shadow:0px 6px 15px rgba(0,0,0,0.3);
text-align:center;
}

.ticket h2{
color:#2e7d32;
margin-bottom:15px;
}

.ticket img{
width:100%;
height:180px;
object-fit:cover;
border-radius:8px;
margin-bottom:15px;
}

.details{
text-align:left;
font-size:17px;
font-weight:bold;
line-height:1.7;
}

/* 🔥 TOKEN STYLE */
.token{
font-size:22px;
color:red;
font-weight:bold;
margin:10px 0;
}

.success{
margin-top:15px;
font-size:18px;
color:green;
font-weight:bold;
}

.back-btn{
display:inline-block;
margin-top:15px;
padding:10px 20px;
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

<div class="ticket">

<h2>ZOO PLANET TICKET</h2>

<!-- 🔥 TOKEN DISPLAY -->
<p class="token">Token: <?php echo $token; ?></p>

<img src="<?php echo $image; ?>">

<div class="details">

<p>Name: <?php echo $name; ?></p>
<p>Mobile: <?php echo $mobile; ?></p>
<p>Ticket Type: <?php echo $type; ?></p>
<p>Number of Tickets: <?php echo $qty; ?></p>
<p>Visit Date: <?php echo $date; ?></p>

<hr>

<p>Price per Ticket: ₹<?php echo number_format($final,2); ?></p>
<p>Total Amount: ₹<?php echo number_format($total,2); ?></p>

</div>

<p class="success">✔ Ticket Booked Successfully</p>

<a href="index.html" class="back-btn">⬅ Back to Home</a>

</div>

</body>
</html>