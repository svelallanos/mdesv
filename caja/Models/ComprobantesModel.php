<?php

class ComprobantesModel extends Mysql
{
  function __construct()
  {
    parent::__construct();
  }


  // Funciones select_all

  public function listComprobantes()
  {
    $sql = 'SELECT * FROM comprobantes';
    $request = $this->select_all($sql, array(), DB_CAJA);
    return $request;
  }

  // Funciones select

  public function dataComprobanteBySerie(string $comprobantes_serie)
  {
    $sql = 'SELECT * FROM `comprobantes` as cpbt where cpbt.comprobantes_serie=:comprobantes_serie;';
    $result = $this->select($sql, array('comprobantes_serie' => $comprobantes_serie), DB_CAJA);
    return $result;
  }

  public function dataComprobante(int $comprobantes_id)
  {
    $sql = 'SELECT * FROM `comprobantes` as cmpbt where cmpbt.comprobantes_id=:comprobantes_id';
    $result = $this->select($sql, array('comprobantes_id' => $comprobantes_id), DB_CAJA);
    return $result;
  }

  public function dataComprobanteByDescripcion(string $comprobantes_descripcion)
  {
    $sql = 'SELECT * FROM `comprobantes` as cpbt where cpbt.comprobantes_descripcion=:comprobantes_descripcion;';
    $result = $this->select($sql, array('comprobantes_descripcion' => $comprobantes_descripcion), DB_CAJA);
    return $result;
  }
  // Funcion insert

  public function saveComprobante(string $comprobantes_serie, string $comprobantes_descripcion)
  {
    $sql = "INSERT INTO `comprobantes` 
    (`comprobantes_id`, `comprobantes_descripcion`, `comprobantes_numero`, `comprobantes_serie`, `comprobantes_estado`, `comprobantes_fechacreate`, `comprobantes_fechaupdate`) 
    VALUES 
    (NULL, :comprobantes_descripcion, NULL, :comprobantes_serie, '1', current_timestamp(), current_timestamp())";
    $result = $this->insert($sql, array('comprobantes_descripcion' => $comprobantes_descripcion, 'comprobantes_serie' => $comprobantes_serie), DB_CAJA);
    return $result;
  }

  // funcion update
  public function updateComprobante(int $comprobantes_id, string $comprobantes_serie, string $comprobantes_descripcion, int $comprobantes_estado)
  {
    $sql = "UPDATE `comprobantes` SET `comprobantes_descripcion` = :comprobantes_descripcion, `comprobantes_serie` = :comprobantes_serie, `comprobantes_estado` = :comprobantes_estado WHERE `comprobantes`.`comprobantes_id` = :comprobantes_id";
    $arraData = [
      'comprobantes_serie' => $comprobantes_serie,
      'comprobantes_descripcion' => $comprobantes_descripcion,
      'comprobantes_estado' => $comprobantes_estado,
      'comprobantes_id' => $comprobantes_id,
    ];

    $result = $this->update($sql, $arraData, DB_CAJA);
    return $result;
  }

  //function delete
  public function deleteComprobante(int $comprobantes_id)
  {
    $sql = "DELETE FROM comprobantes WHERE `comprobantes`.`comprobantes_id` = :comprobantes_id";
    $result = $this->delete($sql, array('comprobantes_id' => $comprobantes_id), DB_CAJA);
    return $result;
  }
}
