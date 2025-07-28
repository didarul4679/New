<?php
// Database connection settings
$host = 'localhost';
$db = 'contact_db';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$name = $email = $age = $gender = $password = $course = '';
$email_err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $age = $_POST['age'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $password = $_POST['password'] ?? '';
    $course = $_POST['course'] ?? '';

    if (empty($email)) {
        $email_err = 'Email is required.';
    } else {
        $stmt = $conn->prepare('INSERT INTO contacts (name, email, age, gender, password, course) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('ssisss', $name, $email, $age, $gender, $password, $course);
        $stmt->execute();
        $stmt->close();
        echo '<p>Form submitted successfully!</p>';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Contact Form</title>
</head>
<body>
    <h2>Contact Form</h2>
    <form method="post" action="">
        <label>Name:</label><br>
        <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>"><br><br>
        <label>Email: <span style="color:red;">*</span></label><br>
        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br>
        <span style="color:red;"><?php echo $email_err; ?></span><br><br>
        <label>Age:</label><br>
        <input type="number" name="age" value="<?php echo htmlspecialchars($age); ?>"><br><br>
        <label>Gender:</label><br>
        <select name="gender">
            <option value="">Select</option>
            <option value="Male" <?php if($gender=='Male') echo 'selected'; ?>>Male</option>
            <option value="Female" <?php if($gender=='Female') echo 'selected'; ?>>Female</option>
            <option value="Other" <?php if($gender=='Other') echo 'selected'; ?>>Other</option>
        </select><br><br>
        <label>Password:</label><br>
        <input type="password" name="password"><br><br>
        <label>Register Course:</label><br>
        <select name="course">
            <option value="">Select a course</option>
            <option value="PHP" <?php if($course=='PHP') echo 'selected'; ?>>PHP</option>
            <option value="Python" <?php if($course=='Python') echo 'selected'; ?>>Python</option>
            <option value="JavaScript" <?php if($course=='JavaScript') echo 'selected'; ?>>JavaScript</option>
            <option value="Java" <?php if($course=='Java') echo 'selected'; ?>>Java</option>
        </select><br><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>