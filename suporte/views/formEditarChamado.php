<?php
require_once __DIR__ . '/auxiliares.php'; 
if (!isset($_SESSION['chamadoEdicao']) || !($_SESSION['chamadoEdicao'] instanceof Chamado)) {
    header('Location: ../controladores/buscarChamados.php');
    exit;
}
$chamado = $_SESSION['chamadoEdicao'];
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar chamado</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <main class="container formulario"><a href="../controladores/buscarChamados.php">← Chamados</a>
        <h1>Editar chamado #<?= h($chamado->getId()) ?></h1>
        <form action="../controladores/rota.php?acao=editar" method="POST">
            <input type="hidden" name="id" value="<?= h($chamado->getId()) ?>">
            <?php require __DIR__ . '/camposChamado.php'; ?>
        </form>
    </main>
</body>

</html>