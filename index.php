<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'contact_db');
if ($conn->connect_error) {
    die('Connection Failed : ' . $conn->connect_error);
}

// Handle search
$search = '';
if (isset($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $sql = "SELECT * FROM contacts WHERE name LIKE '%$search%' OR email LIKE '%$search%' OR course LIKE '%$search%'";
} else {
    $sql = "SELECT * FROM contacts";
}
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Form</title>
    <style>
        table, th, td { border: 1px solid black; border-collapse: collapse; }
        th, td { padding: 8px; }
    </style>
</head>
<body>
    <h2>Contact Form</h2>
    <form action="insert.php" method="post">
        <label>Name: <input type="text" name="name" required></label><br><br>
        <label>Email: <input type="email" name="email" required></label><br><br>
        <label>Age: <input type="number" name="age" min="1" required></label><br><br>
        <label>Gender:
            <select name="gender" required>
                <option value="">Select</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
        </label><br><br>
        <label>Register Course:
            <select name="course" required>
                <option value="">Select</option>
                <option value="Math">Math</option>
                <option value="Science">Science</option>
                <option value="History">History</option>
                <option value="Programming">Programming</option>
            </select>
        </label><br><br>
        <button type="submit">Submit</button>
    </form>
    <br>
    <h3>Search Contacts</h3>
    <form method="get" action="">
        <input type="text" name="search" placeholder="Search by name, email, or course" value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Search</button>
    </form>
    <br>
    <h3>Contact List</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Course</th>
        </tr>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['age']); ?></td>
                    <td><?php echo htmlspecialchars($row['gender']); ?></td>
                    <td><?php echo htmlspecialchars($row['course']); ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="6">No data found</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>
<?php $conn->close(); ?>