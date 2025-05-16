<?php

class Database {
    private $host = "localhost";
    private $db_name = "wa_blog";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        
        // Odpojí připojení k databázi tím, že změní proměnnou $this->conn na null.
        // Ukončí existující PDO objekt, což může být užitečné pro správu paměti.
        $this->conn = null;
        
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Výpis informace o úspěšném připojení (pro testování)
            echo "Připojení k databázi bylo úspěšné!<br>";
            
        } catch (PDOException $exception) {
            echo "Chyba připojení: " . $exception->getMessage();
        }
        return $this->conn;
    }
}

// Pro otestování připojení stačí tento soubor spustit
// Můžete tento kód zakomentovat po ověření
//$database = new Database();
//$database->getConnection();