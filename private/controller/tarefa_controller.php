<?php
require_once '../private/model/Tarefa.php';
require_once '../private/service/TarefaService.php';
require_once '../private/config/ConexaoBD.php';




$descricao = strlen(trim($_POST['tarefa'])) > 0 ? $_POST['tarefa'] : $descricao;
$descricao = isset($_GET['descricao']) ? $_GET['descricao'] : $descricao;
$id = isset($_POST['id']) ? $_POST['id'] : null;

$conexao = new ConexaoBD();
$tarefa = new Tarefa($descricao);
$tarefa->id = $id;
$tarefa->idStatus = 1;
$tarefaService = new TarefaService($conexao, $tarefa);


$acao = isset($_GET['acao']) ? $_GET['acao'] : $acao;
$tipoErro = null;
$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : $pagina;

function definirPaginaDestino($pagina){
    switch ($pagina) {
        case 'index':
            header('Location: index.php');
            break;
        case 'todas-tarefas':
            header('Location: todas_tarefas.php');
            break;
    }
}

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
            break;
        case 'atualizar':


            $tipoErro = 'atualizar';
            $operacaoConcluida = $tarefaService->atualizar();
            if ($operacaoConcluida) {
                definirPaginaDestino($pagina);
            }
            break;
        case 'remover':
            $tipoErro = 'remover';
            $operacaoConcluida = $tarefaService->remover();
            definirPaginaDestino($pagina);
            break;
        case 'concluir':
            $tipoErro = 'concluir';
            $id = isset($_GET['id']) ? $_GET['id'] : null;
            $tarefa->idStatus = 2;
            $tarefa->id = $id;
            $tarefaService = new TarefaService($conexao, $tarefa);
            $tarefaService->atualizar();
            definirPaginaDestino($pagina);
            break;
    }
} catch (PDOException $erro) {
    switch ($tipoErro) {
        case 'cadastro':
            header('Location: nova_tarefa.php?cadastrado=0');
    }
}
