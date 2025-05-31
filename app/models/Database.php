<?php

//pripojeni k databazi
class Database {
    private $host = "localhost"; //adresa serveru databaze
    private $db_name = "wa_projekt";
    private $username = "root"; //pripojeni jako admin
    private $password = "";
    public $conn;

    public function getConnection() {

        // zruseni stareho pripojeni
        $this->conn = null;
        
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            
            //reakce na chyby
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Výpis informace o úspěšném připojení (pro testování)
           /* echo "Připojení k databázi bylo úspěšné!<br>";*/
            
        } catch (PDOException $exception) {
            echo "Chyba připojení: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
