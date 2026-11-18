<?php
require_once __DIR__ . "/ChamadoControlador.php";
require_once __DIR__ . "/../views/auxiliares.php";

$acao = $_GET['acao'] ?? '';
$controlador = new ChamadoControlador();
//dto e entrega ao controlador
function lerId($valor) {
    $id = filter_var($valor, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    if ($id === false) { throw new ChamadoException("Identificador inválido."); }
    return $id;
}

try {
    if ($acao === 'formEditar') {
        $id = lerId($_GET['id'] ?? '');
        $_SESSION['chamadoEdicao'] = $controlador->buscarPorId($id);
        header('Location: ../views/formEditarChamado.php');
        exit;
    }

    // Alterações no banco.
    if (!in_array($acao, ['salvar', 'editar', 'excluir'], true)) {
        throw new ChamadoException("Ação inválida.");
    }
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new ChamadoException("Use o formulário para realizar esta operação.");
    }
    if (!isset($_POST['token']) || !is_string($_POST['token']) || !hash_equals($_SESSION['token'], $_POST['token'])) {
        throw new ChamadoException("Formulário inválido. Atualize a página e tente novamente.");
    }

    if ($acao === 'excluir') {
        $controlador->excluir(lerId($_POST['id'] ?? ''));
        $_SESSION['mensagem'] = 'Chamado excluído com sucesso.';
    } else {
        
        $dto = new ChamadoDTO();
        $dto->id = $acao === 'editar' ? lerId($_POST['id'] ?? '') : null;
        foreach (['titulo', 'solicitante', 'descricao', 'prioridade', 'status'] as $campo) {
            if (!is_string($_POST[$campo] ?? '')) { throw new ChamadoException("Dados inválidos."); }
            $dto->$campo = $_POST[$campo] ?? '';
        }
        if ($acao === 'salvar') {
            $controlador->salvar($dto);
            $_SESSION['mensagem'] = 'Chamado cadastrado com sucesso.';
        } else {
            $controlador->editar($dto);
            $_SESSION['mensagem'] = 'Chamado atualizado com sucesso.';
        }
        unset($_SESSION['chamadoEdicao']);
    }
    // Reconsulta o banco: evita mostrar uma lista antiga guardada na sessão.
    header('Location: buscarChamados.php');
    exit;
} catch (PDOException $erro) {
    error_log($erro->getMessage());
    $mensagem = 'Erro ao acessar o banco. Verifique o MySQL, a importação de suporte.sql e conexao.php.';
} catch (ChamadoException $erro) {
    $mensagem = $erro->getMessage();
}
http_response_code(400);
?>
<!DOCTYPE html>
<html lang="pt-BR"><head><meta charset="UTF-8"><title>Não foi possível concluir</title><link rel="stylesheet" href="../css/style.css"></head>
<body><main class="container"><h1>Não foi possível concluir</h1><p class="erro" id="erro"><?= h($mensagem) ?></p><p>Volte pelo navegador para corrigir o formulário.</p><a href="buscarChamados.php">Voltar para os chamados</a></main></body></html>
