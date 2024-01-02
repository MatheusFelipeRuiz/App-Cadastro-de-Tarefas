<?php
require_once '../private/model/Tarefa.php';
require_once '../private/service/TarefaService.php';
require_once '../private/config/ConexaoBD.php';


function tratarErro($erro){
    echo '<br/>';
    echo '<strong>Código:</strong>  ' . $erro->getCode();
    echo '<br/>';
    echo '<strong>Mensagem: </strong>' . $erro->getMessage();
    echo '<br/>';
    echo '<strong>Arquivo:</strong> ' . $erro->getFile();
    echo '<br/>';
    echo '<strong>Linha:</strong> ' . $erro->getLine();
    echo '<br/>';
}


$descricao = isset($_GET['descricao']) ? $_GET['descricao'] : $descricao;
$acao = isset($_GET['acao']) ? $_GET['acao'] : $acao;
$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : $pagina;


function definirPaginaDestino($pagina){
    var_dump($pagina);
    switch ($pagina) {
        case 'index':
            header('Location: index.php');
            break;
        case 'todas-tarefas':
            header('Location: todas_tarefas.php');
            break;
        case 'cadastrado-erro':
            header('Location: nova_tarefa.php?cadastrado=0');
            break;
        case 'cadastrado-com-sucesso':
            header('Location: nova_tarefa.php?cadastrado=1');
            break;
        default:
            var_dump('Default');

    }
}

$id = isset($_POST['id']) ? $_POST['id'] : null;
try {

    $conexao = new ConexaoBD();
    $tarefa = new Tarefa();
    $tarefaService = null;

    switch ($acao) {
        case 'cadastrar':
            $descricao = strlen(trim($_POST['tarefa'])) > 0 ? $_POST['tarefa'] : $descricao;

            $tarefa->__set('tarefa',$descricao);
            $tarefa->__set('idStatus',1);

            $tarefaService = new TarefaService($conexao,$tarefa);
            try {
                $tarefaService->inserir();
                $pagina = 'cadastrado-com-sucesso';
            } catch (PDOException $erro) {
                $pagina = 'cadastrado-erro';
            }finally{
                definirPaginaDestino($pagina);
            }
            break;
        case 'recuperar':
            $tarefaService = new TarefaService($conexao,$tarefa);
            $tarefas = $tarefaService->recuperar();
            break;
        case 'recuperar-pendentes':
            $tarefaService = new TarefaService($conexao,$tarefa);
            $tarefas = $tarefaService->recuperarPendentes();
            break;
        case 'atualizar':
            $id = isset($_POST['id']) ? $_POST['id'] : null; 
            $descricao = isset($_POST['tarefa']) ? $_POST['tarefa'] : null;
            $descricao = strlen($descricao) > 0 ? $descricao : null;
            $idStatus = isset($_POST['idStatus']) ? $_POST['idStatus'] : null;
            

            $tarefa->__set('id',$id);
            $tarefa->__set('tarefa',$descricao);
            $tarefa->__set('idStatus',$idStatus);


            $tarefaService = new TarefaService($conexao,$tarefa);
            $operacaoConcluida = $tarefaService->atualizar();
            if ($operacaoConcluida) {
                definirPaginaDestino($pagina);
            }
            break;
        case 'remover':
            $id = isset($_POST['id']) ? $_POST['id'] : null; 
            $tarefa->__set('id',$id);
            $tarefaService = new TarefaService($conexao,$tarefa);
            $operacaoConcluida = $tarefaService->remover();
            definirPaginaDestino($pagina);
            break;
        case 'concluir':
            $id = isset($_GET['id']) ? $_GET['id'] : null;
            $idStatus = isset($_GET['idStatus']) ? $_GET['idStatus'] : null;
            $descricao = isset($_GET['descricao']) ? $_GET['descricao'] : null;

            $tarefa->__set('idStatus',2);
            $tarefa->__set('id',$id);
            $tarefa->__set('tarefa',$descricao);

            $tarefaService = new TarefaService($conexao,$tarefa);
            $tarefaService->atualizar();
            definirPaginaDestino($pagina);
            break;
    }
} catch (PDOException $erro) {
    tratarErro($erro);
}
