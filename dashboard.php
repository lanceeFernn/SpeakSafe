<?php
require_once 'config/db.php';
require_once 'config/session.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['role'] ?? 'student';
$success_msg = '';
$error_msg = '';

if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'submitted') {
        $success_msg = "Incident report submitted successfully!";
    } elseif ($_GET['msg'] === 'updated') {
        $success_msg = "Incident report updated successfully!";
    }
}

// Handle Delete Report with Database Transactions
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    try {
        $pdo->beginTransaction();

        if ($user_role === 'admin' || $user_role === 'council') {
            $stmt = $pdo->prepare("DELETE FROM incidents_reports WHERE report_id = ?");
            $stmt->execute([$delete_id]);
        } else {
            $stmt = $pdo->prepare("DELETE FROM incidents_reports WHERE report_id = ? AND user_id = ?");
            $stmt->execute([$delete_id, $user_id]);
        }

        $pdo->commit();
        header("Location: dashboard.php");
        exit();
    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        $error_msg = "Delete transaction failed!";
    }
}

// Fetch Reports (Role-Based Query)
if ($user_role === 'admin' || $user_role === 'council') {
    // Admins and Council can see all reports across the system
    $query = "SELECT r.*, u.first_name, u.last_name, u.email FROM incidents_reports r JOIN users u ON r.user_id = u.user_id ORDER BY r.created_at DESC";
    $stmt = $pdo->query($query);
} else {
    // Regular students ONLY see their own submitted reports
    $query = "SELECT r.*, u.first_name, u.last_name, u.email FROM incidents_reports r JOIN users u ON r.user_id = u.user_id WHERE r.user_id = ? ORDER BY r.created_at DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$user_id]);
}

$reports = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SpeakSafe 🌸</title>
    <link rel="stylesheet" href="assets/css/styles.php">
    <style>
        .report-title-link {
            color: #d87093;
            font-weight: 700;
            text-decoration: none;
            transition: color 0.2s ease;
        }
        .report-title-link:hover {
            color: #c2597d;
            text-decoration: underline;
        }
        .btn-edit {
            background-color: var(--accent-green) !important;
            color: white !important;
            padding: 8px 12px !important;
            border-radius: 8px !important;
            font-size: 0.85rem !important;
            font-weight: bold !important;
            text-decoration: none !important;
            display: inline-block;
            margin-right: 4px;
        }
        .btn-create-report {
            background-color: var(--accent-green) !important;
            color: white !important;
            padding: 10px 18px !important;
            border-radius: 10px !important;
            font-weight: bold !important;
            text-decoration: none !important;
            display: inline-block;
            box-shadow: 0 4px 12px rgba(78, 135, 82, 0.25);
            transition: background 0.3s ease;
            margin-right: 10px;
        }
        .btn-create-report:hover {
            background-color: var(--accent-green-hover) !important;
        }
        .header-actions {
            display: flex;
            align-items: center;
        }
        .action-cell {
            white-space: nowrap;
        }
    </style>
</head>
<body>

<div class="dashboard-container">

    <!-- Header Section -->
    <div class="header-card">
        <div>
            <div style="font-size: 1.3rem; font-weight: 800; color: #d87093; letter-spacing: 0.5px; margin-bottom: 4px;">
                SpeakSafe 🌸
            </div>
            <h2>Welcome, <?php echo htmlspecialchars($_SESSION['first_name']); ?>!</h2>
        </div>
        <div class="header-actions">
            <a href="submit_report.php" class="btn-create-report">+ Submit New Report 🌿</a>
            <a href="auth/logout.php" class="btn-logout">Logout</a>
        </div>
    </div>

    <?php if(!empty($success_msg)): ?>
        <div class="msg-success"><?php echo htmlspecialchars($success_msg); ?></div>
    <?php endif; ?>

    <?php if(!empty($error_msg)): ?>
        <div class="msg-error"><?php echo htmlspecialchars($error_msg); ?></div>
    <?php endif; ?>

    <!-- Reports Table Section -->
    <div class="card">
        <h3>Manage & Track Incident Reports 🌸</h3>
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th style="width: 8%;">Report ID</th>
                        <th style="width: 15%;">Reporter Name</th>
                        <th style="width: 18%;">Gmail Account</th>
                        <th style="width: 25%;">Incident Title</th>
                        <th style="width: 18%;">Location & Date</th>
                        <th style="width: 10%;">Status</th>
                        <th style="width: 10%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($reports) > 0): ?>
                        <?php foreach ($reports as $row): ?>
                        <tr>
                            <td><strong>#<?php echo $row['report_id']; ?></strong></td>
                            <td>
                                <?php 
                                if ($row['is_anonymous'] == 1) {
                                    echo "<span class='badge-anonymous'>Anonymous</span>";
                                } else {
                                    echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']);
                                }
                                ?>
                            </td>
                            <td>
                                <?php 
                                if ($row['is_anonymous'] == 1) {
                                    echo "<span class='badge-anonymous'>Hidden (Anonymous)</span>";
                                } else {
                                    echo htmlspecialchars($row['email']);
                                }
                                ?>
                            </td>
                            <td>
                                <a href="view_report.php?id=<?php echo $row['report_id']; ?>" class="report-title-link">
                                    <?php echo htmlspecialchars($row['title']); ?>
                                </a>
                            </td>
                            <td>
                                <strong><?php echo htmlspecialchars($row['location']); ?></strong><br>
                                <small style="color: #888;"><?php echo date("M d, Y h:i A", strtotime($row['incident_date'])); ?></small>
                            </td>
                            <td><span class="badge-status"><?php echo htmlspecialchars($row['status']); ?></span></td>
                            <td class="action-cell">
                                <?php if ($user_role === 'admin' || $user_role === 'council' || $row['user_id'] == $user_id): ?>
                                    <a href="edit_report.php?id=<?php echo $row['report_id']; ?>" class="btn-edit">Edit</a>
                                    <a href="dashboard.php?delete_id=<?php echo $row['report_id']; ?>" onclick="return confirm('Are you sure you want to delete this report?');">
                                        <button class="btn-delete" type="button">Delete</button>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align:center; color: #888; padding: 30px;">
                                No reports found for this account.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

</body>
</html>