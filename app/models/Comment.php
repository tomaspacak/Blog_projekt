<?php

class Comment {
    private $db;

    //__construct() automaticky se spusti pri vytvoreni objektu
    public function __construct($db) {
        $this->db = $db;
    }

    //vytvoreni komentare, ulozeni do databaze
    public function create($user_id, $clanek_id, $text) {
        $sql = "INSERT INTO comments (user_id, clanek_id, text) 
                VALUES (:user_id, :clanek_id, :text)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':user_id' => $user_id,
            ':clanek_id' => $clanek_id,
            ':text' => $text
        ]);
    }

    //komentare ke konkretnimu clanku
    public function getByClanekId($clanek_id) {
        $sql = "SELECT c.text, c.created_at, u.username 
                FROM comments c
                JOIN users u ON c.user_id = u.id
                WHERE c.clanek_id = :clanek_id
                ORDER BY c.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':clanek_id' => $clanek_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //vsechny komentare
    public function getAll() {
        $sql = "SELECT c.id, c.clanek_id, c.text, c.created_at, u.username 
                FROM comments c
                JOIN users u ON c.user_id = u.id
                ORDER BY c.id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
