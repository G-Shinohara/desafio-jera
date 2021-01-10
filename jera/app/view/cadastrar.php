<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="public/style/cadastro.css">
</head>

<body>
    <form method="POST">
        <div id="box">
            <label for="email">Email:</label>
            <input type="text" name="email" id="email" required>
            <label for="password">Senha:</label>
            <input type="password" id="password" name="senha" pattern=".{4,}" required>
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" required>
            <label for="data_de_nascimento">Data de nascimento:</label>
            <input type="text" name="data_de_nascimento" id="data_de_nascimento" required>
            <button type="submit">Cadastrar</button>
            <a href="index.php?acao=entrar">Voltar</a>
        </div>
    </form>
</body>

</html>