<?php header("Content-type: text/css; charset: UTF-8"); ?>

/* Warm Floral & Branch Nature Theme Palette */
:root {
    --bg-gradient-start: #fce4ec; /* Soft warm pink */
    --bg-gradient-end: #e8f5e9;   /* Soft sage green */
    --card-bg: rgba(255, 255, 255, 0.95);
    --primary-pink: #d87093;     /* Warm rose pink */
    --primary-hover: #c2597d;
    --accent-green: #4e8752;     /* Earthy sage green */
    --accent-green-hover: #3e6d41;
    --branch-brown: #8d6e63;     /* Warm tree branch brown */
    --text-dark: #4a3e3d;
    --input-border: #f3c1cf;
    --input-focus: #d87093;
    --danger-red: #e57373;
    --danger-hover: #ef5350;
}

body {
    margin: 0;
    padding: 20px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, var(--bg-gradient-start) 0%, var(--bg-gradient-end) 100%);
    min-height: 100vh;
    box-sizing: border-box;
    position: relative;
    color: var(--text-dark);
    display: flex;
    justify-content: center;
    align-items: center;
    overflow-x: hidden;
}

/* Background Tree Branches, Green Leaves, and Pink Blossoms Overlay */
body::before, body::after {
    content: "";
    position: fixed;
    width: 320px;
    height: 320px;
    background-repeat: no-repeat;
    background-size: contain;
    opacity: 0.35;
    pointer-events: none;
    z-index: 1;
}

/* Top-Right Branch */
body::before {
    top: -10px;
    right: -10px;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 120 120'%3E%3Cpath fill='none' stroke='%238d6e63' stroke-width='4' stroke-linecap='round' d='M120,0 Q80,40 40,30 T0,70'/%3E%3Cpath fill='none' stroke='%238d6e63' stroke-width='2.5' stroke-linecap='round' d='M75,20 Q60,10 45,5'/%3E%3Cpath fill='%234e8752' d='M65,25 Q55,15 45,30 Q60,35 65,25 Z'/%3E%3Cpath fill='%234e8752' d='M35,45 Q25,35 20,55 Q35,50 35,45 Z'/%3E%3Ccircle cx='78' cy='18' r='7' fill='%23f48fb1'/%3E%3Ccircle cx='60' cy='8' r='6' fill='%23f8bbd0'/%3E%3Ccircle cx='42' cy='32' r='8' fill='%23f48fb1'/%3E%3Ccircle cx='28' cy='52' r='7' fill='%23f8bbd0'/%3E%3C/svg%3E");
}

/* Bottom-Left Branch */
body::after {
    bottom: -10px;
    left: -10px;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 120 120'%3E%3Cpath fill='none' stroke='%238d6e63' stroke-width='4' stroke-linecap='round' d='M0,120 Q40,80 80,90 T120,50'/%3E%3Cpath fill='none' stroke='%238d6e63' stroke-width='2.5' stroke-linecap='round' d='M45,100 Q60,110 75,115'/%3E%3Cpath fill='%234e8752' d='M55,95 Q65,105 75,90 Q60,85 55,95 Z'/%3E%3Cpath fill='%234e8752' d='M85,75 Q95,85 100,65 Q85,70 85,75 Z'/%3E%3Ccircle cx='52' cy='98' r='7' fill='%23f48fb1'/%3E%3Ccircle cx='70' cy='108' r='6' fill='%23f8bbd0'/%3E%3Ccircle cx='88' cy='72' r='8' fill='%23f48fb1'/%3E%3Ccircle cx='102' cy='58' r='7' fill='%23f8bbd0'/%3E%3C/svg%3E");
}

/* Card Styling for Login and Register */
.auth-container {
    background: var(--card-bg);
    backdrop-filter: blur(8px);
    border-radius: 20px;
    padding: 40px 35px;
    width: 100%;
    max-width: 380px;
    box-shadow: 0 10px 25px rgba(216, 112, 147, 0.15);
    border: 1px solid rgba(243, 193, 207, 0.6);
    position: relative;
    z-index: 10;
    margin: auto;
    box-sizing: border-box;
}

.auth-container h2 {
    text-align: center;
    margin-top: 0;
    margin-bottom: 6px;
    color: var(--text-dark);
    font-size: 1.8rem;
}

.auth-container .subtitle {
    text-align: center;
    color: var(--accent-green);
    font-size: 0.9rem;
    margin-bottom: 25px;
    font-weight: 600;
}

/* Explicit Form Stacking for Auth Pages */
.auth-container form {
    display: flex;
    flex-direction: column;
    gap: 14px;
}

.auth-container input[type="text"],
.auth-container input[type="email"],
.auth-container input[type="password"],
.auth-container select {
    width: 100% !important;
    padding: 12px 15px !important;
    border: 1.5px solid var(--input-border) !important;
    border-radius: 10px !important;
    box-sizing: border-box !important;
    font-size: 0.95rem !important;
    background-color: #fffcfd !important;
    color: var(--text-dark) !important;
    font-family: inherit !important;
    transition: all 0.3s ease !important;
}

.auth-container input:focus,
.auth-container select:focus {
    outline: none !important;
    border-color: var(--input-focus) !important;
    box-shadow: 0 0 8px rgba(216, 112, 147, 0.25) !important;
    background-color: #ffffff !important;
}

