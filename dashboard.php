<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "simple_login");

// Fetch counts for the stats boxes
$total_res = mysqli_query($conn, "SELECT COUNT(*) as count FROM reports");
$total = mysqli_fetch_assoc($total_res)['count'];

$emergency_res = mysqli_query($conn, "SELECT COUNT(*) as count FROM reports WHERE concern_type IN ('Medical Emergency', 'Fire Incident')");
$emergency = mysqli_fetch_assoc($emergency_res)['count'];

$pending_res = mysqli_query($conn, "SELECT COUNT(*) as count FROM reports WHERE status = 'Pending'");
$pending = mysqli_fetch_assoc($pending_res)['count'];

// Fetch all reports
$reports = mysqli_query($conn, "SELECT * FROM reports ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Sumbong Alalay</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="header-content">
                <a href="index.php" class="logo">
                    <div class="logo-text"><h1><span class="brand-red">Sumbong</span> Alalay</h1></div>
                </a>
                <a href="logout.php" class="btn btn-outline">Logout</a>
            </div>
        </div>
    </header>

    <section style="padding: 3rem 0; background: #f9fafb; min-height: 100vh;">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-box total"><h3>Total</h3><div class="stat-value"><?php echo $total; ?></div></div>
                <div class="stat-box emergency"><h3>Emergencies</h3><div class="stat-value"><?php echo $emergency; ?></div></div>
                <div class="stat-box pending"><h3>Pending</h3><div class="stat-value"><?php echo $pending; ?></div></div>
            </div>

            <div class="table-card">
                <table>
                    <thead>
                        <tr>
                            <th>Reporter</th>
                            <th>Location</th>
                            <th>Concern</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(mysqli_num_rows($reports) > 0): ?>
                            <?php while($row = mysqli_fetch_assoc($reports)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['reporter_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['location']); ?></td>
                                <td><?php echo htmlspecialchars($row['concern_type']); ?></td>
                                <td><?php echo $row['status']; ?></td>
                                <td><?php echo $row['created_at']; ?></td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="5" style="text-align:center;">No reports found</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</body>
</html>