<?php

class Clanek {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($title, $author, $category, $text, $sources , $images, $user_id) {
        
        // Dvojtečka označuje pojmenovaný parametr => Místo přímých hodnot se používají placeholdery.
        // PDO je pak nahradí skutečnými hodnotami při volání metody execute().
        // Chrání proti SQL injekci (bezpečnější než přímé vložení hodnot).
       // Vkládáme i user_id, abychom měli vazbu na uživatele
       $sql = "INSERT INTO clanky (
                title, author, category, text, sources, images, user_id
            ) VALUES (
                :title, :author, :category, :text, :sources, :images, :user_id
            )";
        
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            ':title' => $title,
            ':author' => $author,
            ':category' => $category,
            ':text' => $text,
            ':sources' => $sources,
            ':images' => json_encode($images), // Ukládání obrázků jako JSON
            ':user_id' => $user_id
        ]);

        if (!$result) {
            $error = $stmt->errorInfo();
            echo "Chyba při vkládání: " . $error[2]; // výpis chyby z PDO
        }
        return $result;
    }

    public function getAll() {
        $sql = "SELECT * FROM clanky ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return  $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //edit
    public function getById($id) {
        $sql = "SELECT * FROM clanky WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //nahrani novych dat
    public function update($id, $title, $author, $category, $text /*$sources , $images,*/) {
        $sql = "UPDATE clanky 
                SET title = :title,
                    author = :author,
                    category = :category,
                    text = :text
                WHERE id = :id";
    
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':title' => $title,
            ':author' => $author,
            ':category' => $category,
            ':text' => $text,
        ]);
    }

    public function delete($id) {
        $sql = "DELETE FROM clanky WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}