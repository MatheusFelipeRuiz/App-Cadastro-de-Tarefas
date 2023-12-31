<?php
require_once '../private/model/Tarefa.php';
require_once '../private/service/TarefaService.php';
require_once '../private/config/ConexaoBD.php';




$descricao = strlen(trim($_POST['tarefa'])) > 0 ? $_POST['tarefa'] : null;
$tarefa = new Tarefa($descricao);
$conexao = new ConexaoBD();
$tarefaService = new TarefaService($conexao, $tarefa);

$acao = $_GET['acao'];
echo '<pre>';
var_dump($_GET);

echo '</pre>';
$tipoErro = null;
try {
    switch ($acao) {
        case 'cadastrar':
            $tipoErro = 'cadastro';
            $tarefaService->inserir();
            header('Location: nova_tarefa.php?cadastrado=1');
    }
} catch (PDOException $erro) {
    switch($tipoErro){
        case 'cadastro':
            header('Location: nova_tarefa.php?cadastrado=0');
    }
}
