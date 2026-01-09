<?php
// filepath: c:\xampp\htdocs\bookmyspecialist\admin_panel.php

session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin.html");
    exit();
}

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bookmyspecialist_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete appointment
if (isset($_GET['delete']) && isset($_SESSION['editing_mode']) && $_SESSION['editing_mode'] === true) {
    $id = filter_var($_GET['delete'], FILTER_SANITIZE_NUMBER_INT);
    if ($id && is_numeric($id)) {
        $stmt = $conn->prepare("DELETE FROM appointments WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "<script>alert('Appointment deleted successfully!');</script>";
        } else {
            echo "<script>alert('Error deleting appointment.');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Invalid appointment ID.');</script>";
    }
}

// Toggle editing mode
if (isset($_GET['toggle_edit'])) {
    $_SESSION['editing_mode'] = !isset($_SESSION['editing_mode']) || $_SESSION['editing_mode'] === false;
    header("Location: admin_panel.php"); // Refresh to apply changes
    exit();
}

// Fetch appointments
$sql = "SELECT * FROM appointments";
$result = $conn->query($sql);

$editing_mode = isset($_SESSION['editing_mode']) && $_SESSION['editing_mode'] === true;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../includes/styles.css">
    <style>
        body {
            background-image: url('../assets/images/background2.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: 'Inter', sans-serif;
            padding: 0;
            margin: 0;
            min-height: 100vh; /* Ensure full height */
        }
        .admin-container {
            max-width: 95%;
            margin: auto;
            background: rgba(159, 162, 241, 0.8); /* Transparent background */
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2); /* Fill remaining height */
        }
        .taskbar-header {
           background-image: url('../assets/images/background2.jpg');
            color:rgb(20, 20, 20);
            padding: 25px 0; /* Increased padding for larger taskbar */
            text-align: center;
            position: relative;
            display: flex; /* Use flexbox */
            justify-content: space-between; /* Space items evenly */
            align-items: center; /* Vertically align items */
        }
        .taskbar-header h1 {
            color: #004080;
            font-size: 1.8em;
            margin: 0;
            display: inline-block;
            flex-grow: 1; /* Allow title to expand */
            text-align: center; /* Center the title */
        }
        .taskbar-header a, .taskbar-header button {
            color: white;
            text-decoration: none;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #4b154a; /* Blue background */
            margin: 0 10px;
            display: inline-block;
        }
        .taskbar-header a:hover, .taskbar-header button:hover {
            background-color:rgb(159, 38, 161); /* Darker blue on hover */
        }
        .taskbar-header .left {
            text-align: left;
            margin-left: 10px; /* Push to the left */
        }
        .taskbar-header .right {
            text-align: right;
            margin-right: 10px; /* Push to the right */
        }
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .header-left {
            text-align: left;
        }
        .header-center {
            text-align: center;
        }
        .header-right {
            text-align: right;
        }
        h3 { /* Style for the table title */
            text-align: center;
            font-weight: bold;
            margin-top: 10px; /* Reduced margin */
            margin-Bottom: 20px;
            font-size: 1.5em; /* Increased font size */
            color: #141414;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px; /* Reduced margin */
            box-shadow: 0 0 10px #9fa2f1;
            background-color: #fff; /* White table background */
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #0056b3;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }
        tr:nth-child(even) {
            background-color: #fff; /* White even rows */
        }
        .delete-btn {
            background-color:rgb(184, 39, 23);
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .delete-btn:hover {
            background-color: #c0392b;
        }
        .user-interface-link, .logout-btn {
            background-color: #4b154a;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.2s;
            display: inline-block;
        }
        .user-interface-link:hover, .logout-btn:hover {
            background-color: #7f0077;
        }
        .edit-mode-btn {
            background-color:rgb(169, 14, 37);
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.2s;
            margin-top: 15px;
            display: inline-block;
            float: right;
        }
        .edit-mode-btn:hover {
            background-color:rgb(155, 31, 128);
        }
        .print-btn {
            background-color: #7f0077;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.2s;
            margin-top: 20px;
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: fit-content;
            text-align: center;
        }
        .print-btn:hover {
            background-color:rgb(146, 26, 138);
        }
        .no-delete {
            color: #7f8c8d;
            font-style: italic;
        }

        @media print {
            body {
                background: none;
                padding: 0;
                margin: 0;
                font-size: 10pt;
            }
            .admin-container {
                background: none;
                padding: 0;
                box-shadow: none;
            }
            .taskbar-header, .edit-mode-btn, .print-btn {
                display: none;
            }
            table {
                box-shadow: none;
                border: 1px solid #000;
            }
            th, td {
                border: 1px solid #000;
                padding: 8px;
                font-size: 9pt;
            }
            th {
                background-color: #ddd !important;
                color: #000 !important;
            }
        }
    </style>
</head>
<body>
    <div class="taskbar-header">
        <div class="left">
            <a href="bookmyspecialist.php">Return to User Interface</a>
        </div>
        <h1>ADMIN PANEL</h1>
        <div class="right">
            <button onclick="location.href='logout.php'">Logout</button>
        </div>
    </div>

    <div class="admin-container">
        <h3 >Appointments Table</h3>

        <!-- Edit Mode Button -->
        <div style="text-align: right;">
             <button class="edit-mode-btn" onclick="toggleEditMode()">
                <?php echo $editing_mode ? "Disable Editing Mode" : "Enable Editing Mode"; ?>
            </button>
        </div>

        <table id="appointmentsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Department</th>
                    <th>Doctor</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"]. "</td>";
                        echo "<td>" . $row["department"]. "</td>";
                        echo "<td>" . $row["doctor"]. "</td>";
                        echo "<td>" . $row["fullName"]. "</td>";
                        echo "<td>" . $row["email"]. "</td>";
                        echo "<td>" . $row["phone"]. "</td>";
                        echo "<td>";
                        if ($editing_mode) {
                            echo "<button class='delete-btn' onclick='deleteAppointment(" . $row["id"]. ")'>Delete</button>";
                        } else {
                            echo "<span class='no-delete'>View Only</span>";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No appointments found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Print Button -->
        <button class="print-btn" onclick="printAppointments()">Print Appointments</button>
    </div>
    <script>
        function deleteAppointment(id) {
            if (confirm("Are you sure you want to delete this appointment?")) {
                window.location.href = "admin_panel.php?delete=" + id;
            }
        }

        function toggleEditMode() {
            window.location.href = "admin_panel.php?toggle_edit=1";
        }

        function printAppointments() {
            window.print();
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>