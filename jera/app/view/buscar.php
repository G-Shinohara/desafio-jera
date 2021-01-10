<!DOCTYPE html>
<html lang="en">
<?php
$nome = $data[0][1];
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $nome ?></title>
    <link rel="stylesheet" href="public/style/buscar.css">
</head>

<body>
    <div class="header">
        <?= $nome ?>
        <br>
        <button type="opcao" onclick="location.href='index.php?acao=loged'">Voltar</button>
    </div>
    <form method="POST">
        <h1>Buscar Filme:</h1>
        <input type="text" name="busca" id="busca"></input>
        <button type="submit">Buscar</button>
    </form>
    <ul>
        <?php if ($api) { ?>
            <form method="POST">
                <?php foreach ($api as $resultado) { ?>
                    <button type="opcao" name="opcao" value="<?= $resultado->id?>"><?=$resultado->title?></button>
                <?php } ?>
            </form>
        <?php } ?>
        <?php if($info){
            echo nl2br('Titulo: ' . $info->title . "\n\n");
            echo nl2br('Sinopse: ' . $info->overview . "\n\n");
            echo nl2br('Data de Lançamento: ' . $info->release_date . "\n\n");
            echo nl2br('Generos:');
            foreach($info->genres as $genero){?>
                <li><?=$genero->name?></li>
            <?php }
            echo nl2br("\n");
            echo nl2br('Companias de produção:');
            foreach($info->production_companies as $compania){?>
                <li><?=$compania->name?></li>
            <?php }?>
            <form method="POST">
                <button type="submit" name="assistir" value="<?=$info->id?>">Adicionar a minha Lista</button>
            </form>
        <?php }?>
    </ul>
    
</body>

</html>