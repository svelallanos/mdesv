<?php
require_once(PATH_MODELS . "UsuariosModel.php");
require_once(PATH_MODELS . "PermisosModel.php");
require_once(PATH_MODELS . "RolesModel.php");
require_once(PATH_MODELS . "LoginModel.php");

class Controllers
{
  public function __construct($session = true)
  {
    if ($session) {
      session_start();
    }

    $this->views = new Views();
    $this->loadModel();
    $this->isLogin();

    $this->datosUserCaja = $this->defineDatosUserCaja();
    $this->validarUpdatePassword();
    $this->validarUltimoLoad();

    $this->permisosUser = $this->getPermisos();
  }

  public function loadModel()
  {
    $model = get_class($this) . "Model";
    $routClass = "Models/" . $model . ".php";
    if (file_exists($routClass)) {
      require_once($routClass);
      $this->model = new $model();
    }
  }

  public function verificarPermiso(int $idPermiso, bool $redirigir = false)
  {
    if (isset($this->permisosUser[$idPermiso])) {
      return true;
    } else {
      if ($redirigir) {
        location();
      } else {
        return false;
      }
    }
  }

  public function validarUltimoLoad()
  {
    if ($this->isLogin) {
      if (isset($_SESSION['caja']['last_load'])) {
        $now = new DateTime('NOW');
        $lastLoad = $_SESSION['caja']['last_load'];

        $lastLoad->add(new DateInterval('PT' . TIME_SESSION['horas'] . 'H' . TIME_SESSION['minutos'] . 'M'));

        if ($now > $lastLoad) {
          unset($_SESSION['caja']);
          location('login');
        } else {
          $_SESSION['caja']['last_load'] = new DateTime('NOW');
        }
      } else {
        $_SESSION['caja']['last_load'] = new DateTime('NOW');
      }
    }
  }

  public function isLogin()
  {
    if (isset($_SESSION['caja']['login_caja']) && $_SESSION['caja']['login_caja'] == true) {
      $this->isLogin = true;
    } else {
      $this->isLogin = false;

      if (isset($_SESSION)) {
        unset($_SESSION['caja']);
      }
    }
  }

  public function defineDatosUserCaja()
  {
    $datosUserCaja = array(
      'usuarios_nombres' => 'Invitado #2022',
      'usuarios_materno' => '',
      // 'usuarios_dni' => '0',
      'usuarios_paterno' => ''
    );

    if ($this->isLogin) {

      $usuarios = new UsuariosModel();
      $datosUserCaja = $usuarios->selectUsuarioLogin($_SESSION['caja']['usuario_login']);

      if ($datosUserCaja) {
        // Validar si el usuarios esta bloqueado

        $bloqueado = $usuarios->selectMotivoUsuarioById($datosUserCaja['usuarios_id']);

        if (!empty($bloqueado) || $datosUserCaja['usuarios_estado'] != 1) {
          $this->isLogin = false;
          unset($_SESSION['caja']);
        }
      } else {
        $this->isLogin = false;
        unset($_SESSION['caja']);
      }
    }

    return $datosUserCaja;
  }
  public function validarUpdatePassword()
  {
    if ($this->isLogin) {
      $sessionDate = $_SESSION['caja']['update_pass'];
      $dbDate = $this->datosUserCaja['usuarios_updatepassword'];

      if ($sessionDate != $dbDate) {
        unset($_SESSION['caja']);
        location('login');
      }
    }
  }

  public function getPermisos()
  {
    if (!$this->isLogin) {
      return array();
    } else {
      $permisosModel = new PermisosModel();
      $array = array();

      $permisos = $permisosModel->getPermisos($this->datosUserCaja['usuarios_id']);
      $permisosUsuario = $permisosModel->getPermisosUsuario($this->datosUserCaja['usuarios_id']);

      foreach ($permisos as $key => $value) {
        $array[$value['permiso_id']] = true;
      }

      foreach ($permisosUsuario as $key => $value) {
        $array[$value['permiso_id']] = true;
      }

      return $array;
    }
  }

  public function verificarLogin(bool $redirigir = false)
  {
    if ($this->isLogin) {
      return true;
    } else {
      unset($_SESSION['caja']);
      if ($redirigir) {
        location('login');
      } else {
        return false;
      }
    }
  }
}
