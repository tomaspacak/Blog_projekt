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
    <title>Registrace - OnSite SEO pod lupou</title>
</head>
<body>
    <div class="log">
        <div class="log__wrapper">
            <div class="log__header">
                <h1 class="log__title text--center">Registrace</h1>
            </div>
            <div class="log__body text--right">
                <form action="../../controllers/register.php" method="post" id="registrationForm">
                    <div class="input__wrapper">
                        <input type="text" id="username" name="username" class="form-control" placeholder="HonzaN" required>
                        <label for="username" class="form-label">Uživatelské jméno:</label>
                    </div>

                    <div class="input__wrapper">
                        <input type="text" id="name" name="name" class="form-control" placeholder="Honza">
                        <label for="name" class="form-label">Jméno (nepovinné):</label>
                    </div>

                    <div class="input__wrapper">
                        <input type="text" id="surname" name="surname" class="form-control" placeholder="Novotný">
                        <label for="surname" class="form-label">Přijmení (nepovinné):</label>
                    </div>

                    <div class="input__wrapper">
                        <input type="text" id="email" name="email" class="form-control" placeholder="HonzaN@mail.cz">
                        <label for="email" class="form-label">Email (nepovinné):</label>
                    </div>

                    <div class="input__wrapper">
                        <input type="password" id="password" name="password" class="form-control" placeholder="********" required>
                        <label for="password" class="form-label">Heslo:</label>
                    </div>

                    <div class="input__wrapper">
                        <input type="text" id="password_confirm" name="password_confirm" class="form-control" placeholder="********" required>
                        <label for="password_confirm" class="form-label">Potvrzení hesla:</label>
                    </div>
                    <div id="passwordMatchMessage" class="warning d-none">
                        <p>Hesla se neshodují.</p>
                    </div>

                    <div class="log__btns">
                        <button type="submit" class="btn btn--log">Registrovat se</button>
                        <a class="btn btn--var2" href="./login.php">Přihlásit</a>
                    </div>
                    <a class="link link--log" href="../blog/index.php">Domů</a>
                    
                </form>
            </div>
        </div>

        

        

    </div>

    <!-- Kontrola hesel -->
    <script>
        const form = document.getElementById('registrationForm');
        const password = document.getElementById('password');
        const confirm = document.getElementById('password_confirm');
        const message = document.getElementById('passwordMatchMessage');
        
        form.addEventListener('submit', function (e) {
            if (password.value !== confirm.value) {
                e.preventDefault();
                message.classList.remove('d-none');
            } else {
                message.classList.add('d-none');
            }
        });
    </script>
    
    
</body>
</html>