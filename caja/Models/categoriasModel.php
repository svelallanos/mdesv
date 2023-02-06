<?php

class categoriasModel extends Mysql
{
  function __construct()
  {
    parent::__construct();
  }

  // Funciones select_all

  public function dataAllCategorias()
  {
    $sql = 'SELECT * FROM categoria';
    $result = $this->select_all($sql, array(), DB_CAJA);
    return $result;
  }

  public function dataAllGenerica(int $categoria_id)
  {
    $sql = 'SELECT * FROM generica
    WHERE categoria_id = :categoria_id';
    $result = $this->select_all($sql, array('categoria_id' => $categoria_id), DB_CAJA);
    return $result;
  }


  // funcion select

  public function dataCategoria(int $categoria_id)
  {
    $sql = 'SELECT * FROM categoria
    WHERE categoria_id = :categoria_id';
    $result = $this->select($sql, array('categoria_id' => $categoria_id), DB_CAJA);
    return $result;
  }

  public function dataCategoriaByCod(string $categoria_cod)
  {
    $sql = 'SELECT * FROM categoria
    WHERE categoria_cod = :categoria_cod';
    $result = $this->select($sql, array('categoria_cod' => $categoria_cod), DB_CAJA);
    return $result;
  }

  public function dataCategoriaByDesc(string $categoria_descripcion)
  {
    $sql = 'SELECT * FROM categoria
    WHERE categoria_descripcion = :categoria_descripcion';
    $result = $this->select($sql, array('categoria_descripcion' => $categoria_descripcion), DB_CAJA);
    return $result;
  }

  // Funcion insert

  public function saveCatogoria(string $categoria_cod, string $categoria_descripcion)
  {
    $sql = 'INSERT categoria(categoria_cod, categoria_descripcion) 
    VALUE (:categoria_cod, :categoria_descripcion)';
    $result = $this->insert($sql, array('categoria_cod' => $categoria_cod, 'categoria_descripcion' => $categoria_descripcion), DB_CAJA);
    return $result;
  }


  // funcion update
  public function updateCatogoria(int $categoria_id, string $categoria_cod, string $categoria_descripcion, int $categoria_estado)
  {
    $sql = 'UPDATE categoria SET categoria_cod = :categoria_cod, categoria_descripcion = :categoria_descripcion, categoria_estado = :categoria_estado
    WHERE categoria_id = :categoria_id';
    $arraData = [
      'categoria_cod' => $categoria_cod,
      'categoria_descripcion' => $categoria_descripcion,
      'categoria_estado' => $categoria_estado,
      'categoria_id' => $categoria_id,
    ];

    $result = $this->update($sql, $arraData, DB_CAJA);
    return $result;
  }

  // function delete

  public function deleteCategoria(int $categoria_id)
  {
    $sql = 'DELETE FROM categoria
    WHERE categoria_id = :categoria_id';
    $request = $this->delete($sql, array('categoria_id' => $categoria_id), DB_CAJA);

    return $request;
  }
}
