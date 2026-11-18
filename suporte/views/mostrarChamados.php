<?php
require_once __DIR__ . '/auxiliares.php';
if (!isset($_SESSION['chamados'])) {
    header('Location: ../controladores/buscarChamados.php');
    exit;
}
$chamados = $_SESSION['chamados'];
$termo = $_SESSION['termo'] ?? '';
$mensagem = $_SESSION['mensagem'] ?? '';
unset($_SESSION['mensagem']);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chamados de suporte</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <main class="container"><a href="../index.html">← Início</a>
        <div class="cabecalho">
            <h1>Chamados de suporte</h1><a class="botao" id="novo-chamado" href="formCadastrarChamado.php">Novo chamado</a>
        </div>
        <?php if ($mensagem !== ''): ?><p class="sucesso" id="mensagem" role="status"><?= h($mensagem) ?></p><?php endif; ?>
        <form class="busca" action="../controladores/buscarChamados.php" method="GET">
            <label for="termo">Buscar por título ou solicitante</label>
            <div class="acoes"><input id="termo" name="termo" value="<?= h($termo) ?>" placeholder="Digite sua busca"><button id="buscar" type="submit">Buscar</button><a href="../controladores/buscarChamados.php">Limpar</a></div>
        </form>
        <p id="quantidade"><?= count($chamados) ?> chamado(s) encontrado(s).</p>
        <div class="tabela">
            <table id="tabela-chamados">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título / descrição</th>
                        <th>Solicitante</th>
                        <th>Prioridade</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($chamados as $chamado): ?>
                        <tr data-id="<?= h($chamado->getId()) ?>">
                            <td><?= h($chamado->getId()) ?></td>
                            <td class="titulo"><strong><?= h($chamado->getTitulo()) ?></strong><small><?= h($chamado->getDescricao()) ?></small></td>
                            <td class="solicitante"><?= h($chamado->getSolicitante()) ?></td>
                            <td class="prioridade"><?= h($chamado->getPrioridade()) ?></td>
                            <td class="status"><?= h($chamado->getStatus()) ?></td>
                            <td>
                                <div class="acoes"><a class="editar" href="../controladores/rota.php?acao=formEditar&amp;id=<?= h($chamado->getId()) ?>">Editar</a>
                                    <form action="../controladores/excluirChamado.php" method="POST" onsubmit="return confirm('Excluir este chamado?');">
                                        <input type="hidden" name="token" value="<?= h($_SESSION['token']) ?>"><input type="hidden" name="id" value="<?= h($chamado->getId()) ?>"><button type="submit" class="excluir">Excluir</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (count($chamados) === 0): ?><tr>
                            <td colspan="6" id="sem-resultados">Nenhum chamado encontrado.</td>
                        </tr><?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>