<img width="1885" height="941" alt="image" src="https://github.com/user-attachments/assets/607563c3-bf8f-44b3-b717-9472b05aa37a" /># BookMySpecialist - Appointment Booking System

A modern, responsive web application for booking specialist appointments with an admin panel for managing bookings.

## 📸 Application Preview

<img width="1885" height="941" alt="image" src="https://github.com/user-attachments/assets/bcce0cb7-58d8-49b9-b017-35303cb58ba5" />
)

*Note: Add your application screenshot as `screenshot.png` in the `assets/images/` folder*

## Features

### User Interface
- **Department Selection**: Choose between Physical Health and Mental Wellness departments
- **Specialist Booking**: Select from various medical specialists
- **Doctor Scheduling**: View available time slots for each doctor
- **User Information Form**: Secure modal form for entering booking details
- **Responsive Design**: Works seamlessly on desktop, tablet, and mobile devices

### Admin Panel
- **Secure Authentication**: Password-protected admin access
- **Appointment Management**: View all booked appointments
- **Edit Mode**: Toggle between view-only and edit modes
- **Delete Functionality**: Remove appointments when needed
- **Print Support**: Print appointment lists for record-keeping

## Project Structure

```
bookmyspecialist1/
├── assets/
│   ├── images/           # All image files (logos, backgrounds, etc.)
│   └── docs/             # Documentation and help files
├── admin/                # Admin panel files
│   ├── admin.html
│   ├── admin_auth.php
│   ├── admin_panel.php
│   └── logout.php
├── includes/            # Shared resources
│   ├── styles.css        # Main stylesheet
│   └── script.js        # JavaScript functionality
├── index.html           # Landing page
├── bookmyspecialist.php # Main booking application
├── database_setup.sql   # Database initialization
└── README.md           # This file
```

## Setup Instructions

### Prerequisites
- XAMPP or similar web server with PHP and MySQL
- Web browser (Chrome, Firefox, Safari, Edge)

### Installation Steps

1. **Extract/Place Files**
   - Place the `bookmyspecialist1` folder in your XAMPP htdocs directory
   - Path should be: `C:\xampp\htdocs\bookmyspecialist1\`

2. **Database Setup**
   - Start XAMPP and launch phpMyAdmin
   - Create a new database named `bookmyspecialist_db`
   - Import the `database_setup.sql` file or run the SQL commands manually:
     ```sql
     CREATE DATABASE IF NOT EXISTS bookmyspecialist_db;
     USE bookmyspecialist_db;
     CREATE TABLE IF NOT EXISTS appointments (
         id INT(11) AUTO_INCREMENT PRIMARY KEY,
         department VARCHAR(100) NOT NULL,
         doctor VARCHAR(200) NOT NULL,
         fullName VARCHAR(100) NOT NULL,
         email VARCHAR(100) NOT NULL,
         phone VARCHAR(20) NOT NULL,
         created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
     );
     ```

3. **Configure Database**
   - The application uses default XAMPP credentials:
     - Host: localhost
     - Username: root
     - Password: (empty)
     - Database: bookmyspecialist_db
   - If you use different credentials, update them in:
     - `bookmyspecialist.php` (line 4-7)
     - `admin/admin_panel.php` (line 13-16)

4. **Access the Application**
   - Start Apache and MySQL in XAMPP
   - Open your browser and navigate to: `http://localhost/bookmyspecialist1/`

## Usage

### For Users
1. **Select Department**: Choose between Physical Health or Mental Wellness
2. **Choose Specialist**: Select a medical specialty
3. **Pick Doctor**: Choose from available doctors with their time slots
4. **Book Appointment**: Click "Book Now" and fill in your details
5. **Confirmation**: Receive booking confirmation with details

### For Administrators
1. **Access Admin Panel**: Click "Admin" button and enter password
   - Default password: `admin123`
2. **View Appointments**: See all booked appointments in a table
3. **Enable Edit Mode**: Toggle editing mode to make changes
4. **Delete Appointments**: Remove appointments as needed
5. **Print Records**: Generate printable lists of appointments

## Security Features

- **Input Validation**: All user inputs are validated and sanitized
- **SQL Injection Prevention**: Uses prepared statements
- **XSS Protection**: HTML special characters are escaped
- **Session Management**: Secure admin authentication
- **Data Validation**: Email format, phone number, and name validation

## Customization

### Changing Admin Password
Edit the password in `admin/admin.html` (line 59):
```javascript
const correctPassword = 'your-new-password';
```

### Adding New Specialists
1. Add new options to the select elements in `bookmyspecialist.php`
2. Update the `getDepartmentName()` function if adding new departments
3. Modify the CSS styling if needed for new elements

### Styling Customization
- Main styles are in `includes/styles.css`
- Responsive design breakpoints are included
- Color scheme can be easily modified via CSS variables

## Browser Compatibility

- Chrome 60+
- Firefox 55+
- Safari 12+
- Edge 79+

## Technical Specifications

- **Frontend**: HTML5, CSS3, JavaScript (ES6)
- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+ / MariaDB 10.2+
- **Server**: Apache (XAMPP recommended)
- **Responsive**: Mobile-first design approach

## Troubleshooting

### Common Issues

1. **Database Connection Error**
   - Ensure MySQL is running in XAMPP
   - Check database credentials in PHP files
   - Verify database exists and tables are created

2. **Images Not Loading**
   - Check file paths in `includes/styles.css`
   - Ensure images are in `assets/images/` directory

3. **Admin Access Denied**
   - Verify password in `admin/admin.html`
   - Check session settings in PHP

4. **Form Not Submitting**
   - Check JavaScript console for errors
   - Verify form action and method attributes
   - Ensure all required fields are filled

### Error Logs
- PHP errors: Check XAMPP logs at `C:\xampp\apache\logs\error.log`
- MySQL errors: Check in phpMyAdmin or MySQL logs

## Support

For issues and questions:
1. Check the troubleshooting section above
2. Verify all setup steps were completed correctly
3. Ensure all file permissions are set correctly
4. Test with different browsers if needed

## License

This project is for educational and demonstration purposes. Feel free to modify and use according to your needs.

---

**Version**: 1.0  
**Last Updated**: January 2026  
**Framework**: Custom PHP/JavaScript application


