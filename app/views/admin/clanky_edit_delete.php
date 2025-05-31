<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../blog/index.php");
    die("Uživatel není přihlášen.");
}


require_once '../../models/Database.php';
require_once '../../models/Clanek.php';


$db = (new Database())->getConnection();
$clanekModel = new Clanek($db);
$clanky = $clanekModel->getAll();

$editMode = false;
$clanekToEdit = null;

if (isset($_GET['edit'])) {
    $editId = (int)$_GET['edit'];
    $clanekToEdit = $clanekModel->getById($editId);
    if ($clanekToEdit) {
        $editMode = true;
    }
}



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
    <title>Editace - OnSite SEO pod lupou</title>
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
                <h1 class="h1--admin">Správa článků</h1>
                <div class="adminNav">
                    <a class="adminNav__link" href="./clanek_create.php">Přidat článek</a>
                    <a class="adminNav__link" href="./clanky_edit_delete.php">Editovat článek</a>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <a class="adminNav__link" href="./users_edit_delete.php">Uživatelé</a>
                        <a class="adminNav__link" href="./komentare_delete.php">Komentáře</a>
                    <?php endif; ?>
                </div>
            </div>
            
            <?php if (!empty($clanky)): ?>
            <table class="table">
                <thead class="table__head">
                    <tr class="table__row">
                        <th>ID</th>
                        <th>Název</th>
                        <th>Autor</th>
                        <th>Kategorie</th>
                        <th>Akce</th>
                        <th>user ID</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($clanky as $clanek): ?>
                    <tr class="table__row">
                        <td><?= htmlspecialchars($clanek['id']) ?></td>
                        <td><?= htmlspecialchars($clanek['title']) ?></td>
                        <td><?= htmlspecialchars($clanek['author']) ?></td>
                        <td><?= htmlspecialchars($clanek['category']) ?></td>
                        
                        <td>
                            <?php
                                $currentUserId = $_SESSION['user_id'] ?? null;
                                $isAdmin = ($_SESSION['role'] ?? '') === 'admin';
                                $ownsClanek = $currentUserId == $clanek['user_id'];

                            if ($isAdmin || $ownsClanek):
                            ?>
                                <a href="?edit=<?= $clanek['id'] ?>" class="btn">Upravit</a>
                                <a href="../../controllers/clanek_delete.php?id=<?= $clanek['id'] ?>" class="btn btn--danger" onclick="return confirm('Opravdu chcete smazat tento článek?');">Smazat</a>
                            <?php else: ?>
                                <span class="text-muted">Bez oprávnění</span>
                            <?php endif; ?>
                        </td>

                        <td><?= htmlspecialchars($clanek['user_id']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        
            <?php else: ?>
                <div class="warning">Žádný článek nebyl nalezen.</div>
            <?php endif; ?>
        
            <?php if ($editMode): ?>
                <div>
                    
                    <div class="create__body">
                        <div>
                            <h2>Upravit článek: <?= htmlspecialchars($clanekToEdit['title']) ?></h2>
                        </div>
                        <form action="../../controllers/clanek_update.php" method="post">
                            <input type="hidden" name="id" value="<?= $clanekToEdit['id'] ?>">
                            <div class="input__wrapper">
                                <input type="text" class="form-control" value="<?= $clanekToEdit['id'] ?>" disabled>
                                <label class="form-label">ID článku:</label>
                            </div>
                            <div class="input__wrapper">
                                <input type="text" id="title" name="title" class="form-control" required value="<?= htmlspecialchars($clanekToEdit['title']) ?>">
                                <label for="title" class="form-label">Název článku:</label>
                            </div>

                            <div class="input__wrapper">
                                <input type="text" id="author" name="author" class="form-control" required value="<?= htmlspecialchars($clanekToEdit['author']) ?>">
                                <label for="author" class="form-label">Autor:</label>
                            </div>
  
                            <div class="input__wrapper">
                                <input type="hidden" name="category" value="<?= htmlspecialchars($clanekToEdit['category']) ?>">
                                <select name="category" id="category" class="form-control" required>
                                    <option value="" >Vyberte kategorii (nepovinné)</option>
                                    <option value="Základy" <?= $clanekToEdit['category'] === 'Základy' ? 'selected' : '' ?>>Základy</option>
                                    <option value="HTML" <?= $clanekToEdit['category'] === 'HTML' ? 'selected' : '' ?>>HTML</option>
                                    <option value="Content" <?= $clanekToEdit['category'] === 'Content' ? 'selected' : '' ?>>Content</option>
                                </select>
                                <label for="category" class="form-label">Kategorie:</label>
                            </div>

                            

                            <div class="input__wrapper">
                                <label for="text" class="form-label form-label--text">Text:</label>
                                <textarea name="text" id="text" class="form-control form--text"> <?= $clanekToEdit['text'] ?> </textarea>
                            </div>

                            <?php
                                // Rozdělení zdrojů
                                $zdroje = json_decode($clanekToEdit['sources'], true);
                            ?>
                            <div class="input__wrapper">
                                <label for="sources" class="form-label">Zdroje:</label>
                                <div id="zdroje-wrapper">
                                    <?php foreach ($zdroje as $zdroj): ?>
                                        <input type="text" name="sources[]" class="form-control" value="<?= $zdroj?>" placeholder="www.bla.cz" required style="margin-bottom: 8px;">
                                    <?php endforeach; ?>
                                </div>
                                <button class="btn btn--var2" type="button" onclick="pridatZdroj()">Přidat další zdroj</button>
                            </div>

                            
                            <div class="log__btns log__btns--create">
                                <button type="submit" class="btn btn--log">Uložit změny</button>
                            </div>
                            
                        </form>
                    </div>
                </div>
                    
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
    <script>
        function pridatZdroj() {
            const wrapper = document.getElementById("zdroje-wrapper");
            const input = document.createElement("input");
            input.type = "text";
            input.name = "sources[]";
            input.className = "form-control";
            input.placeholder = "Např. https://example.com";
            input.style.marginTop = "8px";
            wrapper.appendChild(input);
        }
    </script>
</body>
</html>