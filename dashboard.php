<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "simple_login");

// --- Handle Status Update ---
if (isset($_GET['action']) && $_GET['action'] == 'resolve' && isset($_GET['id'])) {
    $report_id = (int)$_GET['id'];
    mysqli_query($conn, "UPDATE reports SET status = 'Resolved' WHERE id = $report_id");
    header('Location: dashboard.php'); 
    exit();
}

// Fetch counts
$total_res = mysqli_query($conn, "SELECT COUNT(*) as count FROM reports");
$total = mysqli_fetch_assoc($total_res)['count'];

$emergency_res = mysqli_query($conn, "SELECT COUNT(*) as count FROM reports WHERE concern_type IN ('Medical Emergency', 'Fire Incident')");
$emergency = mysqli_fetch_assoc($emergency_res)['count'];

$pending_res = mysqli_query($conn, "SELECT COUNT(*) as count FROM reports WHERE status = 'Pending'");
$pending = mysqli_fetch_assoc($pending_res)['count'];

// Fetch reports
$reports = mysqli_query($conn, "SELECT * FROM reports ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Sumbong Alalay</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Table Row Hover Feature */
        tr {
            position: relative;
            transition: background 0.2s;
        }

        tr:hover {
            background-color: #f0f7ff !important;
        }

       
        .full-info-card {
            visibility: hidden;
            width: 350px;
            background-color: #271111; 
            color: #fff;
            text-align: left;
            border-radius: 12px;
            padding: 20px;
            position: absolute;
            z-index: 999;
            left: 50%;
            transform: translateX(-50%) translateY(-20px);
            opacity: 0;
            transition: opacity 0.3s, transform 0.3s;
            white-space: normal;
            font-size: 0.95rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.4);
            border: 1px solid #374151;
            pointer-events: none;
        }

     
        tr:hover .full-info-card {
            visibility: visible;
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }

   
        .info-header { color: #ef4444; font-weight: bold; text-transform: uppercase; font-size: 0.75rem; margin-bottom: 5px; display: block; }
        .info-val { display: block; margin-bottom: 12px; line-height: 1.4; color: #e5e7eb; }
        .info-divider { border: 0; border-top: 1px solid #374151; margin: 10px 0; }

      
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 15px; background: #f8fafc; border-bottom: 2px solid #e2e8f0; color: #64748b; font-size: 0.85rem; }
        td { padding: 15px; border-bottom: 1px solid #e2e8f0; position: relative; }

       
        .truncate {
            max-width: 150px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: inline-block;
        }

   
        .status-toggle {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 1px solid transparent;
            position: relative;
            z-index: 1000; /
        }

        .status-pending { background-color: #fef3c7; color: #92400e; border-color: #f59e0b; }
        .status-pending:hover { background-color: #10b981; color: white; border-color: #059669; }
        .status-resolved { background-color: #d1fae5; color: #065f46; border-color: #34d399; cursor: default; }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="header-content">
                <a href="index.php" class="logo">
                    <div class="logo-text"><h1><span class="brand-red">Sumbong</span> Alalay</h1></div>
                </a>
                <a href="login.php" class="btn btn-outline">Logout</a>
            </div>
        </div>
    </header>

    <section style="padding: 3rem 0; background: #f9fafb; min-height: 100vh;">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-box total"><h3>Total Reports</h3><div class="stat-value"><?php echo $total; ?></div></div>
                <div class="stat-box emergency"><h3>Emergencies</h3><div class="stat-value"><?php echo $emergency; ?></div></div>
                <div class="stat-box pending"><h3>Pending</h3><div class="stat-value"><?php echo $pending; ?></div></div>
            </div>

            <div class="table-card" style="background: white; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); overflow: visible; margin-top: 2rem;">
                <table>
                    <thead>
                        <tr>
                            <th>Reporter</th>
                            <th>Location</th>
                            <th>Concern Preview</th>
                            <th>Status</th>
                            <th>Date Submitted</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(mysqli_num_rows($reports) > 0): ?>
                            <?php while($row = mysqli_fetch_assoc($reports)): ?>
                            <tr>
                                <td>
                                    <div class="full-info-card">
                                        <span class="info-header">Full Name & Age</span>
                                        <span class="info-val"><?php echo htmlspecialchars($row['reporter_name']); ?> (<?php echo $row['age']; ?> years old)</span>
                                        
                                        <hr class="info-divider">
                                        
                                        <span class="info-header">Incident Location</span>
                                        <span class="info-val"><?php echo htmlspecialchars($row['location']); ?></span>
                                        
                                        <hr class="info-divider">
                                        
                                        <span class="info-header">Complete Complaint Detail</span>
                                        <span class="info-val" style="color: #60a5fa; font-weight: 500;">
                                            <?php echo nl2br(htmlspecialchars($row['concern_type'])); ?>
                                        </span>
                                        
                                        <hr class="info-divider">
                                        <small style="color: #9ca3af;">Sent on: <?php echo date('F j, Y, g:i a', strtotime($row['created_at'])); ?></small>
                                    </div>

                                    <strong><?php echo htmlspecialchars($row['reporter_name']); ?></strong>
                                </td>
                                <td><?php echo htmlspecialchars($row['location']); ?></td>
                                <td><span class="truncate"><?php echo htmlspecialchars($row['concern_type']); ?></span></td>
                                <td>
                                    <?php if($row['status'] == 'Pending'): ?>
                                        <a href="dashboard.php?action=resolve&id=<?php echo $row['id']; ?>" class="status-toggle status-pending">
                                            Pending
                                        </a>
                                    <?php else: ?>
                                        <span class="status-toggle status-resolved">Resolved</span>
                                    <?php endif; ?>
                                </td>
                                <td><small><?php echo date('M d, Y', strtotime($row['created_at'])); ?></small></td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="5" style="text-align:center; padding: 50px; color: #94a3b8;">No reports to display.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</body>
</html>