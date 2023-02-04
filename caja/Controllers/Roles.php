<?php
class Roles extends Controllers
{
  public function __construct()
  {
    parent::__construct();
  }

  public function roles()
  {
    parent::verificarLogin(true);
    parent::verificarPermiso(2, true);
    $data['page_id'] = 3;
    $data['page_tag'] = "MDESV - Sistema Caja";
    $data['page_title'] = ":. Roles - Sistema Caja";
    $data['page_name'] = "Lista de Roles";
    $data['page_css'] = "roles/roles";
    $data['page_function_js'] = "roles/functions_roles";
    $data['lista_roles'] = $this->model->selectsRoles();
    $this->views->getView($this, "roles", $data);
  }

  public function editar()
  {
    parent::verificarLogin(true);
    parent::verificarPermiso(2, true);

    if (!$_GET || ($_SERVER['REQUEST_METHOD'] !== 'GET') || !isset($_GET['roles_id']) || intval($_GET['roles_id']) === 0) {
      location('Roles');
    }

    $seleccionar_rol = $this->model->selectRolId($_GET['roles_id']);
    if (!$seleccionar_rol) {
      location('Roles');
    }

    $auxPermisoRol = [];
    $seleccionar_permisos_rol = $this->model->selectsPermisosRol($_GET['roles_id']);
    if (!empty($seleccionar_permisos_rol)) {
      foreach ($seleccionar_permisos_rol as $key => $value) {
        $auxPermisoRol[$value['permiso_id']] = $value;
      }
    }

    $data['page_id'] = 3;
    $data['page_tag'] = "MDESV - Sistema Caja";
    $data['page_title'] = ":. Editar Roles - Sistema Caja";
    $data['page_name'] = "Editar Rol";
    $data['page_css'] = "roles/editar";
    $data['page_function_js'] = "roles/functions_editar";
    $data['lista_permisos_rol'] = $this->model->selectsPermisos();
    $data['rol'] = $seleccionar_rol;
    $data['permisos_habilitados'] = $auxPermisoRol;

    $this->views->getView($this, "editar", $data);
  }

  public function nuevo()
  {
    parent::verificarLogin(true);
    parent::verificarPermiso(2, true);

    $data['page_id'] = 3;
    $data['page_tag'] = "MDESV - Sistema Caja";
    $data['page_title'] = ":. Nuevo Rol - Sistema Caja";
    $data['page_name'] = "Nuevo Rol";
    $data['page_css'] = "roles/nuevo";
    $data['page_function_js'] = "roles/functions_roles";
    $data['lista_permisos_rol'] = $this->model->selectsPermisos();
    $this->views->getView($this, "nuevo", $data);
  }

  public function registrarRol()
  {
    parent::verificarLogin(true);
    parent::verificarPermiso(2, true);

    $return = [
      'status' => false,
      'msg' => 'Error al momento de registrar un rol.',
      'value' => 'error'
    ];

    if (!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST) || !isset($_POST['input_rol']) || empty($_POST['input_rol'])) {
      json($return);
    }

    $auxPOST = array();
    foreach ($_POST as $key => $value) {
      if ($key !== 'input_rol') {
        $auxPOST[$key] = $value;
      }
    }

    if (empty($auxPOST)) {
      $return['msg'] = 'El rol debe tener al menos un permiso.';
      $return['value'] = 'warning';
      json($return);
    }

    $seleccionarPermisos = $this->model->selectsPermisos(1, true);
    $unoActivo = false;
    $permisosActivos = array();
    foreach ($seleccionarPermisos as $key => $value) {
      if (isset($_POST['permiso_' . $value['permiso_id']])) {
        $unoActivo = true;
        array_push($permisosActivos, $value['permiso_id']);
      }
    }

    if (!$unoActivo) {
      $return['msg'] = 'Los permisos seleccionados no estan activos, seleccionar los permisos habilitados.';
      $return['value'] = 'warning';
      json($return);
    }

    $_POST['input_rol'] = trim($_POST['input_rol']);

    $seleccionarRol = $this->model->selectRol($_POST['input_rol']);
    if ($seleccionarRol) {
      $return['msg'] = 'El rol ' . $_POST['input_rol'] . ' ya existe.';
      $return['value'] = 'warning';
      json($return);
    }

    $registrarRol = $this->model->setRol($_POST['input_rol']);
    if ($registrarRol === 0) {
      $return['msg'] = 'Ocurrió un error al intentar ingresar el rol.';
      json($return);
    }

    $auxInsertId = 0;
    $todoCorrecto = true;

    foreach ($permisosActivos as $key => $value) {
      $auxInsertId = $this->model->insertDetRolPermiso($value, $registrarRol);
      if ($todoCorrecto && $auxInsertId === 0) {
        $todoCorrecto = false;
      }
    }

