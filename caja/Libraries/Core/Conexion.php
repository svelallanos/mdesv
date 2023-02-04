<?php

class Conexion
{
  private $caja;

  public function __construct()
  {
    // Conexion a la base de datos de muni caja
    $conecctionString = "mysql:host=" . DB_HOST . ";dbname=" . DB_CAJA;

    try {
      $this->caja = new PDO($conecctionString, DB_USER, DB_PASSWORD);
      $this->caja->setAttribute(PDO::ATTR_ERRMODE,    PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      $this->caja = 'Error de conexión';
      echo "ERROR: " . $e->getMessage();
      die;
    }
  }

  public function conectCaja()
  {
    return $this->caja;
  }
}
