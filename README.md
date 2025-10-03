📝 User Registration System (PHP + MySQL)

This project is a modern User Registration System built with PHP, MySQL, HTML, and CSS.
It allows users to register with their details, and provides an admin view to manage users (edit & delete records).

📂 Features

✅ Stylish registration form with validation

✅ Stores user details in MySQL database

✅ View all registered users in a table format

✅ Edit & Delete options with icons (pen ✏️ and trash 🗑️)

✅ Auto reorders IDs after deletion

✅ Responsive & clean UI

📂 Folder Structure
MyProject/
│
├── index.html          # Registration form page
├── register.php        # Handles registration (insert into DB)
├── view_users.php      # Displays all registered users in table
├── edit_user.php       # Edit existing user details
└── README.md           # Project description (this file)

⚙️ Database Setup

Open phpMyAdmin (http://localhost/phpmyadmin).

Create a database:

CREATE DATABASE user_registration;


Create a table:

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  fullname VARCHAR(100) NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

🚀 How to Run

Install XAMPP and start Apache + MySQL.

Copy project folder MyProject to:

C:\xampp\htdocs\


Open browser and go to:

http://localhost/MyProject/index.html


Register users and manage them in the table view.

🎯 Future Enhancements

🔒 Password hashing (for security)

👤 User login system

📊 Dashboard with statistics

✨ This project is perfect for beginners to learn PHP + MySQL with CRUD operations (Create, Read, Update, Delete).