
<?php
    require_once '../models/Database.php';
    require_once '../models/Clanek.php';

    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];

        $db = (new Database())->getConnection();
        $clanekModel = new Clanek($db);

        if ($clanekModel->delete($id)) {
            header("Location: ../views/blog/clanky_edit_delete.php");
            exit();
        } else {
            echo "Chyba při mazání knihy.";
        }
    } else {
        echo "Neplatný požadavek.";
    }