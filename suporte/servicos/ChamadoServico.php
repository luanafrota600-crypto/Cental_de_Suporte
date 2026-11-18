<?php
require_once __DIR__ . "/../DAOs/ChamadoDAO.php";
require_once __DIR__ . "/../conexao.php";
require_once __DIR__ . "/../ChamadoException.php";
//validar
//abri a conrxao
//chamar o DAO
class ChamadoServico {
    private function validar($chamado) {
        if (trim($chamado->getTitulo()) === '' || trim($chamado->getSolicitante()) === '' || trim($chamado->getDescricao()) === '') {
            throw new ChamadoException("Preencha título, solicitante e descrição.");
        }
        if (preg_match_all('/./us', $chamado->getTitulo()) > 150 || preg_match_all('/./us', $chamado->getSolicitante()) > 100 || preg_match_all('/./us', $chamado->getDescricao()) > 5000) {
            throw new ChamadoException("Título: até 150 caracteres; solicitante: até 100; descrição: até 5000.");
        }
        if (!in_array($chamado->getPrioridade(), ['Baixa', 'Média', 'Alta'], true)) {
            throw new ChamadoException("Selecione uma prioridade válida.");
        }
        if (!in_array($chamado->getStatus(), ['Aberto', 'Em andamento', 'Resolvido'], true)) {
            throw new ChamadoException("Selecione um status válido.");
        }
    }

    public function salvar($chamado) {
        $this->validar($chamado);
        $conn = Conexao::criar();
        $dao = new ChamadoDAO();
        $dao->salvar($chamado, $conn);
    }

    public function editar($chamado) {
        $this->validar($chamado);
        $conn = Conexao::criar();
        $dao = new ChamadoDAO();
        if (!$dao->buscarPorId($chamado->getId(), $conn)) {
            throw new ChamadoException("Chamado não encontrado.");
        }
        $dao->editar($chamado, $conn);
    }

    public function excluir($id) {
        $conn = Conexao::criar();
        $dao = new ChamadoDAO();
        if (!$dao->buscarPorId($id, $conn)) {
            throw new ChamadoException("Chamado não encontrado.");
        }
        $dao->excluir($id, $conn);
    }

    public function buscar($termo = '') {
        $conn = Conexao::criar();
        $dao = new ChamadoDAO();
        return $dao->buscar($conn, $termo);
    }

    public function buscarPorId($id) {
        $conn = Conexao::criar();
        $dao = new ChamadoDAO();
        $chamado = $dao->buscarPorId($id, $conn);
        if (!$chamado) { throw new ChamadoException("Chamado não encontrado."); }
        return $chamado;
    }
}

