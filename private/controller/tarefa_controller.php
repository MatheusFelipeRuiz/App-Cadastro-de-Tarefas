<?php
require_once '../private/model/Tarefa.php';
require_once '../private/service/TarefaService.php';
require_once '../private/config/ConexaoBD.php';

try {
    $descricao = strlen(trim($_POST['tarefa'])) > 0 ? $_POST['tarefa'] : null;
    $tarefa = new Tarefa($descricao);
    $conexao = new ConexaoBD();

    $tarefaService = new TarefaService($conexao, $tarefa);

    $tarefaService->inserir();
    header('Location: nova_tarefa.php?cadastrado=1');

} catch (PDOException $erro) {
    header('Location: nova_tarefa.php?cadastrado=0');
}
