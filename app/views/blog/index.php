<?php
session_start();


require_once '../../models/Database.php';
require_once '../../models/Clanek.php';

$db = (new Database())->getConnection();
$clanekModel = new Clanek($db);

$clanky = $clanekModel->getAll(3);

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
    <title>OnSite SEO pod lupou</title>
</head>
<body>
    <div class="page">
        <header class="head__wrapper">
            <div class="menu">
                <div class="navbar">
                    <a href="./index.html" class="navbar__logo"><img class="img--responsiv" src="../../../public/img/logo.svg" alt="logo"></a>
                    
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
                            <li class="menu__item"><a href="#">Služby</a></li>
                            <li class="menu__item"><a href="#">O mně</a></li>
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

            <div class="uvod">
                <div class="uvod__wrapper">
                    <div class="uvod__text">
                        <h1>OnSite SEO <span class="secondaryC">pod lupou</span></h1>
                        <p class="uvod__popis">Vítejte na mém blogu, který je o Onsite SEO. Moje krátké představení si můžete přečíst <a class="link" href="#o">níže</a>.</p>
                        <a href="../auth/register.html" class="btn ">Registrovat se</a>
                    </div>
                </div>
                <div class="uvod__img">
                    <img class="img--responsiv" src="../../../public/img/hp_bg1.jpg" alt="#">
                </div>
            </div>
        </header>

        <main class="page__wrapper">
            
            <section class="cards">
                <h2 class="title title2 cards__title text--center">Nejnovější články</h2>
                <div class="cards__wrapper">
                    <?php foreach ($clanky as $clanek): ?>
                            <a class="card" href="clanek_detail.php?id=<?= $clanek['id'] ?>">
                                <article class="card__wrapper">
                                    <h3 class="card__title"><?= htmlspecialchars($clanek['title']) ?></h3>
                                    <p class="card__text">
                                        <?= htmlspecialchars(mb_strimwidth(strip_tags($clanek['text']), 0, 200, '...')) ?>
                                    </p>
                                </article>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <a href="./clanky.php" class="btn btn--center">Všechny články</a>

            </section>

            <section class="cards" id="o">
                <h2 class="title">Stručné představení</h2>
                <div class="predstaveni__uvod">
                    <div class="predstaveni__header">
                        <div class="predstaveni__img"><img class="img--responsiv" src="../../../public/img/prof.png" alt="Profilová fotografie autora a majite OnSite SEO pod lupou"></div>
                        <h3>Tomáš Pacák</h3>
                    </div>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nulla quis diam. Vivamus luctus egestas leo. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Nulla turpis magna, cursus sit amet, suscipit a, interdum id, felis.</p>
                    <div class="text--right">
                        <a href="#" class="btn">Více o mně</a>
                    </div>
                </div>
            </section>

            <section class="navrhy text--center">
                <h2>Máte zájem o spolupráci?</h2>
                <div>
                    <p class="navrhy__mail">OnSiteSEO@web.cz</p>
                    <div class="log__btns log__btns--kontakt">
                        <a class="btn" href="mailto:obchod@l3web.cz">Napsat Email</a>
                        <a class="btn" href="#">Služby</a>
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
                            <a class="footer__odkaz" href="../admin/clanek_create.php">Přidat</a>
                            <a class="footer__odkaz" href="../admin/clanky_edit_delete.php">Editace</a>
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
</body>
</html>