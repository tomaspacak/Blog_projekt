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
        
        //kontrola prihlaseni
        if (!isset($_SESSION['user_id'])) {
            header("Location: ../views/blog/index.php");
            die("Uživatel není přihlášen.");
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
                $uploadDir = '../public/img/';
                foreach ($_FILES['img']['tmp_name'] as $key => $tmp_name) {
                    $filename = basename($_FILES['img']['name'][$key]);
                    $targetPath = $uploadDir . $filename;

                    if (move_uploaded_file($tmp_name, $targetPath)) {
                        $imagePaths[] = '/public/img' . $filename; // Relativní cesta
                    }
                }
            }

            // Zpracování zdrojů (přijde jako pole)
            $sourcesRaw = $_POST['sources'];
            $sourcesClean = array_map('trim', $sourcesRaw); //odstrani mezery
            $sourcesClean = array_filter($sourcesClean); // odstrani prazdne radky
            $sourcesJson = json_encode($sourcesClean); //to JSON
            
            //odeslani dat do databaze
            if ($this->clanekModel->create(
                $title, $author, $category, $text, $sourcesJson,
                $imagePaths, $user_id
            )) {
                header("Location: ../views/admin/clanky_edit_delete.php");
                exit();
            } else {
                echo "Chyba při ukládání článku.";
            }  
        }
    }
}

$controller = new ClanekController();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $controller->createClanek();
}

//?????

/*$commentModel = new Comment($this->db);
$komentare = $commentModel->getByClanekId($clanek_id);

// Poté ve view předáš proměnnou $komentare
include '../views/clanky/clanek_detail.php';