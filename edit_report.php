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
$error_msg = '';

// Fetch the existing report
if ($user_role === 'admin' || $user_role === 'council') {
    $stmt = $pdo->prepare("SELECT * FROM incidents_reports WHERE report_id = ?");
    $stmt->execute([$report_id]);
} else {
    $stmt = $pdo->prepare("SELECT * FROM incidents_reports WHERE report_id = ? AND user_id = ?");
    $stmt->execute([$report_id, $user_id]);
}

$report = $stmt->fetch();

if (!$report) {
    header("Location: dashboard.php");
    exit();
}

// Handle Update via PDO Transaction
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_report'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $location = trim($_POST['location']);
    $incident_date = $_POST['incident_date'];
    $is_anonymous = isset($_POST['is_anonymous']) ? 1 : 0;

    try {
        $pdo->beginTransaction();

        $update_stmt = $pdo->prepare("UPDATE incidents_reports SET title = ?, description = ?, location = ?, incident_date = ?, is_anonymous = ? WHERE report_id = ?");
        $update_stmt->execute([$title, $description, $location, $incident_date, $is_anonymous, $report_id]);

        $pdo->commit();
        header("Location: dashboard.php?msg=updated");
        exit();
    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        $error_msg = "Update transaction failed: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Report #<?php echo $report['report_id']; ?> - SpeakSafe 🌸</title>
    <link rel="stylesheet" href="assets/css/styles.php">
    <!-- Flatpickr CSS Theme -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .edit-card {
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
            <h2>Edit Incident Report #<?php echo $report['report_id']; ?></h2>
        </div>
        <a href="dashboard.php" class="btn-cancel">Cancel</a>
    </div>

    <?php if(!empty($error_msg)): ?>
        <div class="msg-error"><?php echo htmlspecialchars($error_msg); ?></div>
    <?php endif; ?>

    <!-- Edit Form Card -->
    <div class="edit-card">
        <h3>Update Incident Details 🌿</h3>
        <form method="POST" action="" class="report-form">
            <div class="form-group">
                <label for="title">Incident Title</label>
                <input type="text" id="title" name="title" class="form-control" value="<?php echo htmlspecialchars($report['title']); ?>" required>
            </div>

            <div class="form-group">
                <label for="description">Incident Description</label>
                <textarea id="description" name="description" class="form-control" rows="5" required><?php echo htmlspecialchars($report['description']); ?></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="location">Location of Incident</label>
                    <input type="text" id="location" name="location" class="form-control" value="<?php echo htmlspecialchars($report['location']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="incident_date">Date & Time</label>
                    <input type="text" id="incident_date" name="incident_date" class="form-control" value="<?php echo htmlspecialchars($report['incident_date']); ?>" required>
                </div>
            </div>

            <label class="checkbox-card">
                <input type="checkbox" name="is_anonymous" value="1" <?php echo $report['is_anonymous'] == 1 ? 'checked' : ''; ?>>
                <span>Check this box to hide my Name and Gmail (Submit Anonymously)</span>
            </label>

            <button type="submit" name="update_report" class="btn-submit">Save Changes</button>
        </form>
    </div>

</div>

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("#incident_date", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        defaultDate: "<?php echo $report['incident_date']; ?>"
    });
</script>
</body>
</html>