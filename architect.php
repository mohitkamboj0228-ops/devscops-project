<?php include("../config/db.php"); ?>
<link rel="stylesheet" href="../assets/css/style.css">

<div class="sidebar">
<h2>Architect</h2>
<a href="">Projects</a>
<a href="../auth/logout.php">Logout</a>
</div>

<div class="main">
<?php
$p=mysqli_query($conn,"SELECT p.*,u.name FROM projects p JOIN users u ON p.customer_id=u.id
WHERE architect_id='{$_SESSION['user']['id']}'");
while($row=mysqli_fetch_assoc($p)){
?>
<div class="card">
<h4><?= $row['title'] ?></h4>
<p><?= $row['description'] ?></p>
<p>Client: <?= $row['name'] ?></p>
<a href="?approve=<?= $row['id'] ?>"><button>Approve</button></a>
<a href="../chat/chat.php?u=<?= $row['customer_id'] ?>"><button>Chat</button></a>
</div>
<?php } ?>

<?php
if(isset($_GET['approve'])){
 mysqli_query($conn,"UPDATE projects SET status='approved' WHERE id=".$_GET['approve']);
}
?>
</div>
