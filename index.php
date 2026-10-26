<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - SpeakSafe 🌸</title>
    <link rel="stylesheet" href="assets/css/styles.php">
    <style>
        /* Landing Page Specific Button Overrides */
        .landing-btn-pink {
            display: block;
            width: 100%;
            box-sizing: border-box;
            padding: 12px;
            background-color: var(--primary-pink) !important;
            color: white !important;
            text-decoration: none !important;
            border-radius: 10px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 12px;
            box-shadow: 0 4px 12px rgba(216, 112, 147, 0.3);
            transition: background 0.3s ease;
        }
        .landing-btn-pink:hover {
            background-color: var(--primary-hover) !important;
        }

        .landing-btn-green {
            display: block;
            width: 100%;
            box-sizing: border-box;
            padding: 12px;
            background-color: var(--accent-green) !important;
            color: white !important;
            text-decoration: none !important;
            border-radius: 10px;
            font-weight: bold;
            text-align: center;
            box-shadow: 0 4px 12px rgba(78, 135, 82, 0.25);
            transition: background 0.3s ease;
        }
        .landing-btn-green:hover {
            background-color: var(--accent-green-hover) !important;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <h2>Welcome to SpeakSafe 🌸</h2>
        <div class="subtitle">Campus Safe Report & Incident Management System</div>
        <br>
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="dashboard.php" class="landing-btn-green">Go to Dashboard</a>
            <a href="auth/logout.php" class="landing-btn-pink" style="background-color: var(--danger-red) !important;">Logout</a>
        <?php else: ?>
            <a href="auth/login.php" class="landing-btn-pink">Login</a>
            <a href="auth/register.php" class="landing-btn-green">Register Account</a>
        <?php endif; ?>
    </div>
</body>
</html>