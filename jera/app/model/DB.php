<?php

final class DB{
    private static $conexao;

    private function __construct(){}

    /**
     * Método que retorna a conexão com o banco de dados
     */
    public static function getInstance() {
        if (is_null(self::$conexao)) {
            self::$conexao = new PDO('mysql:host=localhost;dbname=id15886342_jera', 'id15886342_root', 'V!-}3%OLKnJu]YTX');
            self::$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$conexao;
    }

    /**
     * Método que cria as tabelas do banco de dados
     */
    public static function createSchema() {
        $db = self::getInstance();
        $db->exec('
        CREATE TABLE IF NOT EXISTS usuarios (
            email VARCHAR (100) PRIMARY KEY,
            senha VARCHAR (100),
            nome VARCHAR (100),
            data_de_nascimento VARCHAR (100)
        );
        ');
        $db->exec('
        CREATE TABLE IF NOT EXISTS perfis (
            email VARCHAR (100),
            nome VARCHAR (100),
            FOREIGN KEY (email) 
                REFERENCES usuarios(email) 
                ON DELETE CASCADE,
            CONSTRAINT perfil_key PRIMARY KEY (email,nome)
        );
        ');
        $db->exec('
        CREATE TABLE IF NOT EXISTS assistir(
            email VARCHAR (100),
            nome VARCHAR (100),
            id VARCHAR (10),
            assistido BOOLEAN,
            FOREIGN KEY (email) 
                REFERENCES perfis(email) 
                ON DELETE CASCADE,
            FOREIGN KEY (nome)
                REFERENCES perfis(nome)
                ON DELETE CASCADE,
            CONSTRAINT assistir_key PRIMARY KEY (email,nome,id)
        );
        ');
    }
}
?>