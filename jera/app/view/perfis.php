<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfis</title>
    <link rel="stylesheet" href="public/style/perfis.css">
</head>

<body>
    <div id="box">
        <label for="perfis">Perfis:</label>
        <?php foreach ($data as $perfil) { ?>
            <form id="form_1" method="POST">
                <input type="submit" name="perfil" id="perfil" value="<?= $perfil ?>"></input>
            </form>
        <?php } ?>
        <?php if (count($data) < 4) { ?>
            <form id="form_2" method="POST">
                <input type="text" name="nome" id="nome" placeholder="Novo Perfil" required></input>
                <button type="submit">Adicionar</button>
            </form>
        <?php } ?>
        <a href="index.php?acao=sair">Sair</a>
    </div>
</body>

</html>