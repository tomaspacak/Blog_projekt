<?php
session_start();

require_once '../../models/Database.php';
require_once '../../models/Clanek.php';
require_once '../../models/Comment.php';


//inicializace
$db = (new Database())->getConnection();
$clanekModel = new Clanek($db);
$clanek = $clanekModel->getById((int)$_GET['id']);
$commentModel = new Comment($db);
$komentare = $commentModel->getByClanekId($clanek['id']);

// kontrola přístupu
$lastFreeIds = $clanekModel->getLastFreeClanky();
$isFree = in_array($clanek['id'], $lastFreeIds);
if (!$isFree && !isset($_SESSION['user_id'])) {
    echo "Tento článek je dostupný pouze pro přihlášené uživatele.";
    exit;
}


if (!$clanek) {
    echo "Článek nebyl nalezen."; 
    exit;
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
    <title>Přidat článek</title>
</head>
<body>
    <div class="page">
        <div>
            <div class="menu">
                <div class="navbar">
                    <a href="./index.php" class="navbar__logo"><img class="img--responsiv" src="../../../public/img/logo.svg" alt="logo"></a>
                    
                    <div class="hamburger-row">
                        <div href="javascript:void(0)" class="hamburger hamburger-btn hamburger-zone">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                    <nav class="hamburger-nav hamburger-zone">
                        <menu>
                            <li class="menu__item"><a href="./clanky.php">Články</a></li>
                            <li class="menu__item"><a href="#">Náš příběh</a></li>
                            <?php if (isset($_SESSION['username'])): ?>
                                <li class="menu__item">
                                    <span class="nav-link text-white">Přihlášen jako: <strong><?= htmlspecialchars($_SESSION['username']) ?></strong></span>
                                </li>
                                <li class="menu__item">
                                    <a class="nav-link" href="../../controllers/logout.php">Odhlásit se</a>
                                </li>
                            <?php else: ?>
                                <li class="menu__item">
                                    <a class="nav-link" href="../../views/auth/login.php">Přihlášení</a>
                                </li>
                                <li class="menu__item">
                                    <a class="nav-link" href="../../views/auth/register.php">Registrace</a>
                                </li>
                            <?php endif; ?>
                        </menu>
                    </nav>
                </div>
            </div>
        </div>

        <main class="page__wrapper">
            <article>
                <h1 class="clanek__title"><?= htmlspecialchars($clanek['title']) ?></h1>
                <p class="clanek__autor">Autor: <?= htmlspecialchars($clanek['author']) ?> | Kategorie: <?= htmlspecialchars($clanek['category']) ?></p>
                <p class="clanek__autor">Naposledy upraveno: <?= htmlspecialchars($clanek['updated_at']) ?></p>
                <div class="clanek__content">
                    <?= html_entity_decode($clanek['text']) ?>
                        
                    
                    
                </div>
                
                <?php
                    $sources = json_decode($clanek['sources'], true);
                    if (is_array($sources) && !empty($sources)) {
                        echo '<p class="clanek__zdroje">Zdroje:</p>';
                        echo '<ul>';
                        foreach ($sources as $source) {
                            echo '<li class="clanek__zdroj"> <a class="link" href="' . $source . '" target="_blank" rel="noopener noreferrer">' . $source . '</a></li>';
                        }

                        echo '</ul>';
                    }
                ?>

                <div>

                </div>
                
            </article>
            <section>
                <h2>Komentáře</h2>
                <div class="komentare_wrapper">
                    <div class="komentare_vypis">
                        <?php if (!empty($komentare)): ?>
                            
                                <?php foreach ($komentare as $komentar): ?>
                                    <div class="komentar" >
                                        <p class="komentar__autor"><?= htmlspecialchars($komentar['username']) ?></p>
                                        <p class="komentar__date"><?= htmlspecialchars($komentar['created_at']) ?></p>
                                        <p class="komentar__text"><?= nl2br(htmlspecialchars($komentar['text'])) ?></p>
                                        
                                    </div>
                                <?php endforeach; ?>
                            
                        <?php else: ?>
                            <p class="message">Zatím žádné komentáře.</p>
                        <?php endif; ?>

                    </div>
                    <div>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <form class="komentare_pridat" method="post"  action="../../controllers/CommentController.php">
                                <textarea class="form-control form-control--komentar" name="text" placeholder="Napsat komentář" required></textarea>
                                <input type="hidden" name="clanek_id" value="<?= $clanek['id'] ?>">
                                <button class="btn" type="submit">Odeslat komentář</button>
                            </form>
                        <?php else: ?>
                            <p class="warning"><a class="link" href="../auth/login.php">Přihlas se</a> pro přidání komentáře, nemáš účet? <a class="link" href="../auth/register.php">Registruj se</a></p>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
            
            

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
                        </div>
                    </div>
                </div>
        
                <div class="footer__line"></div>
        
                <div class="footer__paticka">
                    <div class="paticka__wrapper">
                        <p>© Copyright 2025</p>
                    </div>
                    <p>Vyrobil: Tomáš Pacák</p>
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