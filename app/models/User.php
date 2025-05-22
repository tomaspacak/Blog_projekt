<?php

class User {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function existsByUsername($username) {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch() !== false;
    }

    /*registrace*/
    public function register($username, $email, $password_hash, $name = null, $surname = null) {
        $stmt = $this->db->prepare("
            INSERT INTO users (username, email, password_hash, name, surname)
            VALUES (?, ?, ?, ?, ?)
        ");
        return $stmt->execute([$username, $email, $password_hash, $name, $surname]);
    }

    //login
    public function findByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllUsers() {
        $sql = "SELECT * FROM users ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /*změna role*/
    public function updateRole($id, $role) {
        $stmt = $this->db->prepare("UPDATE users SET role = ? WHERE id = ?");
        return $stmt->execute([$role, $id]);
    }
}

