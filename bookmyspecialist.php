<?php

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

// Function to sanitize user inputs
function sanitizeInput($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $conn->real_escape_string($data);
}

// Function to validate email
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// Function to validate phone number
function validatePhone($phone) {
    // Remove all non-digit characters
    $cleaned = preg_replace('/[^0-9]/', '', $phone);
    // Check if it's between 10-15 digits
    return strlen($cleaned) >= 10 && strlen($cleaned) <= 15;
}

// Function to validate name
function validateName($name) {
    // Allow letters, spaces, hyphens, and apostrophes
    return preg_match('/^[a-zA-Z\s\-\'\.]{2,50}$/', $name);
}

// Function to get department name based on select ID
function getDepartmentName($selectId) {
    switch ($selectId) {
        case 'cardiology': return 'Cardiology';
        case 'orthopedics': return 'Orthopedics';
        case 'dermatology': return 'Dermatology';
        case 'psychiatry': return 'Psychiatry';
        case 'psychology': return 'Psychology';
        case 'therapy': return 'Therapy & Counseling';
        default: return 'Unknown Department';
    }
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $departmentId = isset($_POST["departmentId"]) ? sanitizeInput($_POST["departmentId"]) : '';
    $department = getDepartmentName($departmentId);
    $doctor = isset($_POST["doctor"]) ? sanitizeInput($_POST["doctor"]) : '';
    $fullName = isset($_POST["fullName"]) ? sanitizeInput($_POST["fullName"]) : '';
    $email = isset($_POST["email"]) ? sanitizeInput($_POST["email"]) : '';
    $phone = isset($_POST["phone"]) ? sanitizeInput($_POST["phone"]) : '';

    // Validate inputs
    $errors = [];
    
    if (empty($departmentId) || $department === 'Unknown Department') {
        $errors[] = "Invalid department selected.";
    }
    
    if (empty($doctor)) {
        $errors[] = "Please select a doctor.";
    }
    
    if (!validateName($fullName)) {
        $errors[] = "Please enter a valid name (2-50 characters, letters only).";
    }
    
    if (!validateEmail($email)) {
        $errors[] = "Please enter a valid email address.";
    }
    
    if (!validatePhone($phone)) {
        $errors[] = "Please enter a valid phone number (10-15 digits).";
    }

    if (!empty($errors)) {
        echo "<script>alert('" . implode("\\n", $errors) . "');</script>";
    } else {
        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO appointments (department, doctor, fullName, email, phone) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $department, $doctor, $fullName, $email, $phone);
        
        if ($stmt->execute()) {
            echo "<script>
                alert('Appointment Booked!\\nName: $fullName\\nEmail: $email\\nPhone: $phone\\nDepartment: $department\\nDoctor: $doctor');
                window.location = '" . $_SERVER['PHP_SELF'] . "';
            </script>";
            exit;
        } else {
            echo "<script>alert('Error booking appointment. Please try again.');</script>";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>BookMySpecialist</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="includes/styles.css" />
</head>
<body>
  <header>
    <div class="header-bar updated-header">
      <div class="header-left">
        <img src="assets/images/logo.png" alt="Logo" class="logo" />
      </div>
      <div class="header-center">
        <h1 class="site-title">BookMySpecialist</h1>
      </div>
      <div class="header-right">
        <button id="homeBtn" class="header-btn">Documentation</button>
        <button id="helpBtn" class="header-btn">Help</button>
        <button id="adminBtn" class="header-btn">Admin</button>
      </div>
    </div>
    <p class="subtitle">Easily choose your specialist and schedule an appointment instantly</p>
  </header>

  <main class="departments">
    <!-- PHYSICAL HEALTH DEPT -->
    <section class="department">
      <h2>Physical Health Department</h2>
      <div class="specialty">
        <label for="cardiology">Cardiology</label>
        <form id="cardiologyForm" method="post">
            <select id="cardiology" name="doctor">
              <option disabled selected>Select a Doctor here</option>
              <option value="Dr. Smith – 9AM-12PM">Dr. Smith – 9AM-12PM</option>
              <option value="Dr. Patel – 1PM-4PM">Dr. Patel – 1PM-4PM</option>
              <option value="Dr. Lee – 4PM-7PM">Dr. Lee – 4PM-7PM</option>
            </select>
            <input type="hidden" name="departmentId" value="cardiology">
            <input type="hidden" name="fullName" id="cardiologyFullName">
            <input type="hidden" name="email" id="cardiologyEmail">
            <input type="hidden" name="phone" id="cardiologyPhone">
            <button type="button" class="book-btn" data-dept="cardiology" data-form="cardiologyForm">Book Now</button>
        </form>
      </div>
      <div class="specialty">
        <label for="orthopedics">Orthopedics</label>
        <form id="orthopedicsForm" method="post">
            <select id="orthopedics" name="doctor">
              <option disabled selected>Select a Doctor here</option>
              <option value="Dr. Adams – 10AM-1PM">Dr. Adams – 10AM-1PM</option>
              <option value="Dr. White – 2PM-5PM">Dr. White – 2PM-5PM</option>
              <option value="Dr. Green – 6PM-9PM">Dr. Green – 6PM-9PM</option>
            </select>
            <input type="hidden" name="departmentId" value="orthopedics">
            <input type="hidden" name="fullName" id="orthopedicsFullName">
            <input type="hidden" name="email" id="orthopedicsEmail">
            <input type="hidden" name="phone" id="orthopedicsPhone">
            <button type="button" class="book-btn" data-dept="orthopedics" data-form="orthopedicsForm">Book Now</button>
        </form>
      </div>
      <div class="specialty">
        <label for="dermatology">Dermatology</label>
        <form id="dermatologyForm" method="post">
            <select id="dermatology" name="doctor">
              <option disabled selected>Select a Doctor here</option>
              <option value="Dr. Rose – 8AM-11AM">Dr. Rose – 8AM-11AM</option>
              <option value="Dr. Snow – 12PM-3PM">Dr. Snow – 12PM-3PM</option>
              <option value="Dr. Hill – 4PM-6PM">Dr. Hill – 4PM-6PM</option>
            </select>
            <input type="hidden" name="departmentId" value="dermatology">
            <input type="hidden" name="fullName" id="dermatologyFullName">
            <input type="hidden" name="email" id="dermatologyEmail">
            <input type="hidden" name="phone" id="dermatologyPhone">
            <button type="button" class="book-btn" data-dept="dermatology" data-form="dermatologyForm">Book Now</button>
        </form>
      </div>
    </section>

    <!-- MENTAL WELLNESS DEPT -->
    <section class="department">
      <h2>Mental Wellness Department</h2>
      <div class="specialty">
        <label for="psychiatry">Psychiatry</label>
        <form id="psychiatryForm" method="post">
            <select id="psychiatry" name="doctor">
              <option disabled selected>Select a Doctor here</option>
              <option value="Dr. Ahmed – 10AM-1PM">Dr. Ahmed – 10AM-1PM</option>
              <option value="Dr. Chan – 2PM-5PM">Dr. Chan – 2PM-5PM</option>
              <option value="Dr. Kumar – 6PM-9PM">Dr. Kumar – 6PM-9PM</option>
            </select>
            <input type="hidden" name="departmentId" value="psychiatry">
            <input type="hidden" name="fullName" id="psychiatryFullName">
            <input type="hidden" name="email" id="psychiatryEmail">
            <input type="hidden" name="phone" id="psychiatryPhone">
            <button type="button" class="book-btn" data-dept="psychiatry" data-form="psychiatryForm">Book Now</button>
        </form>
      </div>
      <div class="specialty">
        <label for="psychology">Psychology</label>
        <form id="psychologyForm" method="post">
            <select id="psychology" name="doctor">
              <option disabled selected>Select a Doctor here</option>
              <option value="Dr. Hope – 8AM-10AM">Dr. Hope – 8AM-10AM</option>
              <option value="Dr. Gray – 12PM-3PM">Dr. Gray – 12PM-3PM</option>
              <option value="Dr. Stone – 4PM-6PM">Dr. Stone – 4PM-6PM</option>
            </select>
            <input type="hidden" name="departmentId" value="psychology">
            <input type="hidden" name="fullName" id="psychologyFullName">
            <input type="hidden" name="email" id="psychologyEmail">
            <input type="hidden" name="phone" id="psychologyPhone">
            <button type="button" class="book-btn" data-dept="psychology" data-form="psychologyForm">Book Now</button>
        </form>
      </div>
      <div class="specialty">
        <label for="therapy">Therapy & Counseling</label>
        <form id="therapyForm" method="post">
            <select id="therapy" name="doctor">
              <option disabled selected>Select a Doctor here</option>
              <option value="Dr. Clark – 9AM-11AM">Dr. Clark – 9AM-11AM</option>
              <option value="Dr. Taylor – 1PM-3PM">Dr. Taylor – 1PM-3PM</option>
              <option value="Dr. Quinn – 5PM-7PM">Dr. Quinn – 5PM-7PM</option>
            </select>
            <input type="hidden" name="departmentId" value="therapy">
            <input type="hidden" name="fullName" id="therapyFullName">
            <input type="hidden" name="email" id="therapyEmail">
            <input type="hidden" name="phone" id="therapyPhone">
            <button type="button" class="book-btn" data-dept="therapy" data-form="therapyForm">Book Now</button>
        </form>
      </div>
    </section>
  </main>

  <!-- Modal for user info -->
  <div id="userInfoModal" class="modal hidden">
    <div class="modal-content">
      <h2>Enter Your Information</h2>
      <label for="userFullName">Full Name:</label>
      <input type="text" id="userFullName" placeholder="Your Name" required>
      <label for="userEmail">Email Address:</label>
      <input type="email" id="userEmail" placeholder="Your Email" required>
      <label for="userPhone">Phone Number:</label>
      <input type="tel" id="userPhone" placeholder="Your Phone" required>
      <div class="modal-buttons">
        <button id="confirmBookingBtn" class="header-btn">Confirm</button>
        <button id="cancelBookingBtn" class="header-btn">Cancel</button>
      </div>
    </div>
  </div>

  <script src="includes/script.js"></script>
</body>
</html>
<?php $conn->close(); ?>