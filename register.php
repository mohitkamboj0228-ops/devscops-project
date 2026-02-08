<?php
include("../config/db.php");
if(isset($_POST['register'])){
 $pass = password_hash($_POST['password'],PASSWORD_DEFAULT);
 mysqli_query($conn,"INSERT INTO users(name,email,password,role)
 VALUES('{$_POST['name']}','{$_POST['email']}','$pass','{$_POST['role']}')");
 header("Location: login.php");
}
?>
<form method="post">
<input name="name" placeholder="Name">
<input name="email">
<input type="password" name="password">
<select name="role">
<option value="customer">Customer</option>
<option value="architect">Architect</option>
</select>
<button name="register">Register</button>
</form>
