<?php

class GenericaModel extends Mysql {
    public function __construct()
    {
        parent::__construct();
    }

    public function dataAllCategorias()
    {
        $sql = 'SELECT * FROM categoria';
        $request = $this->select_all($sql, array(), DB_CAJA);
        return $request;
    }

    public function dataAllGenerica()
    {
        $sql = 'SELECT * FROM generica';
        $request = $this->select_all($sql, array(), DB_CAJA);
        return $request;
    }
}