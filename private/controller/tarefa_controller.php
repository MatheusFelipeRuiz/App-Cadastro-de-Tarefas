<?php
require_once '../private/model/Tarefa.php';
require_once '../private/service/TarefaService.php';
require_once '../private/config/ConexaoBD.php';



$conexao = new ConexaoBD();
$descricao = strlen(trim($_POST['tarefa'])) > 0 ? $_POST['tarefa'] : null;
$tarefa = new Tarefa($descricao);
$tarefaService = new TarefaService($conexao, $tarefa);

$acao = isset($_GET['acao']) ? $_GET['acao'] : $acao;
$tipoErro = null;
try {
    switch ($acao) {
        case 'cadastrar':
            $tipoErro = 'cadastro';
            $tarefaService->inserir();
            header('Location: nova_tarefa.php?cadastrado=1');
        case 'recuperar':
            $tipoErro = 'recuperar';
            $tarefas = $tarefaService->recuperar();
            break;
        case 'recuperar-pendentes':
            $tipoErro = 'recuperar-pendentes';
            $tarefas = $tarefaService->recuperarPendentes();
    }
} catch (PDOException $erro) {
    switch($tipoErro){
        case 'cadastro':
            header('Location: nova_tarefa.php?cadastrado=0');
    }
}
