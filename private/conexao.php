<?php

class ConexaoBD
{

    private $SGBD = 'mysql';
    private $HOST = 'localhost';
    private $DB_NAME = 'db_tarefas';
    private $USER = 'root';
    private $PASSWORD = '';


    public function conectar()
    {
        try {
            define(
                'CONEXAO',
                new PDO(
                    "$this->SGBD:host=$this->HOST;dbname=$this->DB_NAME",
                    "$this->USER",
                    "$this->PASSWORD"
                )
            );

            return CONEXAO;
        } catch (PDOException $erro) {
            echo "$erro";
        }
    }
}
