<?php
abstract class Controller {
    /**
     * Método para celecionar a view desejada
     */
    public function view(string $view, $data = [], $api = [], $info = []){
        require 'app/view/' . $view . '.php';
    }
}
?>