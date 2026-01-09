<?php
// Simple database connection test
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bookmyspecialist_db";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    echo "<h3>Database Connection Test</h3>";
    echo "<p style='color: green;'>✓ Successfully connected to database: $dbname</p>";
    
    // Test if appointments table exists
    $result = $conn->query("SHOW TABLES LIKE 'appointments'");
    if ($result->num_rows > 0) {
        echo "<p style='color: green;'>✓ Appointments table exists</p>";
        
        // Count appointments
        $count = $conn->query("SELECT COUNT(*) as count FROM appointments")->fetch_assoc()['count'];
        echo "<p>Current appointments: $count</p>";
    } else {
        echo "<p style='color: orange;'>⚠ Appointments table not found. Please run database_setup.sql</p>";
    }
    
    $conn->close();
    echo "<p style='color: green;'>✓ Database test completed successfully</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
}
?>

<p><a href="index.html">Back to Home</a></p>