    if (!$todoCorrecto) {
      $return['msg'] = 'Se ingreso el rol, sin embargo, revise que se haya ingresado correctamente.';
      $return['value'] = 'warning';
      json($return);
    }

    $return = array(
      'status' => true,
      'msg' => 'El rol y los permisos seleccionados insertados correctamente.',
      'value' => 'success',
    );

    json($return);
  }

  public function updateRolPermisos()
  {
    parent::verificarLogin(true);
    parent::verificarPermiso(2, true);

    $return = [
      'status' => false,
      'msg' => 'Error al momento de actualizar el rol.',
      'value' => 'error'
    ];

    if (!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST) || !isset($_POST['input_rol']) || empty($_POST['input_rol']) || !isset($_POST['roles_id']) || intval($_POST['roles_id']) === 0) {
      json($return);
    }

    $auxPOST = array();
    foreach ($_POST as $key => $value) {
      if ($key !== 'input_rol' && $key !== 'roles_id') {
        $auxPOST[$key] = $value;
      }
    }

    if (empty($auxPOST)) {
      $return['msg'] = 'El rol debe tener al menos un permiso.';
      $return['value'] = 'warning';
      json($return);
    }

    $seleccionarPermisos = $this->model->selectsPermisos(1, true);
    $unoActivo = false;
    $permisosActivos = array();
    foreach ($seleccionarPermisos as $key => $value) {
      if (isset($_POST['permiso_' . $value['permiso_id']])) {
        $unoActivo = true;
        array_push($permisosActivos, $value['permiso_id']);
      }
    }

    if (!$unoActivo) {
      $return['msg'] = 'Los permisos seleccionados no estan activos, seleccionar los permisos habilitados.';
      $return['value'] = 'warning';
      json($return);
    }

    $_POST['input_rol'] = trim($_POST['input_rol']);

    $seleccionarRol = $this->model->selectRolId($_POST['roles_id']);
    if (!$seleccionarRol) {
      json($return);
    }

    $actualizar_rol_nombre = $this->model->updateRolName($_POST['roles_id'], $_POST['input_rol']);
    if (!$actualizar_rol_nombre) {
      json($return);
    }

    $eliminar_permisos_rol = $this->model->deletePermisosRol($_POST['roles_id']);
    if (!$eliminar_permisos_rol) {
      json($return);
    }

    $todoCorrecto = true;
    foreach ($permisosActivos as $key => $value) {
      $insertar_permiso_rol = $this->model->insertDetRolPermiso($value, $_POST['roles_id']);
      if (!$insertar_permiso_rol) {
        $todoCorrecto = false;
      }
    }

    if (!$todoCorrecto) {
      $return['msg'] = 'Revisar algunos de los permisos no se guardaron correctamente al rol.';
      $return['value'] = 'warning';
      json($return);
    }

    $return = [
      'status' => true,
      'msg' => 'Rol y permisos actualizados correctamente.',
      'value' => 'success'
    ];

    json($return);
  }

  public function deleteRol()
  {
    parent::verificarLogin(true);
    parent::verificarPermiso(2, true);
    
    $return = [
      'status' => false,
      'msg' => 'Error al momento de eliminar el rol.',
      'value' => 'error'
    ];

    if (!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST) || !isset($_POST['roles_id']) || intval($_POST['roles_id']) === 0) {
      json($return);
    }

    // verficamos que el rol no pertenesca a administradores
    if ($_POST['roles_id'] == '1' || $_POST['roles_id'] == '2' || $_POST['roles_id'] == '3' || $_POST['roles_id'] == '4') {
      $return['msg'] = 'Este rol no esta permitido eliminar.';
      $return['value'] = 'warning';
      json($return);
    }

    // Verificamos que exista el rol a eliminar
    $seleccionar_rol = $this->model->selectRolId($_POST['roles_id']);
    if (!$seleccionar_rol) {
      $return['msg'] = 'Error, este rol no existe.';
      json($return);
    }

    // Eliminamos los permisos vinculados al rol
    $eliminar_permisos = $this->model->deletePermisoRolById($_POST['roles_id']);
    if (!$eliminar_permisos) {
      $return['msg'] = 'Error, no se pueden eliminar los permisos vinculados al Rol.';
      json($return);
    }

    // Eliminamos los roles vinculados al usuario
    $eliminar_permisousuario = $this->model->deleteRolesUsuarioById($_POST['roles_id']);
    if (!$eliminar_permisousuario) {
      $return['msg'] = 'Error, no se pueden eliminar los roles vinculados al Usuario.';
      json($return);
    }

    // eliminamos el rol
    $eliminar_rol = $this->model->deleteRol($_POST['roles_id']);
    if (!$eliminar_rol) {
      json($return);
    }

    $return = [
      'status' => true,
      'msg' => 'Rol eliminado correctamente.',
      'value' => 'success'
    ];

    json($return);
  }
}
