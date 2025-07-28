<?php
include 'config.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $age = intval($_POST['age']);
    $gender = $_POST['gender'];
    $course = $_POST['course'];
    
    // Validate inputs
    $errors = array();
    
    // Validate name
    if (empty($name)) {
        $errors[] = "Name is required";
    } elseif (strlen($name) < 2) {
        $errors[] = "Name must be at least 2 characters long";
    } elseif (strlen($name) > 100) {
        $errors[] = "Name must be less than 100 characters";
    }
    
    // Validate email
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    } else {
        // Check if email already exists
        $email_check_sql = "SELECT id FROM contacts WHERE email = ?";
        $email_check_stmt = $conn->prepare($email_check_sql);
        $email_check_stmt->bind_param("s", $email);
        $email_check_stmt->execute();
        $email_result = $email_check_stmt->get_result();
        
        if ($email_result->num_rows > 0) {
            $errors[] = "Email address already exists";
        }
        $email_check_stmt->close();
    }
    
    // Validate age
    if (empty($age) || $age <= 0) {
        $errors[] = "Please enter a valid age";
    } elseif ($age < 1 || $age > 120) {
        $errors[] = "Age must be between 1 and 120";
    }
    
    // Validate gender
    if (empty($gender)) {
        $errors[] = "Please select a gender";
    } elseif (!in_array($gender, ['Male', 'Female', 'Other'])) {
        $errors[] = "Invalid gender selection";
    }
    
    // Validate course
    if (empty($course)) {
        $errors[] = "Please select a course";
    }
    
    // If no errors, insert into database
    if (empty($errors)) {
        // Prepare SQL statement
        $sql = "INSERT INTO contacts (name, email, age, gender, course) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            // Bind parameters
            $stmt->bind_param("ssiss", $name, $email, $age, $gender, $course);
            
            // Execute the statement
            if ($stmt->execute()) {
                // Success - redirect to index page with success message
                $stmt->close();
                $conn->close();
                header("Location: index.php?success=1");
                exit();
            } else {
                $errors[] = "Database error: " . $stmt->error;
            }
            
            $stmt->close();
        } else {
            $errors[] = "Database prepare error: " . $conn->error;
        }
    }
    
    // If there are errors, redirect back with error message
    if (!empty($errors)) {
        $error_message = implode(", ", $errors);
        $conn->close();
        header("Location: index.php?error=" . urlencode($error_message));
        exit();
    }
} else {
    // If not POST request, redirect to index
    header("Location: index.php");
    exit();
}

$conn->close();
?>