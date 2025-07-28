<?php
include 'config.php';

// Handle search
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$searchQuery = "";
if (!empty($searchTerm)) {
    $searchQuery = " WHERE name LIKE '%$searchTerm%' OR email LIKE '%$searchTerm%' OR course LIKE '%$searchTerm%'";
}

// Fetch data from database
$sql = "SELECT * FROM contacts" . $searchQuery . " ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form System</title>
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
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        
        .content {
            padding: 40px;
        }
        
        .form-section {
            background: #f8fafc;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 40px;
        }
        
        .form-section h2 {
            color: #1e293b;
            margin-bottom: 20px;
            font-size: 1.5rem;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
        }
        
        .form-group label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }
        
        .form-group input,
        .form-group select {
            padding: 12px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }
        
        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }
        
        .btn {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease;
        }
        
        .btn:hover {
            transform: translateY(-2px);
        }
        
        .search-section {
            margin-bottom: 30px;
        }
        
        .search-form {
            display: flex;
            gap: 15px;
            align-items: end;
        }
        
        .search-input {
            flex: 1;
        }
        
        .data-section h2 {
            color: #1e293b;
            margin-bottom: 20px;
            font-size: 1.5rem;
        }
        
        .table-container {
            overflow-x: auto;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }
        
        th {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 600;
        }
        
        td {
            padding: 15px;
            border-bottom: 1px solid #e5e7eb;
        }
        
        tr:hover {
            background-color: #f8fafc;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: #6b7280;
            font-style: italic;
        }
        
        .success-message {
            background: #10b981;
            color: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .error-message {
            background: #ef4444;
            color: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .search-form {
                flex-direction: column;
                align-items: stretch;
            }
            
            .header h1 {
                font-size: 2rem;
            }
            
            .content {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Contact Management System</h1>
            <p>Add, View, and Search Contact Information</p>
        </div>
        
        <div class="content">
            <!-- Success/Error Messages -->
            <?php
            if (isset($_GET['success'])) {
                echo '<div class="success-message">Contact added successfully!</div>';
            }
            if (isset($_GET['error'])) {
                echo '<div class="error-message">Error: ' . htmlspecialchars($_GET['error']) . '</div>';
            }
            ?>
            
            <!-- Contact Form Section -->
            <div class="form-section">
                <h2>Add New Contact</h2>
                <form action="insert.php" method="POST">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" id="name" name="name" required placeholder="Enter full name">
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" required placeholder="Enter email address">
                        </div>
                        
                        <div class="form-group">
                            <label for="age">Age</label>
                            <input type="number" id="age" name="age" required min="1" max="120" placeholder="Enter age">
                        </div>
                        
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select id="gender" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        
                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label for="course">Register Course</label>
                            <select id="course" name="course" required>
                                <option value="">Select a Course</option>
                                <option value="Computer Science">Computer Science</option>
                                <option value="Information Technology">Information Technology</option>
                                <option value="Software Engineering">Software Engineering</option>
                                <option value="Data Science">Data Science</option>
                                <option value="Cybersecurity">Cybersecurity</option>
                                <option value="Web Development">Web Development</option>
                                <option value="Mobile App Development">Mobile App Development</option>
                                <option value="Database Administration">Database Administration</option>
                                <option value="Network Administration">Network Administration</option>
                                <option value="Business Administration">Business Administration</option>
                                <option value="Digital Marketing">Digital Marketing</option>
                                <option value="Graphic Design">Graphic Design</option>
                                <option value="Engineering">Engineering</option>
                                <option value="Mathematics">Mathematics</option>
                                <option value="Physics">Physics</option>
                            </select>
                        </div>
                    </div>
                    
                    <div style="margin-top: 25px;">
                        <button type="submit" class="btn">Add Contact</button>
                    </div>
                </form>
            </div>
            
            <!-- Search Section -->
            <div class="search-section">
                <h2>Search Contacts</h2>
                <form method="GET" class="search-form">
                    <div class="form-group search-input">
                        <label for="search">Search by Name, Email, or Course</label>
                        <input type="text" id="search" name="search" value="<?php echo htmlspecialchars($searchTerm); ?>" placeholder="Enter search term...">
                    </div>
                    <button type="submit" class="btn">Search</button>
                    <?php if (!empty($searchTerm)): ?>
                        <a href="index.php" class="btn" style="text-decoration: none; background: #6b7280;">Clear</a>
                    <?php endif; ?>
                </form>
            </div>
            
            <!-- Data Display Section -->
            <div class="data-section">
                <h2>Contact Records
                    <?php if (!empty($searchTerm)): ?>
                        <span style="font-size: 1rem; color: #6b7280;">- Search results for "<?php echo htmlspecialchars($searchTerm); ?>"</span>
                    <?php endif; ?>
                </h2>
                
                <div class="table-container">
                    <?php if ($result && $result->num_rows > 0): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Age</th>
                                    <th>Gender</th>
                                    <th>Course</th>
                                    <th>Date Added</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo $row['age']; ?></td>
                                    <td><?php echo $row['gender']; ?></td>
                                    <td><?php echo htmlspecialchars($row['course']); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="no-data">
                            <?php if (!empty($searchTerm)): ?>
                                No contacts found matching your search criteria.
                            <?php else: ?>
                                No contacts found. Add some contacts to get started!
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>