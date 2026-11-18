<?php

// Carregar a classe antes da sessão permite recuperar os objetos Chamado.
// Preparar a sessão, 
// criar o token e função textos.

require_once __DIR__ . "/../modelos/Chamado.php";
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
function h($valor)
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}
