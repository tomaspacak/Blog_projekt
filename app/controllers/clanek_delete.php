
<?php
    session_start();
    require_once '../models/Database.php';
    require_once '../models/Clanek.php';

    if (!isset($_SESSION['user_id'])) {
        die('Nepřihlášený uživatel.');
    }
    $currentUserId = $_SESSION['user_id'];
    $isAdmin = ($_SESSION['role'] ?? '') === 'admin';

    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];

        $db = (new Database())->getConnection();
        $clanekModel = new Clanek($db);

        $clanek = $clanekModel->getById($id);
        $ownsClanek = $currentUserId == $clanek['user_id'];

        if (!$isAdmin && !$ownsClanek) {
            die("Nemáte oprávnění smazat tento článek.");
        }

        if ($clanekModel->delete($id)) {
            header("Location: ../views/admin/clanky_edit_delete.php");
            exit();
        } else {
            echo "Chyba při mazání článku.";
        }
    } else {
        echo "Neplatný požadavek.";
    }