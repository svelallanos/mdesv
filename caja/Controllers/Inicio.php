<?php

class Inicio extends Controllers
{
  public function __construct()
  {
    parent::__construct();
  }

  public function inicio()
  {
    parent::verificarLogin(true);

    $data['page_id'] = 2;
    $data['page_tag'] = "MDESV - Sistema Caja";
    $data['page_title'] = ":. Inicio - Sistema Caja";
    $data['page_name'] = "MDESV Sistema Caja";
    $data['page_css'] = "inicio/inicio";

    $this->views->getView($this, "inicio", $data);
  }
}
