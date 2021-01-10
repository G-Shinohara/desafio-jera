<?php
include_once("DB.php");
include_once("Api.php");

class Usuario{
    private $email;
    private $senha;
    private $nome;
    private $data_de_nascimento;
    private $perfil;

    function __construct(string $email, string $senha, string $nome, string $data_de_nascimento) {
        $this->email = $email;
        $this->senha = $senha;
        $this->nome = $nome;
        $this->data_de_nascimento = $data_de_nascimento;
        $this->perfil = null;
    }

    /**
     * get generioco
     */
    public function __get($campo) {
        return $this->$campo;
    }

    /**
     * set generico
     */
    public function __set($campo, $valor) {
        return $this->$campo = $valor;
    }

    /**
     *   Método que verifica se o email e senha providos são iguais ao da instância.
     *
     *   @return bool Retorna TRUE se igual, senão FALSE
     */
    public function igual(string $email, string $senha){
        return $this->email === $email && $this->senha === $senha;
    }

    /** 
     * Método que salva os dados de um usuário no banco.
     */
    public function salvar(){
        $db = DB::getInstance();
        $stmt = $db->prepare('INSERT INTO usuarios (email, senha, nome, data_de_nascimento) VALUES (:email, :senha, :nome, :data_de_nascimento)');
        $stmt->bindValue(':email', $this->email);
        $stmt->bindValue(':senha', $this->senha);
        $stmt->bindValue(':nome', $this->nome);
        $stmt->bindValue(':data_de_nascimento', $this->data_de_nascimento);
        $stmt->execute();

        $stmt = $db->prepare('INSERT INTO perfis (email, nome) VALUES (:email, :nome)');
        $stmt->bindValue(':email', $this->email);
        $stmt->bindValue(':nome', $this->nome);
        $stmt->execute();
    }

    /**
     * Método que retorna informações de um email cadastrado no banco
     */
    public static function buscar(string $email){
        $db = DB::getInstance();

        $stmt = $db->prepare('SELECT * FROM usuarios WHERE email = :email');
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        $resultado = $stmt->fetch();

        if ($resultado) {
            $usuario = new Usuario($resultado['email'], $resultado['senha'], $resultado['nome'], $resultado['data_de_nascimento']);
            $usuario->senha = $resultado['senha'];
            return $usuario;
        } else {
            return NULL;
        }
    }

    /**
     * Método que retorna informações dos perfis do usuario logado
     */
    public function getPerfis() {
        $db = DB::getInstance();

        $stmt = $db->prepare('SELECT nome FROM perfis WHERE email = :email');
        $stmt->bindValue(':email', $this->email);
        $stmt->execute();
        
        $resultado = $stmt->fetchAll();
        $perfis = array();

        foreach($resultado as $perfil)
            $perfis[] = $perfil['nome'];
        
        return $perfis;
    }

    /**
     * Método que retorna informação do perfil logado
     */
    public function getPerfil() {
        $db = DB::getInstance();

        $stmt = $db->prepare('SELECT * FROM perfis WHERE email = :email AND nome = :nome');
        $stmt->bindValue(':email', $this->email);
        $stmt->bindValue(':nome', $this->perfil);
        $stmt->execute();

        $resultado = $stmt->fetchAll();

        return $resultado;
    }

    /**
     * Método que cria um novo perfil na conta do usuario logado
     */
    public function novoPerfil(string $nome) {
        $db = DB::getInstance();

        $stmt = $db->prepare('INSERT INTO perfis (email, nome) VALUES (:email, :nome)');
        $stmt->bindValue(':email', $this->email);
        $stmt->bindValue(':nome', $nome);
        $stmt->execute();
    }

    /**
     * Método que deleta o perfil logado junto com sua lista de filmes
     */
    public function removePerfil() {
        $db = DB::getInstance();

        $stmt = $db->prepare('DELETE FROM assistir WHERE email = :email AND nome = :nome');
        $stmt->bindValue(':email', $this->email);
        $stmt->bindValue(':nome', $this->perfil);
        $stmt->execute();

        $stmt = $db->prepare('DELETE FROM perfis WHERE email = :email AND nome = :nome');
        $stmt->bindValue(':email', $this->email);
        $stmt->bindValue(':nome', $this->perfil);
        $stmt->execute();
    }

    /**
     * Método para adicionar um filme a lista do perfil logado
     */
    public function addLista(string $id){
        $db = DB::getInstance();

        $stmt = $db->prepare('INSERT INTO assistir (email, nome, id, assistido) VALUES (:email, :nome, :id, :assistido)');
        $stmt->bindValue(':email', $this->email);
        $stmt->bindValue(':nome', $this->perfil);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':assistido', 0);
        $stmt->execute();
    }

    /**
     * Método que retorna a lista de filmes do perfil logado
     */
    public function getLista(){
        $db = DB::getInstance();

        $stmt = $db->prepare('SELECT id, assistido FROM assistir WHERE email = :email AND nome = :nome');
        $stmt->bindValue(':email', $this->email);
        $stmt->bindValue(':nome', $this->perfil);
        $stmt->execute();

        $resultado = $stmt->fetchAll();
        return $resultado;
    }

    /**
     * Método que remove um filme da lista de filmes do perfil logado
     */
    public function removeLista(string $id){
        $db = DB::getInstance();

        $stmt = $db->prepare('DELETE FROM assistir WHERE email = :email AND nome = :nome AND id = :id');
        $stmt->bindValue(':email', $this->email);
        $stmt->bindValue(':nome', $this->perfil);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }

    /**
     * Método que atualiza o estatus de assistido de um filme
     */
    public function setAssistido(string $id){
        $db = DB::getInstance();

        $stmt = $db->prepare('UPDATE assistir SET assistido = :assistido WHERE email = :email AND nome = :nome AND id = :id');
        $stmt->bindValue(':email', $this->email);
        $stmt->bindValue(':nome', $this->perfil);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':assistido', 1);
        $stmt->execute();
    }
}
?>
