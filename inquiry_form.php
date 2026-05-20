<!DOCTYPE html>
<html>
<head>
<title>Zoo Inquiry</title>

<style>

body{
font-family:Arial;
background:#f2f7f2;
}

.container{
width:420px;
margin:60px auto;
background:white;
padding:30px;
border-radius:10px;
box-shadow:0px 0px 10px gray;
}

input,textarea{
width:100%;
padding:10px;
margin:10px 0;
}

button{
background:#2e7d32;
color:white;
padding:10px 20px;
border:none;
border-radius:5px;
}

</style>

</head>

<body>

<div class="container">

<h2>Zoo Inquiry</h2>

<form action="save_inquiry.php" method="post">

<input type="text" name="name" placeholder="Your Name" required>

<input type="email" name="email" placeholder="Your Email" required>

<textarea name="message" placeholder="Your Message"></textarea>

<button type="submit">Send Inquiry</button>

</form>

</div>

</body>
</html>