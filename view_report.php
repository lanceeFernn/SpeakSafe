<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$report_id = $_GET['id'];
$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['role'] ?? 'student';

// Fetch specific report details
$stmt = $pdo->prepare("SELECT r.*, u.first_name, u.last_name, u.email FROM incidents_reports r JOIN users u ON r.user_id = u.user_id WHERE r.report_id = ?");
$stmt->execute([$report_id]);
$report = $stmt->fetch();

if (!$report) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Report #<?php echo $report['report_id']; ?> - SpeakSafe 🌸</title>
    <link rel="stylesheet" href="assets/css/styles.php">
    <style>
        .report-detail-card {
            background: var(--card-bg);
            backdrop-filter: blur(8px);
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0 8px 20px rgba(216, 112, 147, 0.12);
            border: 1px solid rgba(243, 193, 207, 0.6);
            margin-top: 20px;
        }

        .report-meta-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 2px dashed #fce4ec;
        }

        .meta-item label {
            display: block;
            font-size: 0.85rem;
            color: var(--accent-green);
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .meta-item span {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .description-box {
            background: #fffcfd;
            border: 1.5px solid var(--input-border);
            border-radius: 12px;
            padding: 20px;
            font-size: 1rem;
            line-height: 1.6;
            color: var(--text-dark);
            white-space: pre-wrap;
            margin-top: 10px;
        }

        .btn-back {
            display: inline-block;
            background-color: var(--accent-green);
            color: white !important;
            padding: 10px 22px;
            border-radius: 10px;
            font-weight: bold;
            text-decoration: none !important;
            box-shadow: 0 4px 12px rgba(78, 135, 82, 0.25);
            transition: background 0.3s ease;
        }

        .btn-back:hover {
            background-color: var(--accent-green-hover);
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
            <h2>Incident Report Details #<?php echo $report['report_id']; ?></h2>
        </div>
        <a href="dashboard.php" class="btn-back">← Back to Dashboard</a>
    </div>

    <!-- Details Card -->
    <div class="report-detail-card">
        <h2 style="margin-top:0; color: var(--text-dark); font-size: 1.6rem; border-bottom: 2px solid #fce4ec; padding-bottom: 12px;">
            <?php echo htmlspecialchars($report['title']); ?>
        </h2>

        <div class="report-meta-grid">
            <div class="meta-item">
                <label>Reporter Name</label>
                <span>
                    <?php 
                    if ($report['is_anonymous'] == 1) {
                        echo "<span class='badge-anonymous'>Anonymous</span>";
                    } else {
                        echo htmlspecialchars($report['first_name'] . ' ' . $report['last_name']);
                    }
                    ?>
                </span>
            </div>

            <div class="meta-item">
                <label>Gmail Account</label>
                <span>
                    <?php 
                    if ($report['is_anonymous'] == 1) {
                        echo "<span class='badge-anonymous'>Hidden (Anonymous)</span>";
                    } else {
                        echo htmlspecialchars($report['email']);
                    }
                    ?>
                </span>
            </div>

            <div class="meta-item">
                <label>Location</label>
                <span><?php echo htmlspecialchars($report['location']); ?></span>
            </div>

            <div class="meta-item">
                <label>Date & Time</label>
                <span><?php echo date("M d, Y h:i A", strtotime($report['incident_date'])); ?></span>
            </div>

            <div class="meta-item">
                <label>Status</label>
                <span><span class="badge-status"><?php echo htmlspecialchars($report['status']); ?></span></span>
            </div>
        </div>

        <label style="font-weight: bold; font-size: 0.95rem; color: var(--text-dark);">Full Incident Message Description:</label>
        <div class="description-box">
            <?php echo htmlspecialchars($report['description']); ?>
        </div>
    </div>

</div>

</body>
</html>