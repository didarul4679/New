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
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 700px;
            margin: 40px auto;
            background: #fff;
            padding: 30px 40px 40px 40px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        h2, h3 {
            color: #333;
            margin-top: 0;
        }
        form {
            margin-bottom: 30px;
        }
        label {
            display: block;
            margin-bottom: 12px;
            color: #222;
        }
        input[type="text"], input[type="email"], input[type="number"], select {
            width: 100%;
            padding: 8px 10px;
            margin-top: 4px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 15px;
        }
        button[type="submit"], button {
            background: #1976d2;
            color: #fff;
            border: none;
            padding: 10px 22px;
            border-radius: 5px;
            font-size: 15px;
            cursor: pointer;
            transition: background 0.2s;
        }
        button[type="submit"]:hover, button:hover {
            background: #125ea2;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            background: #fafbfc;
        }
        th, td {
            padding: 10px 8px;
            text-align: left;
        }
        th {
            background: #1976d2;
            color: #fff;
        }
        tr:nth-child(even) {
            background: #f1f5fa;
        }
        tr:hover {
            background: #e3eaf6;
        }
        .search-form {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        .search-form input[type="text"] {
            flex: 1;
        }
    </style>
</head>
<body>
    <div class="container">
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
        <form method="get" action="" class="search-form">
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
    </div>
</body>
</html>
<?php $conn->close(); ?>