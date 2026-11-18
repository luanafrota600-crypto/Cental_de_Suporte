<?php
require_once __DIR__ . "/ChamadoControlador.php";
require_once __DIR__ . "/../views/auxiliares.php";
try {
    $termo = $_GET['termo'] ?? '';
    if (!is_string($termo)) {
        throw new ChamadoException("Busca inválida.");
    }
    $termo = trim($termo);
    $controlador = new ChamadoControlador();

    $_SESSION['chamados'] = $controlador->buscar($termo);
    $_SESSION['termo'] = $termo;
    header('Location: ../views/mostrarChamados.php');
    exit;
} catch (PDOException $erro) {
    error_log($erro->getMessage());
    http_response_code(500);
    echo 'Erro ao acessar o banco. Inicie o MySQL e importe suporte.sql. Confira conexao.php.';
} catch (ChamadoException $erro) {
    http_response_code(400);
    echo h($erro->getMessage());
}
