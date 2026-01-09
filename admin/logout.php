<?php
// filepath: c:\xampp\htdocs\bookmyspecialist\logout.php
session_start();
session_destroy();
header("Location: admin.html");
exit();
?>