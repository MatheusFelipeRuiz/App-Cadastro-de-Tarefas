CREATE TABLE IF NOT EXISTS tb_status(
	id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
	status varchar(25) NOT NULL
);

INSERT
	INTO
	tb_status(status)
VALUES('pendente');

INSERT
	INTO
	tb_status(status)
VALUES('realizado');

CREATE TABLE IF NOT EXISTS tb_tarefas(
	id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
	id_status int NOT NULL DEFAULT 1,
	FOREIGN KEY(id_status) REFERENCES tb_status(id),
	tarefa text NOT NULL,
	data_cadastrado datetime NOT NULL DEFAULT current_timestamp
);

SELECT * FROM tb_tarefas;
SELECT * FROM tb_status;