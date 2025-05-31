<?php
session_start();

require_once '../../models/Database.php';
require_once '../../models/Clanek.php';

/*pro vygenerování článků*/
$db = (new Database())->getConnection();
$clanekModel = new Clanek($db);
$clanky = $clanekModel->getAll();

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
    <title>Články - OnSite SEO pod lupou</title>
</head>
<body>
    <div class="page">
        <header class="head__wrapper">
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
                            <div class="menuLeft menuRight">
                                <li class="menu__item"><a href="./clanky.php">Články</a></li>
                                <li class="menu__item"><a href="../admin/clanek_create.php">Správa</a></li>
                                <li class="menu__item"><a href="./sluzby.php">Služby</a></li>
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

            <div class="uvod">
                <div class="uvod__wrapper">
                    <div class="uvod__text">
                        <h1>Články</span></h1>
                        <h2>OnSite SEO <span class="secondaryC">pod lupou</span></h2>
                    </div>
                </div>
                <div class="uvod__img">
                    <img class="img--responsiv" src="../../../public/img/hp_bg1.webp" alt="Ilustrace na téma On site SEO">
                </div>
            </div>
        </header>

        <main class="page__wrapper">

        <?php if (isset($_SESSION['user_id'])): ?>

            <section class="cards">
                <div class="cards__wrapper cards__wrapper--all">

                    <?php foreach ($clanky as $clanek): ?>
                        <a class="card" href="clanek_detail.php?id=<?= $clanek['id'] ?>">
                            <article class="card__wrapper">
                                <h3 class="card__title"><?= htmlspecialchars($clanek['title']) ?></h3>
                                <div class="card__text">
                                    <?= mb_strimwidth(strip_tags(html_entity_decode($clanek['text'])), 0, 100, '...') ?>
                                </div>
                            </article>
                        </a>
                    <?php endforeach; ?>
                    

                </div>
            </section>

            <section class="navrhy text--center">
                <h2>Máte nápad na zlepšení blogu?</h2>
                <div>
                    <p class="navrhy__text">Nebo dotazy? Nebojte se napsat.</p>
                    <p class="navrhy__mail">OnSiteSEO@web.cz</p>
                    <a class="btn" href="mailto:obchod@l3web.cz">Napsat Email</a>
                </div>
            </section>
        <?php else: ?>
            <div class="warning">
                <p class="warning__title">Nejste přihlášen</p>
                <p>Přihlášení uživatelé mají přístup ke <b>všem článkům</b> zdarma i smožností interakce.</p>
                <div class="text--center">
                    <a class="btn btn--log" href="../auth/login.php">Přihlásit se</a>
                    <p class="text--s">Nemáte účet?</p>
                    <a class="btn" href="../auth/register.php">Registrace</a>
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
                                <a class="footer__odkaz footer__odkaz--mail" href="mailto:obchod@l3web.cz">OnSiteSEO@web.cz</a>
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
                            <a class="footer__odkaz" href="../admin/clanek_create.html">Přidat</a>
                            <a class="footer__odkaz" href="../admin/clanky_edit_delete.php">Editace</a>
                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                <a class="footer__odkaz" href="../admin/users_edit_delete.php">Uživatelé</a>
                                <a class="footer__odkaz" href="../admin/komentare_delete.php">Komentáře</a>
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
</body>
</html>