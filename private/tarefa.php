<?php
class Tarefa
{
    private $id;
    private $idStatus;
    private $tarefa;
    private $dataCadastro;


    public function __construct()
    {
        
    }

    public function __set($atributo,$valor){
        switch($atributo){
            case 'id':
                $this->$atributo = $valor;
                break;
            case 'idStatus':
                $this->$atributo = $valor;
                break;
            case 'tarefa':
                $this->$atributo = $valor;
                break;
            case 'dataCadastro':
                $this->$atributo = $valor;
                break;
        }
    }

    public function __get($atributo){
        switch($atributo){
            case 'id':
                return $this->$atributo;
            case 'idStatus':
                return $this->$atributo;
            case 'tarefa':
                return $this->$atributo;
            case 'dataCadastro':
                return $this->$atributo;
        }
    }
}
