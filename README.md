# On-site SEO pod lupou

Blog zaměřený na praktické aspekty **on-site SEO**, který slouží jako ukázka mých dovedností v oblasti webového vývoje, návrhu UX a základní bezpečnosti.  
Projekt je vytvořen pomocí **PHP, MySQL, HTML, CSS a JavaScriptu**. Web je **plně responzivní** a celý jeho **design jsem navrhl sám**.

> 🛠️ **Profesionální blogový systém** s vlastním MVC frameworkem, který simuluje reálné nasazení: od návrhu databáze, přes vývoj backendu a frontend UI, až po administraci obsahu a základní bezpečnostní opatření.

---
![náhled webu](/public/img/nahled.png)

## 🔍 Proč tento projekt?

- ✅ **Full-stack zkušenosti** – návrh a realizace backendu, databáze i UI
- 🎨 **UX a design** – čisté, přístupné a responzivní uživatelské prostředí
- 🔐 **Bezpečnostní standardy** – ošetření SQL Injection, XSS, validace vstupů
- 🧩 **Reálný obsah** – odborné články o SEO s více zdroji a obrázky

---

## Funkce

### 🧑‍💼 Redakční systém (admin)

- 📝 **Přidávání článků** – WYSIWYG editor, více obrázků a odkazů
- ✏️ **Editace a mazání článků**
- 👤 **Správa uživatelů** – změna rolí, mazání účtů
- 💬 **Správa komentářů** – moderování diskusí

### 👥 Uživatelská část

- 🔐 **Registrace / přihlášení**
- 💬 **Přidávání komentářů k článkům** (pouze pro přihlášené)
- 📰 **Přehled článků** s náhledem obsahu
- 📱 **Responzivní UI/UX** – přizpůsobeno mobilním zařízením

### ⚙️ Implementační detaily

- 🧱 **Vlastní MVC framework** bez externích knihoven
- ⚡ **SEO optimalizace výkonu** – lazy loading obrázků, minifikace assetů
- 🔐 **Bezpečnostní prvky**:
  - Prepared statements proti SQL injection
  - XSS sanitizace vstupů
  - Session management
  - Rozdělení práv admin / uživatel

---

## 💻 Použité technologie

| Vrstva           | Technologie                  |
|------------------|------------------------------|
| Backend          | PHP 8+, MySQL                |
| Architektura     | Vlastní MVC (model-view-controller) |
| Frontend         | HTML5, CSS3, JavaScript      |
| Databáze         | MySQL – tabulky `users`, `articles`, `comments` |
| Stylování        | Vlastní CSS bez frameworku   |
| UX návrh         | Navrženo mnou – mobil-first  |

---
