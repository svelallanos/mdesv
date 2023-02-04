<?php
class Views
{
  function getView($controller, $view, $data = array(), $controllerPadre = true)
  {
    if ($controllerPadre == true) {
      $data['permisosUser'] = $controller->permisosUser;
      // $data['rolesUser'] = $controller->rolesUser;
      $data['datosUserCaja'] = $controller->datosUserCaja;
    }

    // $data['semestreActualObj'] = $controller->semestreAcutual;

    $controller = get_class($controller);

    if ($controller == "Home") {
      $view = 'Views/' . $view . '.php';
    } else {
      $view = 'Views/' . $controller . '/' . $view . '.php';
    }
    require_once($view);
  }
}
