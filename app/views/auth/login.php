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
    <title>Login - OnSite SEO pod lupou</title>
</head>
<body>
    <div class="log log--l">
        <div class="log__wrapper">
            <div class="log__header">
                <h1 class="log__title text--center">Přihlášení uživatele</h1>
            </div>
            <div class="log__body text--right">
                <form action="../../controllers/login.php" method="post">
                    <div class="input__wrapper">
                        <input type="text" id="username" name="username" class="form-control" placeholder="HonzaN" required>
                        <label for="username" class="form-label">Uživatelské jméno:</label>
                    </div>

                    <div class="input__wrapper">
                        <input type="password" id="password" name="password" class="form-control" placeholder="********" required>
                        <label for="password" class="form-label">Heslo:</label>
                    </div>
                    <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
                        <div class="warning">Neplatné přihlašovací údaje.</div>
                    <?php endif; ?>
                    <div class="log__btns">
                        <button type="submit" class="btn btn--log">Přihlásit se</button>
                        <a class="btn btn--var2" href="./register.php">Registrace</a>
                    </div>
                    <a class="link link--log" href="../blog/index.php">Domů</a>
                    
                </form>
            </div>
        </div>

        

        

    </div>

    
    
</body>
</html>