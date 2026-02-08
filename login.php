<?php
include("../config/db.php");
if(isset($_POST['login'])){
 $q=mysqli_query($conn,"SELECT * FROM users WHERE email='{$_POST['email']}'");
 $u=mysqli_fetch_assoc($q);
 if($u && password_verify($_POST['password'],$u['password'])){
   $_SESSION['user']=$u;
   header("Location: ../dashboards/".$u['role'].".php");
 }
}
?>
<form method="post">
<input name="email">
<input type="password" name="password">
<button name="login">Login</button>
</form>
