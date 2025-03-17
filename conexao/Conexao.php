<?php
class Conexao {
    private static $instance;

    public static function getConn() {
        if (!isset(self::$instance)) {
            try {
                self::$instance = new PDO('mysql:host=localhost;dbname=NOME_DO_BANCO', 'usuario', 'senha');
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Erro ao conectar com o banco de dados: ' . $e->getMessage());
            }
        }
        return self::$instance;
    }
}
?>