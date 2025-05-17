
<?php
    require_once '../models/Database.php';
    require_once '../models/Clanek.php';
    session_start();

    // Ověření, že uživatel je přihlášen
    if (!isset($_SESSION['user_id'])) {
        http_response_code(403);
        die('Nepřihlášený uživatel.');
    }

    $currentUserId = $_SESSION['user_id'];
    $isAdmin = ($_SESSION['role'] ?? '') === 'admin';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = (int)$_POST['id'];
        $title = htmlspecialchars($_POST['title']);
        $author = htmlspecialchars($_POST['author']);
        $category = htmlspecialchars($_POST['category']);
        $text = htmlspecialchars($_POST['text']);

        $db = (new Database())->getConnection();
        $clanekModel = new Clanek($db);

        //lets go
        $success = $clanekModel->update(
            $id,
            $title,
            $author,
            $category,
            $text
        );

        if ($success) {
            /*header("Location: ../views/books/books_edit_delete.php");
            exit();*/
        } else {
            echo "Chyba při aktualizaci knihy.";
        }
    } else {
        echo "Neplatný požadavek.";
    }