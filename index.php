<?php
include("../config/db.php");

if(!isset($_SESSION['user']) || $_SESSION['user']['role']!='admin'){
    header("Location: ../auth/login.php");
    exit;
}

// ---------------------------
// PHOTO UPLOAD LOGIC
// ---------------------------
if(isset($_POST['upload_photo'])){
    if(isset($_FILES['photo']) && $_FILES['photo']['error']==0){
        $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $allowed = ['jpg','jpeg','png','webp'];
        if(in_array(strtolower($ext), $allowed)){
            $newName = time().rand(1000,9999).".".$ext;
            $target = "../assets/uploads/slider/".$newName;
            if(move_uploaded_file($_FILES['photo']['tmp_name'], $target)){
                mysqli_query($conn,"INSERT INTO slider (image) VALUES ('$newName')");
                $success = "Photo uploaded successfully!";
            } else {
                $error = "Failed to move file!";
            }
        } else {
            $error = "Invalid file type! Only jpg, jpeg, png, webp allowed.";
        }
    } else {
        $error = "No file selected!";
    }
}

// ---------------------------
// STATS
// ---------------------------
$totalUsers = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as t FROM users"))['t'];
$totalProjects = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as t FROM projects"))['t'];
$pending = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as t FROM projects WHERE status='pending'"))['t'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Panel | InteriorPro</title>
<link rel="stylesheet" href="../assets/css/style.css">
<style>
.topbar{
 background:white;
 padding:15px 25px;
 display:flex;
 justify-content:space-between;
 align-items:center;
 box-shadow:0 3px 10px rgba(0,0,0,.1);
}
.stats{
 display:grid;
 grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
 gap:20px;
 margin-top:20px;
}
.stat-box{
 background:white;
 padding:25px;
 border-radius:10px;
 box-shadow:0 5px 15px rgba(0,0,0,.08);
}
.stat-box h2{
 font-size:32px;
 margin:0;
 color:#2563eb;
}
.table{
 background:white;
 border-radius:10px;
 box-shadow:0 5px 15px rgba(0,0,0,.08);
 padding:20px;
 margin-top:25px;
}
table{
 width:100%;
 border-collapse:collapse;
}
table th,table td{
 padding:12px;
 border-bottom:1px solid #eee;
 text-align:left;
}
.badge{
 padding:4px 10px;
 border-radius:20px;
 font-size:12px;
 color:white;
}
.pending{ background:#f59e0b; }
.approved{ background:#16a34a; }
.rejected{ background:#dc2626; }

/* UPLOAD FORM STYLING */
.upload-form{
 background:white;
 padding:20px;
 border-radius:10px;
 box-shadow:0 5px 15px rgba(0,0,0,.08);
 margin-bottom:20px;
}
.upload-form input[type=file]{
 padding:10px;
}
.upload-form button{
 background:#2563eb;
 color:white;
 padding:10px 15px;
 border:none;
 border-radius:6px;
 cursor:pointer;
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
<h2>Admin</h2>
<a href="index.php" class="active">Dashboard</a>
<a href="users.php">Manage Users</a>
<a href="projects.php">Projects</a>
<a href="../auth/logout.php">Logout</a>
</div>

<div class="main">

<!-- TOP BAR -->
<div class="topbar">
<h3>Admin Dashboard</h3>
<p>Welcome, <?= $_SESSION['user']['name'] ?></p>
</div>

<!-- UPLOAD SLIDER PHOTO -->
<div class="upload-form">
<h3>Upload Slider Photo</h3>

<?php if(isset($success)){ echo "<p style='color:green;'>$success</p>"; } ?>
<?php if(isset($error)){ echo "<p style='color:red;'>$error</p>"; } ?>

<form method="post" enctype="multipart/form-data">
<input type="file" name="photo" required>
<button type="submit" name="upload_photo">Upload</button>
</form>
</div>

<!-- STATS -->
<div class="stats">
<div class="stat-box">
<h2><?= $totalUsers ?></h2>
<p>Total Users</p>
</div>

<div class="stat-box">
<h2><?= $totalProjects ?></h2>
<p>Total Projects</p>
</div>

<div class="stat-box">
<h2><?= $pending ?></h2>
<p>Pending Projects</p>
</div>
</div>

<!-- RECENT PROJECTS -->
<div class="table">
<h3>Recent Projects</h3>
<table>
<tr>
<th>Title</th>
<th>Customer</th>
<th>Architect</th>
<th>Status</th>
</tr>

<?php
$q = mysqli_query($conn,"
SELECT p.*, 
c.name as customer, 
a.name as architect 
FROM projects p
JOIN users c ON p.customer_id=c.id
JOIN users a ON p.architect_id=a.id
ORDER BY p.id DESC LIMIT 5
");

while($r=mysqli_fetch_assoc($q)){
?>
<tr>
<td><?= htmlspecialchars($r['title']) ?></td>
<td><?= htmlspecialchars($r['customer']) ?></td>
<td><?= htmlspecialchars($r['architect']) ?></td>
<td>
<span class="badge <?= $r['status'] ?>">
<?= ucfirst($r['status']) ?>
</span>
</td>
</tr>
<?php } ?>
</table>
</div>

</div>
</body>
</html>
