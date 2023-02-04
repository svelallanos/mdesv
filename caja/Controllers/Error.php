<?php

class Errors extends Controllers
{
  public function __construct()
  {
    parent::__construct();
  }

  public function notFound()
  {
    header("HTTP/1.0 404 Not Found");
    $this->views->getView($this, "error");
  }
}
