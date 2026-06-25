<?php
// admin/auth.php - protect admin pages
session_start();
if (empty($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
?>
