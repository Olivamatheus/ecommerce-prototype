<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login E-commerce POO</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="login-content">
        <div class="login-container">
            <h3>Identifique-se</h3>
            <div class="login-hr">
                <div class="login-dot-space">
                    <div class="login-dot"></div>
                </div>
            </div>
            <form action="login.php" method="POST">
                <label>
                    <input type="email" name="email" id="email" placeholder="E-mail" required>
                </label>
                
                <label>
                    <input type="password" name="senha" id="senha" placeholder="Senha" required>
                </label>
                <div class="login-hr">
                    <div class="login-dot-space">
                        <div class="login-dot"></div>
                    </div>
                </div>
                <button type="submit">Avançar</button>
            </form>

            <div class="linkCad">
                <a href="/DEV-PHP/loja-II/createAcc/index.php">
                    Fazer Cadastro
                </a>
            </div>
        </div>
    </div>

</body>
</html>