<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$error_msg = '';

// Handle Report Submission using PDO Database Transactions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_report'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $location = trim($_POST['location']);
    $incident_date = $_POST['incident_date'];
    $is_anonymous = isset($_POST['is_anonymous']) ? 1 : 0;

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("INSERT INTO incidents_reports (user_id, title, description, location, incident_date, is_anonymous) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $title, $description, $location, $incident_date, $is_anonymous]);

        $pdo->commit();
        header("Location: dashboard.php?msg=submitted");
        exit();
    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        $error_msg = "Transaction failed: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Report - SpeakSafe 🌸</title>
    <link rel="stylesheet" href="assets/css/styles.php">
    <!-- Flatpickr CSS Theme -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .submit-card {
            background: var(--card-bg);
            backdrop-filter: blur(8px);
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0 8px 20px rgba(216, 112, 147, 0.12);
            border: 1px solid rgba(243, 193, 207, 0.6);
            margin-top: 20px;
        }

        .btn-cancel {
            display: inline-block;
            background-color: var(--branch-brown);
            color: white !important;
            padding: 10px 22px;
            border-radius: 10px;
            font-weight: bold;
            text-decoration: none !important;
            transition: opacity 0.3s ease;
        }

        .btn-cancel:hover {
            opacity: 0.9;
        }

        /* Custom Flatpickr Pink & Sage Green Theme */
        .flatpickr-calendar {
            border-radius: 16px !important;
            box-shadow: 0 10px 25px rgba(216, 112, 147, 0.25) !important;
            border: 1px solid #f3c1cf !important;
            font-family: inherit !important;
        }
        .flatpickr-day.selected, .flatpickr-day.startRange, .flatpickr-day.endRange {
            background: #d87093 !important;
            border-color: #d87093 !important;
        }
        .flatpickr-day:hover {
            background: #fce4ec !important;
        }
        .flatpickr-months .flatpickr-month, .flatpickr-weekdays {
            background: #fce4ec !important;
            color: #4a3e3d !important;
        }
        .flatpickr-time {
            background: #e8f5e9 !important;
            border-top: 1px solid #c8e6c9 !important;
            border-radius: 0 0 16px 16px !important;
        }
        .flatpickr-time input:hover, .flatpickr-time input:focus, .flatpickr-time .flatpickr-am-pm:hover {
            background: #c8e6c9 !important;
            color: #3e6d41 !important;
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
            <h2>Submit an Incident Report</h2>
        </div>
        <a href="dashboard.php" class="btn-cancel">← Back to Dashboard</a>
    </div>

    <?php if(!empty($error_msg)): ?>
        <div class="msg-error"><?php echo htmlspecialchars($error_msg); ?></div>
    <?php endif; ?>

    <!-- Submit Form Card -->
    <div class="submit-card">
        <h3 style="margin-top: 0; margin-bottom: 20px; color: var(--text-dark); font-size: 1.3rem; border-bottom: 2px solid #fce4ec; padding-bottom: 10px;">
            Submit a New Incident Report 🌿
        </h3>
        <form method="POST" action="" class="report-form">
            <div class="form-group">
                <label for="title">Incident Title</label>
                <input type="text" id="title" name="title" class="form-control" placeholder="Brief title describing the incident" required>
            </div>

            <div class="form-group">
                <label for="description">Incident Description</label>
                <textarea id="description" name="description" class="form-control" placeholder="Provide details of what happened..." rows="5" required></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="location">Location of Incident</label>
                    <input type="text" id="location" name="location" class="form-control" placeholder="e.g. Building A, 2nd Floor, Canteen" required>
                </div>

                <div class="form-group">
                    <label for="incident_date">Date & Time</label>
                    <input type="text" id="incident_date" name="incident_date" class="form-control" placeholder="Select date and time..." required>
                </div>
            </div>

            <label class="checkbox-card">
                <input type="checkbox" name="is_anonymous" value="1">
                <span>Check this box to hide my Name and Gmail (Submit Anonymously)</span>
            </label>

            <button type="submit" name="submit_report" class="btn-submit">Submit Report</button>
        </form>
    </div>

</div>

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("#incident_date", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        defaultHour: 12
    });
</script>
</body>
</html>