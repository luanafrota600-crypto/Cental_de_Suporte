<?php
class Chamado {
    private $id;
    private $titulo;
    private $solicitante;
    private $descricao;
    private $prioridade;
    private $status;

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getTitulo() { return $this->titulo; }
    public function setTitulo($titulo) { $this->titulo = $titulo; }

    public function getSolicitante() { return $this->solicitante; }
    public function setSolicitante($solicitante) { $this->solicitante = $solicitante; }

    public function getDescricao() { return $this->descricao; }
    public function setDescricao($descricao) { $this->descricao = $descricao; }

    public function getPrioridade() { return $this->prioridade; }
    public function setPrioridade($prioridade) { $this->prioridade = $prioridade; }

    public function getStatus() { return $this->status; }
    public function setStatus($status) { $this->status = $status; }
}
