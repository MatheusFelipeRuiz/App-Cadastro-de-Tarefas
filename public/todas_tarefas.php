<?php
if(!isset($_GET['acao']) && $_GET['acao'] !== 'concluir'){
	$_GET['acao'] = 'recuperar';
}
require_once 'tarefa_controller.php';
?>
<html>

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>App Lista Tarefas</title>

	<link rel="stylesheet" href="css/estilo.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
</head>

<body>
	<nav class="navbar navbar-light bg-light">
		<div class="container">
			<a class="navbar-brand" href="#">
				<img src="img/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
				App Lista Tarefas
			</a>
		</div>
	</nav>

	<div class="container app">
		<div class="row">
			<div class="col-sm-3 menu">
				<ul class="list-group">
					<li class="list-group-item"><a href="index.php">Tarefas pendentes</a></li>
					<li class="list-group-item"><a href="nova_tarefa.php">Nova tarefa</a></li>
					<li class="list-group-item active"><a href="#">Todas tarefas</a></li>
				</ul>
			</div>

			<div class="col-sm-9">
				<div class="container pagina">
					<div class="row">
						<div class="col">
							<?php
							if ($acao === 'recuperar') {
							?>
								<h4>Todas tarefas</h4>
								<hr />

							<?php
								foreach ($tarefas as $chave => $tarefa) {
							?>
									<div class="row mb-3 d-flex align-items-center tarefa">
										<div class="col-sm-9" id="tarefa-<?php echo $tarefa->id ?>"> 
											<?php echo $tarefa->tarefa ?> -
											<?php echo ucfirst($tarefa->status) ?> -
											<?php 
												$data = date_create($tarefa->data_cadastrado);
												echo date_format($data,'d/m/Y')
											?>
										</div>
										<div class="col-sm-3 mt-2 d-flex justify-content-between">
											<i class="fas fa-trash-alt fa-lg text-danger"
											onclick="deletar(<?php echo $tarefa->id; ?>)">
											</i>
											<i class="fas fa-edit fa-lg text-info" 
											onclick="editar(<?php echo $tarefa->id; ?>, '<?php echo $tarefa->tarefa;?>')">
											</i>
										<?php 
											if($tarefa->status !== 'realizado'){	
										?>
											<i class="fas fa-check-square fa-lg text-dark"
											onclick="marcarComoConcluido(<?php echo $tarefa->id; ?>,'<?php echo $tarefa->tarefa; ?>')"></i>
										<?php } else {?>
											<i class="fas fa-check-square fa-lg text-success" ></i>
										<?php }?>
										</div>
									</div>
							<?php
								}
							}else {

							?>
								<h4 class="text-danger">Erro ao consultar tarefas</h4>
								<p class="font-weight-bold">Por favor, entre em contato com o suporte para verificar se ocorreu algum problema.</p>
							<?php }?>
						</div>

						</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		function editar(idTarefa, descricaoTarefa){
			const FORM = document.createElement('form');
			FORM.setAttribute('action','tarefa_controller.php?acao=atualizar&pagina=todas-tarefas');
			FORM.setAttribute('method','post');

			const INPUT_TAREFA = document.createElement('input');
			INPUT_TAREFA.setAttribute('type','text');
			INPUT_TAREFA.setAttribute('name','tarefa');
			INPUT_TAREFA.setAttribute('class','form-control');
			INPUT_TAREFA.value = descricaoTarefa;

			const INPUT_ID_TAREFA = document.createElement('input');
			INPUT_ID_TAREFA.setAttribute('type','hidden');
			INPUT_ID_TAREFA.setAttribute('name','id');
			INPUT_ID_TAREFA.value = idTarefa;

			const BTN_SALVAR = document.createElement('button');
			BTN_SALVAR.classList.add('btn', 'btn-info');
			BTN_SALVAR.innerHTML = 'Atualizar';

			FORM.appendChild(INPUT_TAREFA);
			FORM.appendChild(BTN_SALVAR);
			FORM.appendChild(INPUT_ID_TAREFA);

			const TAREFA_SELECIONADA = document.getElementById(`tarefa-${idTarefa}`);

			TAREFA_SELECIONADA.innerHTML = '';
			TAREFA_SELECIONADA.insertBefore(FORM,TAREFA_SELECIONADA[0]);

		}

		function deletar(idTarefa){
			const FORM = document.createElement('form');
			FORM.setAttribute('action','tarefa_controller.php?acao=remover&pagina=todas-tarefas');
			FORM.setAttribute('method','post');

			const INPUT_ID_TAREFA = document.createElement('input');
			INPUT_ID_TAREFA.setAttribute('type','hidden');
			INPUT_ID_TAREFA.setAttribute('name','id');
			INPUT_ID_TAREFA.value = idTarefa;

			FORM.appendChild(INPUT_ID_TAREFA);
			const TAREFA_SELECIONADA = document.getElementById(`tarefa-${idTarefa}`);
			TAREFA_SELECIONADA.appendChild(FORM);
			FORM.submit();
		}

		function marcarComoConcluido(idTarefa,descricao){
			window.location.href = `todas_tarefas.php?acao=concluir&id=${idTarefa}&descricao=${descricao}`;
		}
	</script>
</body>

</html>