<!DOCTYPE html>
<html lang="en">
<?php
$nome = $data[0][1];
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $name ?></title>
    <link rel="stylesheet" href="public/style/lista.css">
</head>

<body>
    <div class="header">
        <?= $nome ?>
        <br>
        <button type="opcao" onclick="location.href='index.php?acao=loged'">Voltar</button>
    </div>
    <form method="post">
        <h1>Minha Lista:</h1>
        <?php for($i=0; $api[$i]; $i++){ ?>
            <div id="box">
                <?= $api[$i]->title ?>
                <br>
                <button type="submit" name="remover" value="<?=$api[$i]->id?>">Remover</button>
                <button type="submit" name="assistido" value="<?=$api[$i]->id?>">
                    <?php
                    if ($info[$i] == true){?>
                        Assistido
                    <?php }
                    else{?>
                        Marcar como Assistido
                    <?php }?>
                </button>
            </div>
        <?php } ?>
    </form>

</body>

</html>