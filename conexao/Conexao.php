<?php
class Conexao {
    private static $instance;

    public static function getInstance() {
        if (!isset(self::$instance)) {
            try {
                // Substitua estes valores pelas suas configurações
                self::$instance = new PDO('mysql:host=localhost;dbname=nome_do_banco', 'usuario', 'senha');
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo 'Erro na conexão: ' . $e->getMessage();
            }
        }
        return self::$instance;
    }
}
?>