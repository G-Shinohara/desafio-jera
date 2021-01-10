<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);

include_once('app/model/DB.php');
Db::createSchema();

include_once('app/controller/Login.php');
$controller = new Login();


switch ($_GET['acao']){
    case 'cadastrar':
        $controller->cadastrar();
        break;

    case 'perfis':
        $controller->perfis();
        break;
    
    case 'sair':
        $controller->sair();
        break;

    case 'loged':
        $controller->loged();
        break;

    case 'buscar':
        $controller->buscar();
        break;
    
    case 'lista':
        $controller->lista();
        break;
    
    default:
        $controller->login();
}
?>