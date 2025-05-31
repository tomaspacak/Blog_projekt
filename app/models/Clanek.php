<?php

class Clanek {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    //ulozeni clanku do datbaze
    public function create($title, $author, $category, $text, $sources , $images, $user_id) {
        
       $sql = "INSERT INTO clanky (
                title, author, category, text, sources, images, user_id
            ) VALUES (
                :title, :author, :category, :text, :sources, :images, :user_id
            )";
        
        $stmt = $this->db->prepare($sql);
        
        $result = $stmt->execute([
            ':title' => $title,
            ':author' => $author,
            ':category' => $category,
            ':text' => $text,
            ':sources' => $sources,
            ':images' => json_encode($images),
            ':user_id' => $user_id
        ]);

        if (!$result) {
            $error = $stmt->errorInfo();
            echo "Chyba při vkládání: " . $error[2]; // výpis chyby z PDO
        }

        return $result;
    }

    //ziskani clanku, moznost limitu
    public function getAll(int $limit = null): array {
        $sql = "SELECT * FROM clanky ORDER BY created_at DESC";
        if ($limit !== null) {
            
            $sql .= " LIMIT " . (int)$limit;
        }
    
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //ziskani konkretniho clanku
    public function getById($id) {
        $sql = "SELECT * FROM clanky WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //nahrani novych dat
    public function update($id, $title, $author, $category, $text, $sources) {
        $sql = "UPDATE clanky 
                SET title = :title,
                    author = :author,
                    category = :category,
                    text = :text,
                    sources = :sources
                WHERE id = :id";
    
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':title' => $title,
            ':author' => $author,
            ':category' => $category,
            ':text' => $text,
            ':sources' => $sources,
        ]);
    }

    //smazani konkretniho clanku
    public function delete($id) {
        $sql = "DELETE FROM clanky WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    //3 nejnovejsi clanky, jen ID
    public function getLastFreeClanky($limit = 3) {
        $stmt = $this->db->prepare("SELECT id FROM clanky ORDER BY created_at DESC LIMIT :limit");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}