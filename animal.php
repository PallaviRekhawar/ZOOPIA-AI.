<!DOCTYPE html>
<html>
<head>
<title>Animal Management</title>

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
cursor:pointer;
}

button:hover{
background:#1b5e20;
}

</style>

</head>

<body>

<div class="header">
<h1>Animal Management</h1>
</div>

<div class="container">

<form action="save_animal.php" method="post" enctype="multipart/form-data">

<input type="text" name="name" placeholder="Animal Name" required>

<input type="text" name="species" placeholder="Species" required>

<input type="text" name="cage" placeholder="Cage Number" required>

<input type="file" name="photo" required>

<button type="submit">Add Animal</button>

</form>

</div>

</body>
</html>