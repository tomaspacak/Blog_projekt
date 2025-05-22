<?php
session_start();
require_once '../models/Database.php';


if (($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: ../views/auth/login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $db = (new Database())->getConnection();
    $stmt = $db->prepare("DELETE FROM comments WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: ../views/admin/komentare_delete.php");
exit();