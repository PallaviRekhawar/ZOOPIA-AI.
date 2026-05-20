<!DOCTYPE html>
<html>
<head>
<title>Staff Management</title>

<style>
body{
font-family:Arial;
background:#f2f7f2;
margin:0;
}

.header{
background:#2e7d32;
color:white;
text-align:center;
padding:20px;
}

.container{
width:500px;
margin:50px auto;
background:white;
padding:30px;
border-radius:10px;
box-shadow:0px 0px 10px gray;
}

input{
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

<div class="header">
<h1>Staff Management</h1>
</div>

<div class="container">

<form action="save_staff.php" method="post">

<input type="text" name="name" placeholder="Staff Name" required>

<input type="text" name="role" placeholder="Role" required>

<input type="text" name="contact" placeholder="Contact Number" required>

<button type="submit">Add Staff</button>

</form>

</div>

</body>
</html>