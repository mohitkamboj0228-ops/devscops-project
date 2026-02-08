<?php include("../config/db.php"); ?>
<link rel="stylesheet" href="../assets/css/style.css">

<div class="sidebar">
<h2>Customer</h2>
<a href="">New Project</a>
<a href="../auth/logout.php">Logout</a>
</div>

<div class="main">
<div class="card">
<h3>Create Project</h3>
<form method="post">
<input name="title" placeholder="Project Title">
<textarea name="description"></textarea>
<select name="architect">
<?php
$a=mysqli_query($conn,"SELECT * FROM users WHERE role='architect'");
while($r=mysqli_fetch_assoc($a)){
 echo "<option value='{$r['id']}'>{$r['name']}</option>";
}
?>
</select>
<button name="send">Submit</button>
</form>
</div>

<?php
if(isset($_POST['send'])){
 mysqli_query($conn,"INSERT INTO projects(customer_id,architect_id,title,description)
 VALUES('{$_SESSION['user']['id']}','{$_POST['architect']}','{$_POST['title']}','{$_POST['description']}')");
}
?>
</div>
