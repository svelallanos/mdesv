<?php

class Mysql extends Conexion
{
  private $strquery;
  private $arrvalues;

  function __construct()
  {
    $auxConexion = new Conexion();
    $this->conexionCaja = $auxConexion->conectCaja();
  }

  public function insert(string $query, array $arrvalues = array(), string $base = '')
  {
    $this->strquery = $query;
    $this->arrvalues = $arrvalues;

    if ($base == 'mdesv_caja') {
      $insert = $this->conexionCaja->prepare($this->strquery);
    } else {
      echo 'Base de datos no especificada.';
      die;
    }

    $lastInsert = $insert->execute($this->arrvalues);

    if ($lastInsert) {
      if ($base == 'mdesv_caja') {
        $lastInsert = $this->conexionCaja->lastInsertId();
      }
    } else {
      $lastInsert = 0;
    }

    $insert->closeCursor();
    return intval($lastInsert);
  }

  public function update(string $query, array $arrvalues = array(), string $base = '')
  {
    $this->strquery = $query;
    $this->arrvalues = $arrvalues;

    if ($base == 'mdesv_caja') {
      $update = $this->conexionCaja->prepare($this->strquery);
    } else {
      echo 'Base de datos no especificada.';
      die;
    }

    $res = $update->execute($this->arrvalues);
    $update->closeCursor();
    return $res;
  }

  public function select(string $query, array $arrvalues = array(), string $base = '')
  {
    $this->strquery = $query;
    $this->arrvalues = $arrvalues;

    if ($base == 'mdesv_caja') {
      $result = $this->conexionCaja->prepare($this->strquery);
    } else {
      echo 'Base de datos no especificada.';
      die;
    }

    $result->execute($this->arrvalues);
    $data = $result->fetch(PDO::FETCH_ASSOC);
    $result->closeCursor();
    return $data;
  }

  public function select_all(string $query, array $arrvalues = array(), string $base = '')
  {
    $this->strquery = $query;
    $this->arrvalues = $arrvalues;

    if ($base == 'mdesv_caja') {
      $result = $this->conexionCaja->prepare($this->strquery);
    } else {
      echo 'Base de datos no especificada.';
      die;
    }

    $result->execute($this->arrvalues);
    $data = $result->fetchAll(PDO::FETCH_ASSOC);
    $result->closeCursor();
    return $data;
  }

  public function delete(string $query, array $arrvalues = array(), string $base = '')
  {
    $this->strquery = $query;
    $this->arrvalues = $arrvalues;

    if ($base == 'mdesv_caja') {
      $result = $this->conexionCaja->prepare($this->strquery);
    } else {
      echo 'Base de datos no especificada.';
      die;
    }

    $res = $result->execute($this->arrvalues);
    $result->closeCursor();
    return $res;
  }
}
