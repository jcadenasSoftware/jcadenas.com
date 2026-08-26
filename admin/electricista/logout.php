<?php
require_once __DIR__ . '/../../includes/electricista-works.php';

electricistaAdminLogout();
header('Location: ' . electricistaAdminUrl('login.php'));
exit;
