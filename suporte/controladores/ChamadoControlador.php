<?php
require_once __DIR__ . "/../servicos/ChamadoServico.php";
require_once __DIR__ . "/../DTOs/ChamadoDTO.php";
require_once __DIR__ . "/../modelos/Chamado.php";

class ChamadoControlador {


    private function montarModelo($dto) {
        $chamado = new Chamado();
        $chamado->setId($dto->id);
        $chamado->setTitulo(trim($dto->titulo));
        $chamado->setSolicitante(trim($dto->solicitante));
        $chamado->setDescricao(trim($dto->descricao));
        $chamado->setPrioridade($dto->prioridade);
        $chamado->setStatus($dto->status);
        return $chamado;
    }

    public function salvar($dto) {
        $servico = new ChamadoServico();
        $servico->salvar($this->montarModelo($dto));
    }
    public function editar($dto) {
        $servico = new ChamadoServico();
        $servico->editar($this->montarModelo($dto));
    }
    public function excluir($id) {
        $servico = new ChamadoServico();
        $servico->excluir($id);
    }
    public function buscar($termo = '') {
        $servico = new ChamadoServico();
        return $servico->buscar($termo);
    }
    public function buscarPorId($id) {
        $servico = new ChamadoServico();
        return $servico->buscarPorId($id);
    }
}
