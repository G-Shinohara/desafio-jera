<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="public/style/login.css">
</head>

<body>
    <form method="POST">
        <div id="box">
            <label for="email">Email:</label>
            <input type="text" name="email" id="email" required>
            <label for="password">Senha:</label>
            <input type="password" id="password" name="senha" pattern=".{4,}" required>
            <button type="submit">Login</button>
            <a href="index.php?acao=cadastrar">Crie um cadastro</a>
        </div>
    </form>
</body>

</html>