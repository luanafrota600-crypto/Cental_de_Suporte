<?php
require_once __DIR__ . "/../modelos/Chamado.php";

class ChamadoDAO {
    public function salvar($chamado, $conn) {
        $sql = "INSERT INTO chamados (titulo, solicitante, descricao, prioridade, status) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute($this->valores($chamado));
    }

    public function editar($chamado, $conn) {
        $sql = "UPDATE chamados SET titulo = ?, solicitante = ?, descricao = ?, prioridade = ?, status = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $valores = $this->valores($chamado);
        $valores[] = $chamado->getId();
        $stmt->execute($valores);
    }

    public function excluir($id, $conn) {
        $stmt = $conn->prepare("DELETE FROM chamados WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function buscar($conn, $termo = '') {
        // Busca por título ou solicitante. Sem termo, lista todos.
        $sql = "SELECT * FROM chamados";
        $parametros = [];
        if ($termo !== '') {
            $sql .= " WHERE titulo LIKE ? OR solicitante LIKE ?";
            $parametros = ['%' . $termo . '%', '%' . $termo . '%'];
        }
        $sql .= " ORDER BY id DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute($parametros);
        $chamados = [];
        foreach ($stmt->fetchAll(PDO::FETCH_OBJ) as $registro) {
            $chamados[] = $this->montarModelo($registro);
        }
        return $chamados;
    }

    public function buscarPorId($id, $conn) {
        $stmt = $conn->prepare("SELECT * FROM chamados WHERE id = ?");
        $stmt->execute([$id]);
        $registro = $stmt->fetch(PDO::FETCH_OBJ);
        return $registro ? $this->montarModelo($registro) : null;
    }

    private function valores($chamado) {
        return [$chamado->getTitulo(), $chamado->getSolicitante(), $chamado->getDescricao(),
                $chamado->getPrioridade(), $chamado->getStatus()];
    }

    private function montarModelo($registro) {
        $chamado = new Chamado();
        $chamado->setId($registro->id);
        $chamado->setTitulo($registro->titulo);
        $chamado->setSolicitante($registro->solicitante);
        $chamado->setDescricao($registro->descricao);
        $chamado->setPrioridade($registro->prioridade);
        $chamado->setStatus($registro->status);
        return $chamado;
    }
}
