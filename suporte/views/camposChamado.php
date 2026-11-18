<?php
// O mesmo conjunto de campos é usado no cadastro e na edição.
$titulo = isset($chamado) ? $chamado->getTitulo() : '';
$solicitante = isset($chamado) ? $chamado->getSolicitante() : '';
$descricao = isset($chamado) ? $chamado->getDescricao() : '';
$prioridade = isset($chamado) ? $chamado->getPrioridade() : 'Baixa';
$status = isset($chamado) ? $chamado->getStatus() : 'Aberto';
?>

<input type="hidden" name="token" value="<?= h($_SESSION['token']) ?>">
<label for="titulo">Título</label>
<input id="titulo" name="titulo" maxlength="150" value="<?= h($titulo) ?>" required>
<label for="solicitante">Solicitante</label>
<input id="solicitante" name="solicitante" maxlength="100" value="<?= h($solicitante) ?>" required>
<label for="descricao">Descrição do problema</label>
<textarea id="descricao" name="descricao" maxlength="5000" rows="4" required><?= h($descricao) ?></textarea>
<div class="grade">
    <div><label for="prioridade">Prioridade</label><select id="prioridade" name="prioridade">
            <?php foreach (['Baixa', 'Média', 'Alta'] as $opcao): ?>
                <option value="<?= h($opcao) ?>" <?= $prioridade === $opcao ? 'selected' : '' ?>><?= h($opcao) ?></option>
            <?php endforeach; ?>
        </select></div>
    <div><label for="status">Status</label><select id="status" name="status">
            <?php foreach (['Aberto', 'Em andamento', 'Resolvido'] as $opcao): ?>
                <option value="<?= h($opcao) ?>" <?= $status === $opcao ? 'selected' : '' ?>><?= h($opcao) ?></option>
            <?php endforeach; ?>
        </select></div>
</div>
<div class="acoes"><button id="salvar" type="submit">Salvar chamado</button><a href="../controladores/buscarChamados.php">Cancelar</a></div>