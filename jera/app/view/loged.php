<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data->perfil ?></title>
    <link rel="stylesheet" href="public/style/loged.css">
</head>

<body>
    <div class="header">
        <?= $data->perfil ?>
        <br>
        <form method="POST">
            <input type="submit" class="button" name="opcao" value="Buscar"></input>
            <input type="submit" class="button" name="opcao" value="Minha Lista"></input>
        </form>
        <button type="opcao" onclick="location.href='index.php?acao=perfil'">Voltar</button>
        <form method="POST">
            <?php if($data->nome != $data->perfil) {?>
                <input type="submit" class="button" name="opcao" value="Deletar Perfil"></input>
            <?php }?>
        </form>
    </div>
</body>

</html>