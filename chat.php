<?php include("../config/db.php"); $u=$_GET['u']; ?>
<link rel="stylesheet" href="../assets/css/style.css">

<div class="main">
<div class="card">
<?php
$m=mysqli_query($conn,"SELECT * FROM messages WHERE
(sender_id='{$_SESSION['user']['id']}' AND receiver_id='$u')
OR (sender_id='$u' AND receiver_id='{$_SESSION['user']['id']}')");
while($c=mysqli_fetch_assoc($m)){
 echo "<p>{$c['message']}</p>";
}
?>
</div>

<form method="post">
<input name="msg">
<button name="send">Send</button>
</form>

<?php
if(isset($_POST['send'])){
 mysqli_query($conn,"INSERT INTO messages(sender_id,receiver_id,message)
 VALUES('{$_SESSION['user']['id']}','$u','{$_POST['msg']}')");
}
?>
</div>
