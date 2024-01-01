<?php


class TarefaService
{
    private $tarefa;
    private $conexao;

    public function __construct(ConexaoBD $conexao, Tarefa $tarefa)
    {
        $this->tarefa = $tarefa;
        $this->conexao = $conexao->conectar();
    }

    public function inserir()
    {
        $query = 'INSERT INTO tb_tarefas (tarefa) VALUES (:tarefa)';
        $stmt =  $this->conexao->prepare($query);
        $stmt->bindValue(':tarefa', $this->tarefa->__get('tarefa'));
        $stmt->execute();
    }

    public function recuperar()
    {
        $query =
        'SELECT
            tbt.id,
            tbt.tarefa,
            tbs.status,
            tbt.data_cadastrado
        FROM
            tb_tarefas tbt
        LEFT JOIN tb_status tbs ON
            tbs.id = tbt.id_status;';

        $stmt = $this->conexao->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function recuperarPendentes(){
        $query =
        'SELECT
	        tbt.tarefa,
	        tbs.status,
	        tbt.data_cadastrado
        FROM
	        tb_tarefas tbt
        LEFT JOIN tb_status tbs ON
	        tbs.id = tbt.id_status
	    WHERE tbt.id_status = (:id)
        ';

        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':id',1);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function atualizar()
    {
        $query = 'UPDATE tb_tarefas SET tarefa = :tarefa WHERE id = :idTarefa';

        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':tarefa',$this->tarefa->tarefa);
        $stmt->bindValue(':idTarefa',$this->tarefa->id);
        return $stmt->execute();
    }

    public function remover()
    {
        $query = 'DELETE FROM tb_tarefas WHERE id = :idTarefa';
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':idTarefa',$this->tarefa->id);
        $stmt->execute();
    }
}
