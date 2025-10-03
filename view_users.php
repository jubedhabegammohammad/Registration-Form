<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "user_registration";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("DB Connection failed: " . $conn->connect_error);

// Delete user
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM users WHERE id=$id");

    // Reorder IDs sequentially
    $conn->query("SET @num := 0");
    $conn->query("UPDATE users SET id = @num := (@num+1)");
    $conn->query("ALTER TABLE users AUTO_INCREMENT = 1");

    header("Location: view_users.php");
    exit;
}

// Fetch all users
$result = $conn->query("SELECT * FROM users ORDER BY id ASC");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Registered Users</title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      padding: 20px;
      background-color: #000; /* Black background */
      color: #fff; /* Text color white */
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background-color: #222; /* Dark table background */
      box-shadow: 0 5px 15px rgba(0,0,0,0.5);
      border-radius: 10px;
      overflow: hidden;
      color: #fff;
    }

    th, td {
      padding: 12px;
      border: 1px solid #444;
      text-align: center;
    }

    th {
      background-color: #555;
    }

    /* Symbols styling */
    a.action {
      font-size: 20px;
      margin: 0 5px;
      text-decoration: none;
      display: inline-block;
      padding: 5px 10px;
      border-radius: 8px;
      transition: 0.2s;
      color: #fff;
    }
    a.edit { background-color: #28a745; }
    a.edit:hover { background-color: #218838; transform: scale(1.1); }
    a.delete { background-color: #dc3545; }
    a.delete:hover { background-color: #b02a37; transform: scale(1.1); }

    a.back {
      display: inline-block;
      margin-top: 15px;
      padding: 10px 15px;
      background: #667eea;
      color: white;
      text-decoration: none;
      border-radius: 8px;
      transition: 0.2s;
    }
    a.back:hover {
      background: #5a67d8;
      transform: translateY(-2px);
    }

    /* Optional: alternate row colors */
    tr:nth-child(even) { background-color: #333; }
    tr:nth-child(odd)  { background-color: #222; }
  </style>
</head>
<body>
  <h2 style="text-align:center;">📋 Registered Users</h2>
  <table>
    <tr>
      <th>ID</th>
      <th>Full Name</th>
      <th>Email</th>
      <th>Registered At</th>
      <th>Action</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= $row['id'] ?></td>
      <td><?= htmlspecialchars($row['fullname']) ?></td>
      <td><?= htmlspecialchars($row['email']) ?></td>
      <td><?= $row['created_at'] ?></td>
      <td>
        <a class="action edit" href="edit_user.php?id=<?= $row['id'] ?>">✏️</a>
        <a class="action delete" href="view_users.php?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this user?');">🗑️</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>
  <a class="back" href="index.html">⬅ Back to Registration</a>
</body>
</html>
