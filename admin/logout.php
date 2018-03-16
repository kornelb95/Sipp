<?php
require_once '../includes/init.php';
$session->logoutAdmin();
header("Location: index.php");