.auth-container button[type="submit"] {
    width: 100% !important;
    padding: 12px !important;
    background-color: var(--primary-pink) !important;
    color: white !important;
    border: none !important;
    border-radius: 10px !important;
    font-size: 1rem !important;
    font-weight: bold !important;
    cursor: pointer !important;
    transition: background-color 0.3s ease !important;
    margin-top: 8px !important;
    box-shadow: 0 4px 12px rgba(216, 112, 147, 0.3) !important;
}

.auth-container button[type="submit"]:hover {
    background-color: var(--primary-hover) !important;
}

.auth-container p {
    text-align: center;
    margin-top: 20px;
    margin-bottom: 0;
    font-size: 0.9rem;
    color: #666;
}

.auth-container p a {
    color: var(--accent-green);
    text-decoration: none;
    font-weight: bold;
}

.auth-container p a:hover {
    text-decoration: underline;
}

/* Dashboard Wrapper and Utilities */
.dashboard-container {
    max-width: 1100px;
    margin: 0 auto;
    position: relative;
    z-index: 10;
    width: 100%;
}

.header-card {
    background: var(--card-bg);
    backdrop-filter: blur(8px);
    padding: 20px 30px;
    border-radius: 18px;
    box-shadow: 0 8px 20px rgba(216, 112, 147, 0.12);
    border: 1px solid rgba(243, 193, 207, 0.6);
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.header-card h2 { margin: 0; color: var(--text-dark); font-size: 1.6rem; }
.header-card .role-badge { color: var(--accent-green); font-weight: 600; }

.card {
    background: var(--card-bg);
    backdrop-filter: blur(8px);
    padding: 30px;
    border-radius: 18px;
    box-shadow: 0 8px 20px rgba(216, 112, 147, 0.12);
    border: 1px solid rgba(243, 193, 207, 0.6);
    margin-bottom: 30px;
}

.card h3 {
    margin-top: 0;
    margin-bottom: 20px;
    color: var(--text-dark);
    font-size: 1.3rem;
    border-bottom: 2px solid #fce4ec;
    padding-bottom: 10px;
}

.report-form { display: flex; flex-direction: column; gap: 16px; }
.form-group { display: flex; flex-direction: column; gap: 6px; }
.form-group label { font-weight: 600; font-size: 0.9rem; color: var(--text-dark); }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

.form-control {
    width: 100%;
    padding: 12px 15px;
    border: 1.5px solid var(--input-border);
    border-radius: 10px;
    box-sizing: border-box;
    font-size: 0.95rem;
    background-color: #fffcfd;
    color: var(--text-dark);
    font-family: inherit;
}

textarea.form-control { resize: vertical; min-height: 100px; }

.checkbox-card {
    display: flex;
    align-items: center;
    background: #fff5f8;
    border: 1.5px dashed var(--input-border);
    padding: 12px 18px;
    border-radius: 10px;
    cursor: pointer;
}

.checkbox-card input[type="checkbox"] { accent-color: var(--primary-pink); width: 18px; height: 18px; margin-right: 12px; }
.checkbox-card span { font-size: 0.95rem; font-weight: 600; }

button.btn-submit {
    align-self: flex-start;
    background-color: var(--accent-green) !important;
    color: white !important;
    padding: 12px 28px !important;
    border: none !important;
    border-radius: 10px !important;
    font-size: 1rem !important;
    font-weight: bold !important;
    cursor: pointer !important;
    box-shadow: 0 4px 12px rgba(78, 135, 82, 0.25) !important;
}

a.btn-logout {
    background-color: var(--danger-red) !important;
    color: white !important;
    padding: 10px 20px !important;
    border-radius: 10px !important;
    font-weight: bold !important;
    text-decoration: none !important;
    display: inline-block;
}

.btn-delete {
    background-color: var(--danger-red) !important;
    color: white !important;
    padding: 8px 14px !important;
    border: none !important;
    border-radius: 8px !important;
    font-size: 0.85rem !important;
    font-weight: bold !important;
    cursor: pointer !important;
}

.table-responsive { width: 100%; overflow-x: auto; border-radius: 12px; border: 1px solid rgba(243, 193, 207, 0.8); }
.custom-table { width: 100%; border-collapse: collapse; background-color: #ffffff; text-align: left; }
.custom-table th { background-color: #f8bbd0; color: #4a3e3d; padding: 14px 16px; font-weight: 700; border-bottom: 2px solid #f48fb1; white-space: nowrap; }
.custom-table td { padding: 14px 16px; border-bottom: 1px solid #fce4ec; font-size: 0.92rem; vertical-align: middle; }

.badge-anonymous { color: #777; font-style: italic; background-color: #f0f0f0; padding: 4px 10px; border-radius: 6px; font-size: 0.82rem; display: inline-block; }
.badge-status { background-color: #e8f5e9; color: var(--accent-green); padding: 6px 12px; border-radius: 12px; font-weight: bold; font-size: 0.85rem; display: inline-block; }

.msg-error { background-color: #fce8e6; color: #d93025; padding: 12px; border-radius: 10px; margin-bottom: 20px; border: 1px solid #f5c2c7; text-align: center; }
.msg-success { background-color: #e6f4ea; color: #137333; padding: 12px; border-radius: 10px; margin-bottom: 20px; border: 1px solid #badbcc; text-align: center; }