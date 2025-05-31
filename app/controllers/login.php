<?php
    require_once '../models/Database.php';
    require_once '../models/User.php';

    session_start();

    $db = (new Database())->getConnection();
    $userModel = new User($db);

    // Zpracování přihlášení
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username']);
        $password = $_POST['password'];

        if (empty($username) || empty($password)) {
            die('Vyplňte prosím všechna pole.');
        }

        //nacteni uzivatele z databaze
        $user = $userModel->findByUsername($username);

        //zadane heslo > hash > porovnat
        if ($user && password_verify($password, $user['password_hash'])) {

            //ulozeni udaju do session - dostupne napric strankami
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            //presmerovani
            header("Location: ../views/blog/index.php");
            exit();

        } else {
            //presmerovani a vypsani chyby
            header("Location: ../views/auth/login.php?error=1");
            exit();
        }
    } else {
        die('Neplatný požadavek.');
    }