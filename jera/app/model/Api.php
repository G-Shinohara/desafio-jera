<?php
final class Api{    
    private static $apiKey = 'da5862986e4f860f23759beb5bd2bc2b';

    private function __construct(){}
        
    /**
     * Método que retorna os ids dos filmes relacionados a pesquisa por texto
     */
    private static function getId(string $name){
        for($i=0; $name[$i]; $i++){
            if($name[$i] == ' ')
                $name[$i] = '-';
        }
        $url = 'https://api.themoviedb.org/3/search/movie?api_key=' . self::$apiKey . '&query=' . $name;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $resultados = json_decode(curl_exec($ch));
        $lista = array();
        foreach ($resultados->results as $resultado)
            $lista[] = $resultado->id;
        return $lista;
    }

    /**
     * Método que retorna informações de um filme dado seu id
     */
    public static function getInfo($id){
        $url = 'https://api.themoviedb.org/3/movie/' . $id . '?api_key=' . self::$apiKey . '&leguage=pt-br';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $resultados = json_decode(curl_exec($ch));
        return $resultados;
    }

    /**
     * Método que a partir de uma pesquisa de texto, retorna as informações de todos os filmes relacionados
     */
    public static function busca(string $nome){
        $ids = Api::getId($nome);
        $info = array();
        foreach ($ids as $id) {
            $info[] = Api::getInfo($id);
        }
        return $info;
    }
}
?>