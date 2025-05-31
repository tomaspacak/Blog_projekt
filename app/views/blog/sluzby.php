<?php
session_start();

require_once '../../models/Database.php';


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
    <title>Služby - OnSite SEO pod lupou</title>
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
        </div>

        <div class="page__wrapper">
            <main>
                <h1>Služby</h1>
                <p>Nabízím praktická řešení pro malé firmy, tvůrce i jednotlivce, kteří chtějí být online vidět. Zaměřuji se na přehledný návrh webu, jeho funkční tvorbu i kvalitní obsah. Každý projekt přizpůsobuji konkrétním potřebám a pomáhám budovat důvěru i viditelnost ve vyhledávačích. Podívejte se, s čím vám mohu pomoci. O mně, mých zkušenostech a dovednostech si můžete <a class="link" href="#o">níže</a>.</p>

                <div class="sluzby">
                    <div class="sluzba">
                        <div class="sluzba__img">
                            <img class="img--responsiv" src="../../../public/img/webdesign_img800.jpg" alt="Obrázek na téma webdesign">
                        </div>
                        <div class="sluzba__text">
                            <h2 class="sluzba__title">Návrh webu</h2>
                            <p>Navrhuji weby, které nejsou jen hezké na pohled, ale především funkční a přívětivé pro návštěvníky. Využívám zásady UX designu, přehlednou strukturu a cílené prvky, které zvyšují konverze i důvěryhodnost. Každý návrh je připraven s ohledem na SEO a snadnou budoucí správu.</p>
                        </div>
                    </div>

                    <div class="sluzba">
                        <div class="sluzba__img">
                            <img class="img--responsiv" src="../../../public/img/tvorba_webu_img800.jpg" alt="Obrázek na téma webdesign">
                        </div>
                        <div class="sluzba__text">
                            <h2 class="sluzba__title">Tvorba webu</h2>
                            <p>Pomohu ti převést nápad do reality – vytvořím rychlý, responzivní a bezpečný web. Ať už jde o osobní blog, firemní prezentaci nebo osobní web, kód stavím na moderních technologiích a čistém HTML, CSS a PHP. Každý projekt optimalizuji pro vyhledávače i pro lidi.</p>
                        </div>
                    </div>

                    <div class="sluzba">
                        <div class="sluzba__img">
                            <img class="img--responsiv" src="../../../public/img/digital_content_img800.jpg" alt="Obrázek na téma webdesign">
                        </div>
                        <div class="sluzba__text">
                            <h2 class="sluzba__title">Tvorba obsahu</h2>
                            <p>Vytvářím digitální obsah, který přitáhne pozornost – od produktových fotografií přes jednoduché ikony a loga až po doprovodné texty. Vizuální prvky ladím s celkovým stylem webu a zajišťuji, aby byly funkční, estetické a připravené pro online prostředí. Důraz kladu na detail, konzistenci a přínos pro návštěvníka.</p>
                        </div>
                    </div>

                    <section class="navrhy text--center">
                    <h2>Máte zájem o spolupráci?</h2>
                    <div>
                        <p class="navrhy__mail">OnSiteSEO@web.cz</p>
                        <div class="log__btns log__btns--kontakt">
                            <a class="btn" href="mailto:obchod@l3web.cz">Napsat Email</a>
                        </div>
                    </div>

                </div>
            </main>

            <section>
            <h2 id="o">O mně</h2>
            <div class="clanek__content">
                <p>Jsem webový tvůrce, který spojuje design, funkčnost a smysl pro detail. Baví mě vytvářet weby, které nejen dobře vypadají, ale především dávají smysl lidem i vyhledávačům. Specializuji se na jednoduché, přehledné řešení – od návrhu až po finální realizaci a obsah.</p>
    
                <p>Věřím, že každý projekt si zaslouží individuální přístup. Rád pracuji s menšími firmami, živnostníky nebo začínajícími tvůrci, kterým pomáhám dostat se na internet srozumitelně a profesionálně.</p>

                <p>Když zrovna netvořím weby, zajímám se o online bezpečnost, vzdělávání a hledám nové cesty, jak zjednodušovat digitální svět.</p>

                <a class="btn btn--var2" href="../../../public/cv-tomas-pacak.pdf" download>
                    <i class="fa fa-download" aria-hidden="true"></i> Stáhnout životopis (PDF)
                </a>
            </div>
        </section>
            
        </div>

        

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
                            <a class="footer__odkaz" href="../admin/clanek_create.php">Přidat</a>
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