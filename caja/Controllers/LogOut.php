<?php
class LogOut extends Controllers
{

  public function __construct()
  {
    parent::__construct();
  }

  public function logOut($contesto = null)
  {
    unset($_SESSION['caja']);
    location();
  }
}
