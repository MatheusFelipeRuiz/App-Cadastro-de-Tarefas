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

    public function atualizar()
    {
    }

    public function remover()
    {
    }
}
