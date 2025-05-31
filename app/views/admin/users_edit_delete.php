<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../blog/index.php");
    die("Uživatel není přihlášen.");
}
$isAdmin = ($_SESSION['role'] ?? '') === 'admin';
if (!$isAdmin) {
    header("Location: ../blog/index.php");
    exit();
}

require_once '../../models/Database.php';
require_once '../../models/User.php';

$db = (new Database())->getConnection();
$userModel = new User($db);
$users = $userModel->getAllUsers();

?>
<!DOCTYPE html>
<html lang="cz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../../public/css/typography.css">
    <link rel="stylesheet" href="../../../public/css/layout.css">
    <link rel="stylesheet" href="../../../public/css/style.css">
    <link rel="stylesheet" href="../../../public/css/richtext.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Uživatelé - OnSite SEO pod lupou</title>
</head>
<body>
    <div class="page">
        <div>
            <div class="menu">
                <div class="navbar">
                    <a href="../blog/index.php" class="navbar__logo"><img class="img--responsiv" src="../../../public/img/logo.svg" alt="logo"></a>
                    
                    <div class="hamburger-row">
                        <div href="javascript:void(0)" class="hamburger hamburger-btn hamburger-zone">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                    <nav class="hamburger-nav hamburger-zone">
                        <menu>
                            <div class="menuLeft menuRight">
                                <li class="menu__item"><a href="../blog/clanky.php">Články</a></li>
                                <li class="menu__item"><a href="./clanek_create.php">Správa</a></li>
                                <li class="menu__item"><a href="../blog/sluzby.php">Služby</a></li>
                            </div>
                            
                        
                            <?php if (isset($_SESSION['username'])): ?>
                                <div class="menuRight">
                                    <div class="line"></div>
                                    <li class="menu__item">
                                        <div class="userLoged">
                                            <div class="iconContainer"><img class="img--responsiv" src="../../../public/img/icon_user.svg" alt="ikona uzživatele"></div>
                                            <p class="userLoged__text"><strong><?= htmlspecialchars($_SESSION['username']) ?></strong></p>
                                        </div>
                                    </li>
                                    <li class="menu__item">
                                        <a class="nav-link" href="../../controllers/logout.php">Odhlásit se</a>
                                    </li>
                                </div>
                                
                            <?php else: ?>
                                <div class="menuRight">
                                    <div class="line"></div>
                                    <li class="menu__item">
                                        <a class="nav-link" href="../../views/auth/login.php">Přihlášení</a>
                                    </li>
                                    <li class="menu__item">
                                        <a class="nav-link" href="../../views/auth/register.php">Registrace</a>
                                    </li>
                                </div>
                                
                            <?php endif; ?>
                        </menu>
                    </nav>
                </div>
            </div>
        </div>

        <main class="page__wrapper">
            <div>
                <h1 class="h1--admin">Správa uživatelů</h1>
                <div class="adminNav">
                    <a class="adminNav__link" href="./clanek_create.php">Přidat článek</a>
                    <a class="adminNav__link" href="./clanky_edit_delete.php">Editovat článek</a>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <a class="adminNav__link" href="./users_edit_delete.php">Uživatelé</a>
                        <a class="adminNav__link" href="./komentare_delete.php">Komentáře</a>
                    <?php endif; ?>
                </div>
            </div>

            
            <?php if (!empty($users)): ?>
            <table class="table">
                <thead class="table__head">
                    <tr class="table__row">
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Surname</th>
                        <th>Role</th>
                        <th>Akce</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $user): ?>
                    <tr class="table__row">
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['name']) ?></td>
                        <td><?= htmlspecialchars($user['surname']) ?></td>
                         <td>
                            <form method="post" action="../../controllers/user_update.php" style="display: inline-flex; gap: 4px;">
                                <input type="hidden" name="id" value="<?= $user['role'] ?>">
                                <select name="role"  >
                                    <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>user</option>
                                    <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>admin</option>
                                </select>
                                <button type="submit" class="btn btn-sm">Změnit</button>
                            </form>
                        </td>
                        
                        <td>
                            <?php if ($_SESSION['user_id'] !== $user['id']): ?>
                                <a href="../../controllers/user_delete.php?id=<?= $user['id'] ?>" class="btn btn--danger" onclick="return confirm('Opravdu smazat uživatele?');">Smazat</a>
                            <?php else: ?>
                                <span>Nelze smazat sebe</span>
                            <?php endif; ?>
                        </td>

                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        
            <?php else: ?>
                <p class="warning">Žádní uživatelé nebyli nalezeni (chyba).</p>
            <?php endif; ?>
        
        </main>

        <footer>
            <div class="footer">
                <div class="footer__mainWrapper">
                    <div class="footer__kategory">
                        <p class="footer__title">OnSiteSEO pod lupou</p>
                        <div class="footer__wrapper">
                            <div>
                                <p class="footer__neodkaz">OnSiteSEO pod lupou s.r.o.</p>
                                <p class="footer__neodkaz">Uherská 12345</p>
                                <p class="footer__neodkaz">460 001 Liberec</p>
                            </div>
                            <div class="footer__wrapper2">
                                <a class="footer__odkaz footer__odkaz--tel" href="tel:+420777666666">+420 777 666 666</a>
                                <a class="footer__odkaz footer__odkaz--mail" href="mailto:obchod@l3web.cz">SEO@web.cz</a>
                                <div class="footer__icons">
                                    <a href="#"><img class="footer__icon" src="../../../public/img/icon_instagram.svg" alt="Logo Instagram"></a>
                                    <a href="#"><img class="footer__icon" src="../../../public/img/footer_linkedin.svg" alt="Logo LinkedIn"></a>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="footer__kategory">
                        <p class="footer__title">Správa</p>
                        <div class="footer__text">
                            <a class="footer__odkaz" href="./clanek_create.php">Přidat</a>
                            <a class="footer__odkaz" href="./clanky_edit_delete.php">Editace</a>
                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                <a class="footer__odkaz" href="./users_edit_delete.php">Uživatelé</a>
                                <a class="footer__odkaz" href="./komentare_delete.php">Komentáře</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
        
                <div class="footer__line"></div>
        
                <div class="footer__paticka">
                    <div class="paticka__wrapper">
                        <p>© Copyright 2025</p>
                    </div>
                    <p>Vytvořil: Tomáš Pacák</p>
                </div>
            </div>
        </footer>

    </div>
    <script src="../../../public/js/hamburger.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="../../../public/js/jquery.richtext.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.form--text').richText();
        });
    </script>
</body>
</html>