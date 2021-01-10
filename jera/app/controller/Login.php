<?php
require 'Controller.php';
require 'app/model/Usuario.php';

class Login extends Controller {
    /**
    * @var Usuario
    */
    private $loggedUser;

    function __construct() {
        session_start();
        if (isset($_SESSION['user']))
            $this->loggedUser = $_SESSION['user'];
    }

    /**
     * Método responsavel pelo controle da tela de login
     */
    public function login() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $usuario = Usuario::buscar($_POST['email']);

            if(!is_null($usuario) && $usuario->igual($_POST['email'], $_POST['senha'])){
                $_SESSION['user'] = $this->loggedUser = $usuario;
            }

            if ($this->loggedUser) {
                header('Location: index.php?acao=perfis');
            } else {
                header('Location: index.php?acao=entrar');
            }
        }
        else {
            if (!$this->loggedUser)
                $this->view('login'); 
            else
                header('Location: index.php?acao=perfis');
        }
    }

    /**
     * Método responsavel pelo controle da tela de cadastro
     */
    public function cadastrar(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user = new Usuario($_POST['email'], $_POST['senha'], $_POST['nome'], $_POST['data_de_nascimento']);

            try {
                $user->salvar();
                echo "<script type='text/javascript'> alert('Email cadastrado com sucesso.');</script>";
            } catch (PDOException $erro) {
                echo "<script type='text/javascript'> alert('Não foi possivel realizar o cadastro!');</script>";
            }
        }
        $this->view('cadastrar');
    }

    /**
     * Método responsavel por encerrar a sessão
     */
    public function sair(){
        session_destroy();
        header('Location: index.php?acao=entrar');
    }

    /**
     * Método responsavel pelo controle da tela de celeção de perfil
     */
    public function perfis(){
        if (!$this->loggedUser) {
            echo "<script type='text/javascript'> alert('Você precisa se indentificar primeiro.');</script>";
            return;
        }
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if($_POST['nome']){
                try {
                    $this->loggedUser->novoPerfil($_POST['nome']);
                    echo "<script type='text/javascript'> alert('Perfil cadastrado com sucesso.');</script>";
                } catch(PDOException $erro){
                    echo "<script type='text/javascript'> alert('Não foi possivel realizar o cadastro!');</script>";
                }
            }
            else if ($_POST['perfil']) {
                $this->loggedUser->__set('perfil', $_POST['perfil']);
                header('Location: index.php?acao=loged');
            }
        }
        $this->view('perfis', $this->loggedUser->getPerfis());
    }

    /**
     * Método responsavel pelo congtrole da tela de opções do perfil logado
     */
    public function loged(){
        if (!$this->loggedUser) {
            echo "<script type='text/javascript'> alert('Você precisa se indentificar primeiro.');</script>";
            return;
        }
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            switch ($_POST['opcao']){
                case 'Buscar':
                    header('Location: index.php?acao=buscar');
                    break;
                
                case 'Minha Lista':
                    header('Location: index.php?acao=lista');
                    break;

                case 'Deletar Perfil':
                    $this->loggedUser->removePerfil();
                    header('Location: index.php?acao=perfis');
                    break;

                default:
            }
        }
        
        $this->view('loged', $this->loggedUser);    
    }

    /**
     * Método responsavel pelo controle da tela de busca de filmes
     */
    public function buscar(){
        if (!$this->loggedUser) {
            echo "<script type='text/javascript'> alert('Você precisa se indentificar primeiro.');</script>";
            return;
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if($_POST['busca'])
                $resultados = Api::busca($_POST['busca']);
            else if($_POST['opcao']){
                $info = Api::getInfo($_POST['opcao']);
            }
            else if($_POST['assistir']){
                try{
                    $this->loggedUser->addLista($_POST['assistir']);
                    echo "<script type='text/javascript'> alert('Filme adicionado com sucesso.');</script>";
                } catch(PDOException $erro){
                    echo "<script type='text/javascript'> alert('Não foi possivel adicionar o filme.');</script>";
                }
            }
        }
        
        $this->view('buscar', $this->loggedUser->getPerfil(), $resultados, $info);
    }

    /**
     * Método responsavel pelo controle da tela de lista de filmes do usuario logado
     */
    public function lista(){
        if (!$this->loggedUser) {
            echo "<script type='text/javascript'> alert('Você precisa se indentificar primeiro.');</script>";
            return;
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if($_POST['remover']){
                $this->loggedUser->removeLista($_POST['remover']);
            }
            else if($_POST['assistido']) {
                $this->loggedUser->setAssistido($_POST['assistido']);
            }
        }

        $lista = $this->loggedUser->getLista();
        $ids = array();
        $status = array(); 

        foreach($lista as $filme){
            $ids[] = $filme['id'];
            $status[] = $filme['assistido'];
        }
        foreach($ids as $id){
            $filmes[] = Api::getInfo($id);
        }

        $this->view('lista', $this->loggedUser->getPerfil(), $filmes, $status);
    }
}

?>