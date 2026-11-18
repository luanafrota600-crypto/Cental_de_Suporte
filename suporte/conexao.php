<?php
class Conexao {
    static public function criar() {
        $conn = new PDO("mysql:host=localhost;port=3306;dbname=suporte;charset=utf8mb4", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        return $conn;
    }
}
