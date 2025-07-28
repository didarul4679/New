# PHP Contact Form with Database

A complete contact/registration form system built with PHP and MySQL, featuring a modern responsive design and comprehensive form validation.

## Features

- **Complete Registration Form** with all required fields:
  - Name (required)
  - Email (required, validated)
  - Age (required, 1-120)
  - Gender (Male/Female/Other - required)
  - Password (required, minimum 6 characters, securely hashed)
  - Course Selection (dropdown with multiple courses)

- **Database Integration**:
  - MySQL database with proper relationships
  - Secure password hashing using PHP's `password_hash()`
  - Prepared statements to prevent SQL injection
  - Email uniqueness validation

- **Modern UI/UX**:
  - Responsive design that works on all devices
  - Beautiful gradient design with smooth animations
  - Form validation with user-friendly error messages
  - Success/error message display

- **Admin Features**:
  - View all registrations page
  - Statistics dashboard
  - Sortable data table

## Files Structure

```
├── database.sql           # Database schema and sample data
├── config.php            # Database configuration and connection
├── index.php             # Main registration form
├── view_registrations.php # Admin page to view all registrations
└── README.md             # This file
```

## Setup Instructions

### 1. Database Setup

1. Create a MySQL database:
   ```sql
   CREATE DATABASE contact_form_db;
   ```

2. Import the database schema:
   ```bash
   mysql -u root -p contact_form_db < database.sql
   ```

   Or manually run the SQL commands from `database.sql` in your MySQL client.

### 2. Configuration

1. Update database credentials in `config.php`:
   ```php
   define('DB_HOST', 'localhost');     // Your MySQL host
   define('DB_USER', 'root');          // Your MySQL username
   define('DB_PASS', '');              // Your MySQL password
   define('DB_NAME', 'contact_form_db'); // Database name
   ```

### 3. Web Server Setup

1. **XAMPP/WAMP/MAMP**:
   - Copy all files to your `htdocs` (XAMPP) or `www` (WAMP) folder
   - Access via `http://localhost/your-folder-name/`

2. **Local PHP Server**:
   ```bash
   php -S localhost:8000
   ```
   Then visit `http://localhost:8000`

## Usage

### User Registration
1. Visit `index.php`
2. Fill out the registration form with all required fields
3. Select a course from the dropdown
4. Submit the form
5. View success/error messages

### Admin Panel
1. Visit `view_registrations.php` to see all registrations
2. View statistics and detailed user information
3. Data is displayed in a sortable, responsive table

## Database Schema

### Courses Table
- `id` (Primary Key)
- `course_name` (e.g., "Web Development")
- `course_code` (e.g., "WD101")
- `created_at` (Timestamp)

### Contacts Table
- `id` (Primary Key)
- `name` (User's full name)
- `email` (Unique email address)
- `age` (User's age)
- `gender` (male/female/other)
- `password` (Hashed password)
- `course_id` (Foreign key to courses table)
- `created_at` (Registration timestamp)

## Security Features

- **Password Hashing**: Uses PHP's `password_hash()` with default algorithm
- **SQL Injection Prevention**: All queries use prepared statements
- **Input Validation**: Server-side validation for all fields
- **XSS Prevention**: All output is escaped using `htmlspecialchars()`
- **Email Validation**: Both client-side and server-side email validation

## Form Validation

### Client-side (HTML5)
- Required field validation
- Email format validation
- Number input constraints
- Minimum password length

### Server-side (PHP)
- Empty field validation
- Email format validation using `filter_var()`
- Age range validation (1-120)
- Password length validation (minimum 6 characters)
- Course selection validation
- Email uniqueness check

## Customization

### Adding New Courses
1. Insert new courses into the `courses` table:
   ```sql
   INSERT INTO courses (course_name, course_code) VALUES 
   ('Your Course Name', 'COURSE_CODE');
   ```

### Styling Changes
- Modify the CSS in `index.php` and `view_registrations.php`
- Color scheme uses CSS custom properties for easy theming

### Database Configuration
- Update connection settings in `config.php`
- Modify table schemas in `database.sql` if needed

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher (or MariaDB equivalent)
- Web server (Apache, Nginx, or PHP built-in server)

## Troubleshooting

### Database Connection Issues
1. Check database credentials in `config.php`
2. Ensure MySQL server is running
3. Verify database exists and user has proper permissions

### Form Not Submitting
1. Check PHP error logs
2. Ensure all required fields are filled
3. Verify database tables exist

### Styling Issues
1. Clear browser cache
2. Check for CSS conflicts
3. Ensure responsive viewport meta tag is present

## License

This project is open source and available under the MIT License.