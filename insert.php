<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'contact_db');
if ($conn->connect_error) {
    die('Connection Failed : ' . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $age = (int)$_POST['age'];
    $gender = $conn->real_escape_string($_POST['gender']);
    $course = $conn->real_escape_string($_POST['course']);

    $sql = "INSERT INTO contacts (name, email, age, gender, course) VALUES ('$name', '$email', $age, '$gender', '$course')";
    $conn->query($sql);
}
$conn->close();
header('Location: index.php');
exit();