<?php
session_start();


require_once '../models/Database.php';
require_once '../models/Clanek.php';

class ClanekController {
    private $db;
    private $clanekModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->clanekModel = new Clanek($this->db);
    }

    public function createClanek() {
        // Kontrola, jestli je uživatel admin
        $isAdmin = ($_SESSION['role'] ?? '') === 'admin';
    
        if (!isset($_SESSION['user_id'])) {
            header("Location: ../views/blog/index.php");
            die("Uživatel není přihlášen.");
        }

        $isAdmin = ($_SESSION['role'] ?? '') === 'admin';
        if (!$isAdmin) {
            header("Location: ../views/blog/index.php");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!isset($_SESSION['user_id'])) {
                die("Uživatel není přihlášen.");
            }
            $userId = $_SESSION['user_id'];

            $title = htmlspecialchars($_POST['title']);
            $author = htmlspecialchars($_POST['author']);
            $category = htmlspecialchars($_POST['category']);
            $text = htmlspecialchars($_POST['text']);


            // Získání ID přihlášeného uživatele
            $user_id = $_SESSION['user_id'];

            // Zpracování nahraných obrázků
            $imagePaths = [];
            if (!empty($_FILES['images']['name'][0])) {
                $uploadDir = '../public/images/';
                foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                    $filename = basename($_FILES['images']['name'][$key]);
                    $targetPath = $uploadDir . $filename;

                    if (move_uploaded_file($tmp_name, $targetPath)) {
                        $imagePaths[] = '/public/images/' . $filename; // Relativní cesta
                    }
                }
            }

            // Zpracování zdrojů (přijde jako pole)
            $sourcesRaw = $_POST['sources'];
            $sourcesClean = array_map('trim', $sourcesRaw);
            $sourcesClean = array_filter($sourcesClean); // odstraní prázdné
            $sourcesJson = json_encode($sourcesClean);
            
            if ($this->clanekModel->create(
                $title, $author, $category, $text, $sourcesJson,
                $imagePaths, $user_id
            )) {
                header("Location: ../views/blog/clanky_edit_delete.php");
                exit();
            } else {
                echo "Chyba při ukládání knihy.";
            }  
        }
    }

    
   /* public function listBooks () {
        $clanky = $this->clanekModel->getAll();
        include '../views/books/book_list.php';
    }*/
}


$controller = new ClanekController();
//$controller->createClanek();

// Zavolá pouze pokud šlo o POST request (odeslání formuláře)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $controller->createClanek();
}

$commentModel = new Comment($this->db);
$komentare = $commentModel->getByClanekId($clanek_id); // $clanek_id by mělo být id daného článku

// Poté ve view předáš proměnnou $komentare
include '../views/clanky/clanek_detail.php';