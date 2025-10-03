<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "user_registration";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("DB Connection failed: " . $conn->connect_error);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['fullname']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) die("Invalid email format!");

    // check duplicate email
    $check = $conn->prepare("SELECT id FROM users WHERE email=?");
    $check->bind_param("s", $email);
    $check->execute(); $check->store_result();
    if ($check->num_rows > 0) {
        echo "<script>alert('❌ Email already exists!'); window.location.href='index.html';</script>";
        exit;
    }
    $check->close();

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $fullname, $email, $hashedPassword);

    if ($stmt->execute()) {
        $created_at = date("Y-m-d H:i:s");
        echo "
        <html><head><title>Success</title>
        <style>
          body {font-family:'Poppins',sans-serif; display:flex; justify-content:center; align-items:center; height:100vh; background:#f0f0f0;}
          .box {background:white; padding:30px; border-radius:10px; text-align:center; box-shadow:0 5px 15px rgba(0,0,0,0.2);}
          a {display:inline-block; margin-top:15px; padding:10px 20px; background:#667eea; color:#fff; text-decoration:none; border-radius:8px;}
          a:hover {background:#5a67d8;}
        </style>
        </head><body>
          <div class='box'>
            <h2>🎉 Registration Successful!</h2>
            <p><b>Name:</b> $fullname</p>
            <p><b>Email:</b> $email</p>
            <p><b>Registered At:</b> $created_at</p>
            <a href='view_users.php'>📋 View All Users</a>
          </div>
        </body></html>";
    } else {
        echo "Error: " . $conn->error;
    }
}
$conn->close();
?>
