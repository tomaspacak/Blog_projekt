
<?php
    require_once '../models/Database.php';
    require_once '../models/Clanek.php';
    session_start();

    // Ověření, že uživatel je přihlášen
    if (!isset($_SESSION['user_id'])) {
        die('Nepřihlášený uživatel.');
    }

    $currentUserId = $_SESSION['user_id'];
    $isAdmin = ($_SESSION['role'] ?? '') === 'admin';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = (int)$_POST['id'];

        $db = (new Database())->getConnection();
        $clanekModel = new Clanek($db);
        $clanek = $clanekModel->getById($id); // Nacteni clanku, ziskani ID

        // Kontrola oprávnění
        $ownsClanek = $currentUserId == $clanek['user_id'];
        if (!$isAdmin && !$ownsClanek) {
            die("Nemáte oprávnění upravovat tento článek.");
        }

        $title = htmlspecialchars($_POST['title']);
        $author = htmlspecialchars($_POST['author']);
        $category = htmlspecialchars($_POST['category']);
        $text = htmlspecialchars($_POST['text']);

        $db = (new Database())->getConnection();
        $clanekModel = new Clanek($db);

        //aktualizace
        $success = $clanekModel->update(
            $id,
            $title,
            $author,
            $category,
            $text
        );

        if ($success) {
            header("Location: ../views/admin/clanky_edit_delete.php");
            exit();
        } else {
            echo "Chyba při aktualizaci článku.";
        }
    } else {
        echo "Neplatný požadavek.";
    }