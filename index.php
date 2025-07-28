<?php
require_once 'config.php';

// Get courses for dropdown
$courses = getCourses();

// Handle form submission
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $age = (int)($_POST['age'] ?? 0);
    $gender = $_POST['gender'] ?? '';
    $password = $_POST['password'] ?? '';
    $course_id = (int)($_POST['course_id'] ?? 0);
    
    // Validation
    $errors = [];
    
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    if ($age <= 0 || $age > 120) {
        $errors[] = "Please enter a valid age";
    }
    
    if (empty($gender)) {
        $errors[] = "Gender is required";
    }
    
    if (empty($password)) {
        $errors[] = "Password is required";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long";
    }
    
    if ($course_id <= 0) {
        $errors[] = "Please select a course";
    }
    
    if (empty($errors)) {
        try {
            $pdo = getConnection();
            
            // Check if email already exists
            $stmt = $pdo->prepare("SELECT id FROM contacts WHERE email = ?");
            $stmt->execute([$email]);
            
            if ($stmt->fetch()) {
                $message = "Email already exists. Please use a different email.";
                $messageType = 'error';
            } else {
                // Hash password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                
                // Insert into database
                $stmt = $pdo->prepare("
                    INSERT INTO contacts (name, email, age, gender, password, course_id) 
                    VALUES (?, ?, ?, ?, ?, ?)
                ");
                
                $stmt->execute([$name, $email, $age, $gender, $hashedPassword, $course_id]);
                
                $message = "Registration successful! Welcome to our course.";
                $messageType = 'success';
                
                // Clear form data on success
                $name = $email = $gender = $password = '';
                $age = 0;
                $course_id = 0;
            }
        } catch (PDOException $e) {
            $message = "Database error: " . $e->getMessage();
            $messageType = 'error';
        }
    } else {
        $message = implode('<br>', $errors);
        $messageType = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Registration Form</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 500px;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
            padding: 30px;
        }

        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .header p {
            opacity: 0.9;
            font-size: 16px;
        }

        .form-container {
            padding: 40px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 15px;
            border: 2px solid #e1e1e1;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
            background: #f8f9fa;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
            background: white;
        }

        .radio-group {
            display: flex;
            gap: 20px;
            margin-top: 8px;
        }

        .radio-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .radio-item input[type="radio"] {
            width: auto;
            margin: 0;
        }

        .btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn:active {
            transform: translateY(0);
        }

        .message {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .message.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .message.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .required {
            color: #e74c3c;
        }

        @media (max-width: 480px) {
            .container {
                margin: 10px;
            }
            
            .form-container {
                padding: 25px;
            }
            
            .header {
                padding: 20px;
            }
            
            .radio-group {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Course Registration</h1>
            <p>Join our amazing courses and start your learning journey</p>
        </div>
        
        <div class="form-container">
            <?php if ($message): ?>
                <div class="message <?php echo $messageType; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="name">Full Name <span class="required">*</span></label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address <span class="required">*</span></label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label for="age">Age <span class="required">*</span></label>
                    <input type="number" id="age" name="age" min="1" max="120" value="<?php echo ($age ?? 0) > 0 ? $age : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label>Gender <span class="required">*</span></label>
                    <div class="radio-group">
                        <div class="radio-item">
                            <input type="radio" id="male" name="gender" value="male" <?php echo (($gender ?? '') === 'male') ? 'checked' : ''; ?> required>
                            <label for="male">Male</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="female" name="gender" value="female" <?php echo (($gender ?? '') === 'female') ? 'checked' : ''; ?> required>
                            <label for="female">Female</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="other" name="gender" value="other" <?php echo (($gender ?? '') === 'other') ? 'checked' : ''; ?> required>
                            <label for="other">Other</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password <span class="required">*</span></label>
                    <input type="password" id="password" name="password" minlength="6" required>
                </div>

                <div class="form-group">
                    <label for="course_id">Register for Course <span class="required">*</span></label>
                    <select id="course_id" name="course_id" required>
                        <option value="">-- Select a Course --</option>
                        <?php foreach ($courses as $course): ?>
                            <option value="<?php echo $course['id']; ?>" <?php echo (($course_id ?? 0) == $course['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($course['course_name']) . ' (' . htmlspecialchars($course['course_code']) . ')'; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn">Register Now</button>
            </form>
        </div>
    </div>
</body>
</html>