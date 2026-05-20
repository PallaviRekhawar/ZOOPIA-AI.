<?php

$conn = mysqli_connect("localhost","root","","zoo_planet");

$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

$date = date("Y-m-d"); // 🔥 ADD THIS

$sql = "INSERT INTO inquiries(name,email,message,date)
VALUES('$name','$email','$message','$date')";

mysqli_query($conn,$sql);

?>

<!DOCTYPE html>
<html>
<head>
<title>Success</title>

<style>

body{
margin:0;
font-family:Arial;
background:linear-gradient(135deg, #2e7d32, #66bb6a);
display:flex;
justify-content:center;
align-items:center;
height:100vh;
}

/* Box */

.success-box{
background:white;
padding:40px;
border-radius:15px;
text-align:center;
box-shadow:0px 10px 25px rgba(0,0,0,0.3);
width:400px;
}

/* Text */

.success-box h1{
color:#2e7d32;
font-size:28px;
margin-bottom:15px;
}

.success-box p{
font-size:18px;
color:#555;
}

/* Button */

.success-box a{
display:inline-block;
margin-top:20px;
padding:12px 25px;
background:#2e7d32;
color:white;
text-decoration:none;
border-radius:8px;
}

.success-box a:hover{
background:#1b5e20;
}

</style>

</head>

<body>

<div class="success-box">

<h1>✔ Inquiry Sent Successfully</h1>

<p>Thank you for contacting us!</p>

<a href="index.html">Go Back</a>

</div>

</body>
</html>