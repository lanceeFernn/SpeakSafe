<?php
// Centralized Session Management
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>