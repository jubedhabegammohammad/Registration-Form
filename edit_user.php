<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "user_registration";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("DB Connection failed: " . $conn->connect_error);

// Get user by ID
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM users WHERE id=$id");
    $user = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);

    $stmt = $conn->prepare("UPDATE users SET fullname=?, email=? WHERE id=?");
    $stmt->bind_param("ssi", $fullname, $email, $id);
    if ($stmt->execute()) {
        header("Location: view_users.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit User</title>
  <style>
    body { font-family: 'Poppins', sans-serif; display:flex; justify-content:center; align-items:center; height:100vh; background:#f0f0f0; }
    .box { background:white; padding:30px; border-radius:10px; box-shadow:0 5px 15px rgba(0,0,0,0.2); width:300px; }
    input { width:100%; padding:10px; margin:8px 0; border:1px solid #ccc; border-radius:5px; }
    button { padding:10px; width:100%; background:#28a745; color:white; border:none; border-radius:5px; cursor:pointer; }
    button:hover { background:#1e7e34; }
  </style>
</head>
<body>
  <div class="box">
    <h2>Edit User</h2>
    <form method="POST">
      <input type="hidden" name="id" value="<?= $user['id'] ?>">
      <label>Full Name</label>
      <input type="text" name="fullname" value="<?= $user['fullname'] ?>" required>
      <label>Email</label>
      <input type="email" name="email" value="<?= $user['email'] ?>" required>
      <button type="submit">Save Changes</button>
    </form>
  </div>
</body>
</html>

