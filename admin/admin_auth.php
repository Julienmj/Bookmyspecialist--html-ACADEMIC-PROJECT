<?php
// filepath: c:\xampp\htdocs\bookmyspecialist\admin_auth.php
session_start();

// Basic authentication (replace with more secure methods)
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $_SESSION['admin'] = true;
    header("Location: admin_panel.php");
} else {
    header("Location: admin.html");
}
exit();
?>