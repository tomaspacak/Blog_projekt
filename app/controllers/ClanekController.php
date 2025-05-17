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

    public function createBook() {
        // Kontrola, jestli je uživatel přihlášen
        if (!isset($_SESSION['user_id'])) {
            /*header("Location: ../controllers/book_list.php"); //fwfnenfenfj*/
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
            /*$subcategory = !empty($_POST['subcategory']) ? htmlspecialchars($_POST['subcategory']) : null;
            $year = intval($_POST['year']);
            $price = floatval($_POST['price']);
            $isbn = htmlspecialchars($_POST['isbn']);
            $description = htmlspecialchars($_POST['description']);
            $link = htmlspecialchars($_POST['link']);*/


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
                /*header("Location: ../controllers/book_list.php");
                exit();*/
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

// Volání metody při odeslání formuláře
$controller = new ClanekController();
//$controller->createBook();

// Zavolá pouze pokud šlo o POST request (odeslání formuláře)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $controller->createBook();
}