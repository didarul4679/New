<?php
require_once 'config.php';

// Get all registrations with course details
function getAllRegistrations() {
    $pdo = getConnection();
    $stmt = $pdo->query("
        SELECT 
            c.id,
            c.name,
            c.email,
            c.age,
            c.gender,
            co.course_name,
            co.course_code,
            c.created_at
        FROM contacts c
        JOIN courses co ON c.course_id = co.id
        ORDER BY c.created_at DESC
    ");
    return $stmt->fetchAll();
}

$registrations = getAllRegistrations();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Registrations</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 32px;
            margin-bottom: 10px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .stat-number {
            font-size: 36px;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #666;
            font-size: 14px;
        }

        .table-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f8f9fa;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #e1e1e1;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #e1e1e1;
        }

        tr:hover {
            background: #f8f9fa;
        }

        .gender-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
        }

        .gender-male {
            background: #e3f2fd;
            color: #1976d2;
        }

        .gender-female {
            background: #fce4ec;
            color: #c2185b;
        }

        .gender-other {
            background: #f3e5f5;
            color: #7b1fa2;
        }

        .course-badge {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 500;
        }

        .no-data {
            text-align: center;
            padding: 50px;
            color: #666;
        }

        .back-btn {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            margin-bottom: 20px;
            transition: transform 0.2s ease;
        }

        .back-btn:hover {
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .table-container {
                overflow-x: auto;
            }
            
            table {
                min-width: 800px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="index.php" class="back-btn">← Back to Registration Form</a>
        
        <div class="header">
            <h1>Course Registrations</h1>
            <p>View all student registrations and course enrollments</p>
        </div>

        <div class="stats">
            <div class="stat-card">
                <div class="stat-number"><?php echo count($registrations); ?></div>
                <div class="stat-label">Total Registrations</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo count(array_unique(array_column($registrations, 'course_name'))); ?></div>
                <div class="stat-label">Active Courses</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo count(array_filter($registrations, function($r) { return $r['gender'] === 'male'; })); ?></div>
                <div class="stat-label">Male Students</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo count(array_filter($registrations, function($r) { return $r['gender'] === 'female'; })); ?></div>
                <div class="stat-label">Female Students</div>
            </div>
        </div>

        <div class="table-container">
            <?php if (empty($registrations)): ?>
                <div class="no-data">
                    <h3>No registrations found</h3>
                    <p>No students have registered yet.</p>
                </div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Course</th>
                            <th>Registration Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($registrations as $registration): ?>
                            <tr>
                                <td><?php echo $registration['id']; ?></td>
                                <td><?php echo htmlspecialchars($registration['name']); ?></td>
                                <td><?php echo htmlspecialchars($registration['email']); ?></td>
                                <td><?php echo $registration['age']; ?></td>
                                <td>
                                    <span class="gender-badge gender-<?php echo $registration['gender']; ?>">
                                        <?php echo ucfirst($registration['gender']); ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="course-badge">
                                        <?php echo htmlspecialchars($registration['course_name']) . ' (' . htmlspecialchars($registration['course_code']) . ')'; ?>
                                    </span>
                                </td>
                                <td><?php echo date('M j, Y g:i A', strtotime($registration['created_at'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>