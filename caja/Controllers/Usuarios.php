<?php

require_once PATH_CONTROLLERS . 'ApiRest.php';

class Usuarios extends Controllers
{
  public function __construct()
  {
    parent::__construct();
  }

  public function usuarios()
  {
    parent::verificarLogin(true);
    parent::verificarPermiso(1, true);

    $data['page_id'] = 6;
    $data['page_tag'] = "MDESV - Sistema Caja";
    $data['page_title'] = ":. Usuarios - Sistema Caja";
    $data['page_name'] = "Lista de Usuarios";
    $data['page_css'] = "usuarios/usuarios";
    $data['page_function_js'] = "usuarios/functions_usuarios";
    $this->views->getView($this, "usuarios", $data);
  }

  public function nuevo()
  {
    parent::verificarLogin(true);
    parent::verificarPermiso(1, true);

    $seleccionar_roles = $this->model->selectsRoles();

    $data['page_id'] = 4;
    $data['page_tag'] = "MDESV - Sistema Caja";
    $data['page_title'] = ":. Nuevo Usuario - Sistema Caja";
    $data['page_name'] = "Nuevo Usuario";
    $data['page_css'] = "usuarios/usuarios";
    $data['page_function_js'] = "usuarios/functions_nuevo";
    $data['data-roles'] = $seleccionar_roles;
    $this->views->getView($this, "nuevo", $data);
  }

  public function editar()
  {
    parent::verificarLogin(true);
    parent::verificarPermiso(1, true);

    if (!$_GET || !isset($_GET['usuarios_id']) || intval($_GET['usuarios_id']) === 0) {
      location('Usuarios/lista_usuario');
    }

    $seleccionar_usuario = $this->model->selectUsuarioById($_GET['usuarios_id']);
    if (!$seleccionar_usuario) {
      location('Usuarios/lista_usuario');
    }

    $seleccionar_roles_usuario = $this->model->selectsRolUsuarioByIdUsuario($_GET['usuarios_id']);
    $auxRolesUsuario = array();
    foreach ($seleccionar_roles_usuario as $key => $value) {
      if (!isset($auxRolesUsuario[$value['roles_id']])) {
        $auxRolesUsuario[$value['roles_id']] = 'rol asignado';
      }
    }
    $seleccionar_roles = $this->model->selectsRoles();

    $data['page_id'] = 4;
    $data['page_tag'] = "MDESV - Sistema Caja";
    $data['page_title'] = ":. Editar Usuarios - Sistema Caja";
    $data['page_name'] = "Editar Usuario";
    $data['page_css'] = "usuarios/usuarios";
    $data['page_function_js'] = "usuarios/functions_usuarios";
    $data['data-usuario'] = $seleccionar_usuario;
    $data['data-roles'] = $seleccionar_roles;
    $data['data-roles-usuario'] = $auxRolesUsuario;
    $this->views->getView($this, "editar", $data);
  }

  public function bloqueos()
  {
    parent::verificarLogin(true);
    parent::verificarPermiso(3, true);

    $data['page_id'] = 11;
    $data['page_tag'] = "MDESV - Sistema Caja";
    $data['page_title'] = ":. Bloqueos - Sistema Caja";
    $data['page_name'] = "Usuarios Bloqueados";
    $data['page_css'] = "usuarios/usuarios";
    $data['page_function_js'] = "usuarios/functions_usuarios";
    $data['data-tipo-bloqueo'] = $this->model->selectsTipoBloqueo();
    $this->views->getView($this, "bloqueos", $data);
  }

  public function permisos_personalizados()
  {
    parent::verificarLogin(true);
    parent::verificarPermiso(4, true);

    $data['page_id'] = 11;
    $data['page_tag'] = "MDESV - Sistema Caja";
    $data['page_title'] = ":. Permisos Personalizados - Sistema Caja";
    $data['page_name'] = "Lista de Permisos Personalizados";
    $data['page_css'] = "usuarios/usuarios";
    $data['page_function_js'] = "usuarios/functions_permisos";
    $this->views->getView($this, "permisos_personalizados", $data);
  }

  public function permisos_usuario()
  {
    parent::verificarLogin(true);
    parent::verificarPermiso(4, true);

    if(!$_GET || $_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['usuarios_id']) || intval($_GET['usuarios_id']) === 0){
      location('Usuarios/permisos_personalizados');
    }

    $seleccionar_usuario = $this->model->selectUsuarioById($_GET['usuarios_id']);
    if (!$seleccionar_usuario) {
      location('Usuarios/permisos_personalizados');
    }

    $auxPermisoUsuario = [];
    $seleccionar_permisos_usuarios = $this->model->selectsPermisosUsuario($_GET['usuarios_id']);
    if (!empty($seleccionar_permisos_usuarios)) {
      foreach ($seleccionar_permisos_usuarios as $key => $value) {
        $auxPermisoUsuario[$value['permiso_id']] = $value;
      }
    }

    $data['page_id'] = 12;
    $data['page_tag'] = "MDESV - Sistema Caja";
    $data['page_title'] = ":. Permisos Usuario - Sistema Caja";
    $data['page_name'] = "Permisos Usuario";
    $data['page_css'] = "usuarios/usuarios";
    $data['page_function_js'] = "usuarios/functions_permisos";
    $data['lista_permisos_rol'] = $this->model->selectsPermisos();
    $data['usuario'] = $seleccionar_usuario;
    $data['permisos_habilitados'] = $auxPermisoUsuario;
    $this->views->getView($this, "permisos_usuario", $data);
  }

  public function consultarDatosDni()
  {
    parent::verificarLogin(true);
    $return = [
      'status' => false,
      'msg' => 'Error al momento de consultar los datos de DNI.',
      'value' => 'error'
    ];

    if (!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST) || !isset($_POST['dni_api']) || empty($_POST['dni_api'])) {
      json($return);
    }

    // Validamos el número de dni ingresado
    if (strlen($_POST['dni_api']) !== 8 || !is_numeric($_POST['dni_api'])) {
      $return['msg'] = 'Número de dni inválido.';
      json($return);
    }

    // Verificamos que no se encuetre registrado un usuario con este número de dni
    $seleccionar_usuario = $this->model->selectUsuarioByDni($_POST['dni_api']);
    if ($seleccionar_usuario) {
      $return['msg'] = 'Este usuario ya se encuentra registrado con este número de DNI.';
      $return['value'] = 'warning';
      json($return);
    }

    // Consultamos los datos con la ApiRest
    $dataDNI = new ApiRest(false);
    $datos_deni = $dataDNI->apiDni($_POST['dni_api']);
    json($datos_deni);
  }

  public function selectsUsers()
  {
    parent::verificarLogin(true);
    parent::verificarPermiso(1, true);

    $usuarios_bloqueados = $this->model->usuariosBloqueadosGroupBy();
    $auxUsuariosBloqueados = array();
    foreach ($usuarios_bloqueados as $key => $value) {
      if (!isset($auxUsuariosBloqueados[$value['usuarios_id']])) {
        $auxUsuariosBloqueados[$value['usuarios_id']] = 'Bloqueado';
      }
    }

    $lista_usuarios = $this->model->selectsUsuariosGlobal();
    $auxUsuariosSinBloquear = array();
    $cont = 0;
    foreach ($lista_usuarios as $key => $value) {
      if(!isset($auxUsuariosBloqueados[$value['usuarios_id']])){
        $auxUsuariosSinBloquear[$cont++] = $value;
      }
    }

    $lista_rol_usuario = $this->model->selectsRolUsuarioBib();
    $auxRolUsuario = array();
    foreach ($lista_rol_usuario as $key => $value) {
      if (!isset($auxRolUsuario[$value['usuarios_id']])) {
        $auxRolUsuario[$value['usuarios_id']] = '<span class="badge border bg-light text-primary">' . $value['roles_nombre'] . '</span>';
      } else {
        $auxRolUsuario[$value['usuarios_id']] .= '<span class="ml-2i badge border bg-light text-primary">' . $value['roles_nombre'] . '</span>';
      }
    }

    foreach ($auxUsuariosSinBloquear as $key => $value) {
      $value['usuarios_fechacreacion'] = new DateTime(str_replace(' ', 'T', $value['usuarios_fechacreacion']) . 'America/Lima');
      $auxUsuariosSinBloquear[$key]['numero'] = '<div class="text-center">' . ($key + 1) . '</div>';
      $auxUsuariosSinBloquear[$key]['usuarios'] = $value['usuarios_nombres'] . ' ' . $value['usuarios_paterno'] . ' ' . $value['usuarios_materno'];
      $auxUsuariosSinBloquear[$key]['fechacreacion'] = '<div class="text-center"><span class="fw-bold">' . $value['usuarios_fechacreacion']->format('h:i A') . '</span> - ' . $value['usuarios_fechacreacion']->format('d/m/Y') . '</div>';
      $auxUsuariosSinBloquear[$key]['roles'] = (isset($auxRolUsuario[$value['usuarios_id']])) ? $auxRolUsuario[$value['usuarios_id']] : "Sin rol asignado.";
      $auxUsuariosSinBloquear[$key]['estado'] = '<div class="text-center"><span class="badge fw-bold rounded-pill text-success border bg-success-soft">Activo</span></div>';
      $auxUsuariosSinBloquear[$key]['options'] = '<div class="text-center"><a href="Usuarios/editar?usuarios_id=' . $value['usuarios_id'] . '" class="btn btn-sm border text-body border-black btn-warning btn_editar_usuario" title="Editar usuario"><i class="fa-solid fa-user-pen"></i></a></div>';
    }

    json($auxUsuariosSinBloquear);
  }

  public function selects_usuariosforBloqueo()
  {
    parent::verificarLogin(true);
    parent::verificarPermiso(3, true);

    $lista_usuarios = $this->model->selectsUsuariosGlobal();
    foreach ($lista_usuarios as $key => $value) {
      $lista_usuarios[$key]['numero'] = '<div class="text-center">' . ($key + 1) . '</div>';
      $lista_usuarios[$key]['apellidos'] = $value['usuarios_paterno'] . ' ' . $value['usuarios_materno'];

      $lista_usuarios[$key]['options'] = '<div class="text-center"><button data-nombres="' . $value['usuarios_nombres'] . ', ' . $value['usuarios_paterno'] . ' ' . $value['usuarios_materno'] . '" data-usuarios_id="' . $value['usuarios_id'] . '" class="btn btn-danger btn-sm open_modal_agregar_bloqueo" title="Agregar usuario"><i class="feather-lock"></i></button></div>';
    }

    json($lista_usuarios);
  }

  public function selects_usuariosforPermisos()
  {
    parent::verificarLogin(true);
    parent::verificarPermiso(4, true);

    $lista_usuarios = $this->model->selectsUsuariosGlobal();
    foreach ($lista_usuarios as $key => $value) {
      $lista_usuarios[$key]['numero'] = '<div class="text-center">' . ($key + 1) . '</div>';
      $lista_usuarios[$key]['apellidos'] = $value['usuarios_paterno'] . ' ' . $value['usuarios_materno'];

      $lista_usuarios[$key]['options'] = '<div class="text-center"><a href="permisos_usuario?usuarios_id='.$value['usuarios_id'].'" data-nombres="' . $value['usuarios_nombres'] . ', ' . $value['usuarios_paterno'] . ' ' . $value['usuarios_materno'] . '" class="btn btn-info btn-sm open_modal_agregar_permiso" title="Editar usuario"><i class="fa-regular fa-hand-pointer"></i></a></div>';
    }

    json($lista_usuarios);
  }

  public function selectsUsuariosBloqueados()
  {
    parent::verificarLogin(true);
    parent::verificarPermiso(3, true);

    $usuarios_bloqueados = $this->model->usuarios_bloqueados();

    $auxUsuariosBloqueados = array();
    $auxUsuariosIdExist = array();
    $cont = -1;
    foreach ($usuarios_bloqueados as $key => $value) {
      if (!isset($auxUsuariosIdExist[$value['usuarios_id']])) {
        $cont = $cont + 1;
        $auxUsuariosIdExist[$value['usuarios_id']] = 'Ya existe';
        $auxUsuariosBloqueados[$cont] = array(
          'bloqueo_id' => $value['bloqueo_id'],
          'bloqueo_fechacreacion' => $value['bloqueo_fechacreacion'],
          'tipo_bloqueo_id' => $value['tipo_bloqueo_id'],
          'tipo_bloqueo_descripcion' => $value['tipo_bloqueo_descripcion'],
          'usuarios_id' => $value['usuarios_id'],
          'usuarios_nombres' => $value['usuarios_nombres'],
          'usuarios_paterno' => $value['usuarios_paterno'],
          'usuarios_materno' => $value['usuarios_materno'],
          'usuarios_dni' => $value['usuarios_dni'],
          'usuarios_cantidad' => 1
        );
      } else {
        $auxUsuariosBloqueados[$cont]['usuarios_cantidad']++;
      }
    }

    foreach ($auxUsuariosBloqueados as $key => $value) {
      $value['bloqueo_fechacreacion'] = new DateTime(str_replace(' ', 'T', $value['bloqueo_fechacreacion']) . 'America/Lima');
      $auxUsuariosBloqueados[$key]['numero'] = $key + 1;
      $auxUsuariosBloqueados[$key]['bloqueo_fechacreacion'] = '<div class="text-center"><span class="fw-bold">' . $value['bloqueo_fechacreacion']->format('h:i A') . '</span> - ' . $value['bloqueo_fechacreacion']->format('d/m/Y') . '</div>';
      $auxUsuariosBloqueados[$key]['usuarios_cantidad'] = '<span class="badge bg-warning-soft border border-warning text-body">' . $value['usuarios_cantidad'] . '</span>';
      $auxUsuariosBloqueados[$key]['nombre_completo'] = $value['usuarios_nombres'] . ', ' . $value['usuarios_paterno'] . ' ' . $value['usuarios_materno'];
      $auxUsuariosBloqueados[$key]['options'] = '<button data-nombres="' . $value['usuarios_nombres'] . ', ' . $value['usuarios_paterno'] . ' ' . $value['usuarios_materno'] . '" data-dni="' . $value['usuarios_dni'] . '" data-usuarios_id="' . $value['usuarios_id'] . '" title="Detalle del bloqueo del usuario" class="btn btn-sm btn-primary openmodal_detalle_bloqueo"><i class="feather-list"></i></button><button data-usuarios_id="' . $value['usuarios_id'] . '" data-nombres="' . $value['usuarios_nombres'] . ', ' . $value['usuarios_paterno'] . ' ' . $value['usuarios_materno'] . '" title="Desbloquear usuario" style="margin-left: 5px;" class="btn btn-sm btn-success btn_desbloquear"><i class="feather-unlock"></i></button>';
    }
    json($auxUsuariosBloqueados);
  }

  public function selectsUsuarioBloqueos()
  {
    parent::verificarLogin(true);
    parent::verificarPermiso(3, true);

    $return = array(
      'status' => false,
      'msg' => 'Error al consultar los motivos de bloqueo del usuario.',
      'value' => 'error',
      'data' => null
    );

    if (!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST) || !isset($_POST['usuarios_id']) || intval($_POST['usuarios_id']) === 0) {
      json($return);
    }

    // Verificamos que exista el usuario
    $seleccionar_usuario = $this->model->selectUsuarioById($_POST['usuarios_id']);
    if (!$seleccionar_usuario) {
      json($return);
    }

    // Consultamos los motivos de bloqueo del usuario
    $motivos_usuarios = $this->model->selectMotivoUsuarioById($_POST['usuarios_id']);
    foreach ($motivos_usuarios as $key => $value) {
      $motivos_usuarios[$key]['numero'] = $key + 1;
    }

    $return = array(
      'status' => true,
      'msg' => 'Lista de motivos del usuario.',
      'value' => 'success',
      'data' => ($motivos_usuarios === []) ? null : $motivos_usuarios
    );

    json($return);
  }

  public function selectsPermisoPersonalizados()
  {
    parent::verificarLogin(true);
    parent::verificarPermiso(4, true);

    $return = array(
      'status' => false,
      'msg' => 'Error al consultar los permisos personalizados del usuario.',
      'value' => 'error',
      'data' => null
    );

    if (!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST) || !isset($_POST['usuarios_id']) || intval($_POST['usuarios_id']) === 0) {
      json($return);
    }

    // Verificamos que exista el usuario
    $seleccionar_usuario = $this->model->selectUsuarioById($_POST['usuarios_id']);
    if (!$seleccionar_usuario) {
      json($return);
    }

    // Consultamos los permisos personalizados del usuario
    $permisos_personalizados = $this->model->selectPermisosUsuarioById($_POST['usuarios_id']);
    foreach ($permisos_personalizados as $key => $value) {
      $permisos_personalizados[$key]['numero'] = $key + 1;
    }

    $return = array(
      'status' => true,
      'msg' => 'Lista de permisos personalizados del usuario.',
      'value' => 'success',
      'data' => ($permisos_personalizados === []) ? null : $permisos_personalizados
    );

    json($return);
  }

  public function selectsPermisosPersonalizados()
  {
    parent::verificarLogin(true);
    parent::verificarPermiso(4, true);

    $permisos_personalizados = $this->model->usuarios_permisoPersonalizados();

    $auxPermisoPersonalizados = array();
    $auxUsuariosIdExist = array();
    $cont = -1;
    foreach ($permisos_personalizados as $key => $value) {
      if (!isset($auxUsuariosIdExist[$value['usuarios_id']])) {
        $cont = $cont + 1;
        $auxUsuariosIdExist[$value['usuarios_id']] = 'Ya existe';
        $auxPermisoPersonalizados[$cont] = array(
          'dpu_id' => $value['dpu_id'],
          'dpu_fechacreacion' => $value['dpu_fechacreacion'],
          'permiso_id' => $value['permiso_id'],
          'permiso_nombre' => $value['permiso_nombre'],
          'usuarios_id' => $value['usuarios_id'],
          'usuarios_nombres' => $value['usuarios_nombres'],
          'usuarios_paterno' => $value['usuarios_paterno'],
          'usuarios_materno' => $value['usuarios_materno'],
          'usuarios_dni' => $value['usuarios_dni'],
          'usuarios_cantidad' => 1
        );
      } else {
        $auxPermisoPersonalizados[$cont]['usuarios_cantidad']++;
      }
    }

    foreach ($auxPermisoPersonalizados as $key => $value) {
      $value['dpu_fechacreacion'] = new DateTime(str_replace(' ', 'T', $value['dpu_fechacreacion']) . 'America/Lima');
      $auxPermisoPersonalizados[$key]['numero'] = $key + 1;
      $auxPermisoPersonalizados[$key]['dpu_fechacreacion'] = '<div class="text-center"><span class="fw-bold">' . $value['dpu_fechacreacion']->format('h:i A') . '</span> - ' . $value['dpu_fechacreacion']->format('d/m/Y') . '</div>';
      $auxPermisoPersonalizados[$key]['usuarios_cantidad'] = '<span class="badge bg-warning-soft border border-warning text-body">' . $value['usuarios_cantidad'] . '</span>';
      $auxPermisoPersonalizados[$key]['nombre_completo'] = $value['usuarios_nombres'] . ', ' . $value['usuarios_paterno'] . ' ' . $value['usuarios_materno'];
      $auxPermisoPersonalizados[$key]['options'] = '<button data-nombres="' . $value['usuarios_nombres'] . ', ' . $value['usuarios_paterno'] . ' ' . $value['usuarios_materno'] . '" data-dni="' . $value['usuarios_dni'] . '" data-usuarios_id="' . $value['usuarios_id'] . '" title="Detalle de los permisos personalizados del usuario" class="btn btn-sm btn-primary openmodal_permiso_personalizados"><i class="feather-list"></i></button><button data-usuarios_id="' . $value['usuarios_id'] . '" data-nombres="' . $value['usuarios_nombres'] . ', ' . $value['usuarios_paterno'] . ' ' . $value['usuarios_materno'] . '" title="Eliminar permisos personalizados" style="margin-left: 5px" class="btn btn-sm btn-danger btn_eliminar_permisos_personalizados"><i class="fa-regular fa-trash-can"></i></button>';
    }
    json($auxPermisoPersonalizados);
  }

  public function agregarUsuario()
  {
    parent::verificarLogin(true);
    parent::verificarPermiso(1, true);

    $return = array(
      'status' => false,
      'msg' => 'Error al momento de agregar un nuevo usuario.',
      'value' => 'error'
    );

    if (!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST) || !isset($_POST['password']) || !isset($_POST['usuarios_nombres']) || empty($_POST['usuarios_nombres']) || !isset($_POST['usuarios_paterno']) || empty($_POST['usuarios_paterno']) || !isset($_POST['usuarios_materno']) || empty($_POST['usuarios_materno']) || !isset($_POST['usuarios_email']) || empty($_POST['usuarios_email']) || !isset($_POST['usuarios_login']) || empty($_POST['usuarios_login']) || !isset($_POST['usuarios_dni']) || empty($_POST['usuarios_dni']) || strlen($_POST['usuarios_dni']) !== 8) {
      json($return);
    }

    // Validamos el email
    if (!filter_var($_POST['usuarios_email'], FILTER_VALIDATE_EMAIL)) {
      $return['msg'] = 'Correo electrónico inválido.';
      $return['value'] = 'warning';
      json($return);
    }

    // Limpiamos los espacios en blanco de las cadenas
    $password = strClean($_POST['password']);
    $login = deleteEspacios(convertMinusculas(strClean($_POST['usuarios_login'])));
    $nombres = convertCapital(strClean($_POST['usuarios_nombres']));
    $paterno = convertMayuscular(strClean($_POST['usuarios_paterno']));
    $materno = convertMayuscular(strClean($_POST['usuarios_materno']));
    $dni = strClean($_POST['usuarios_dni']);

    // Validamos el password
    if (!validarPassword($password)[0]) {
      $return['msg'] = 'Las contraseñas son inválidas.';
      $return['value'] = 'warning';
      json($return);
    }

    // Validamos el número de dni ingresado
    if (strlen($_POST['usuarios_dni']) !== 8 || !is_numeric($_POST['usuarios_dni'])) {
      $return['msg'] = 'Número de dni inválido.';
      json($return);
    }

    // Consultamos los datos de DNI en la ApiRest
    $dataDNI = new ApiRest(false);
    $datos_dni = $dataDNI->apiDni($_POST['usuarios_dni']);

    if ($datos_dni['status']) {
      $nombres = convertCapital(strClean($datos_dni['data']['nombres']));
      $paterno = convertMayuscular(strClean($datos_dni['data']['apellido_paterno']));
      $materno = convertMayuscular(strClean($datos_dni['data']['apellido_materno']));
      $dni = strClean($datos_dni['data']['dni']);
    }

    // Verificamos si existe un usuario con este número de DNI
    $seleccionar_usuario = $this->model->selectUsuarioByDni($dni);
    if ($seleccionar_usuario) {
      $return['msg'] = 'Ya se encuentra registrado un usuario con este número de DNI.';
      $return['value'] = 'warning';
      json($return);
    }

    // Consultamos si hay roles seleccionados
    $seleccionar_roles = $this->model->selectsRoles();
    $auxRolesSeleccionados = array();
    $cont = 0;
    foreach ($seleccionar_roles as $key => $value) {
      if (isset($_POST['roles_' . $value['roles_id']])) {
        $auxRolesSeleccionados[$cont++] = ['roles_id' => $value['roles_id']];
      }
    }

    if (empty($auxRolesSeleccionados)) {
      $return['msg'] = 'El usuario debe tener al menos un rol asignado.';
      $return['value'] = 'warning';
      json($return);
    }

    // Registramos al nuevo usuario
    $insert_usuario = $this->model->insertUsuario(
      $login,
      $nombres,
      $paterno,
      $materno,
      $dni,
      $_POST['usuarios_email'],
      $password
    );

    if ($insert_usuario === 0) {
      json($return);
    }

    // insertamos los nuevos roles de usuario
    $rolIsertadoCorrectamente = true;
    foreach ($auxRolesSeleccionados as $key => $value) {
      $insert_roles_usuarios = $this->model->insertRolUsuario($value['roles_id'], $insert_usuario);
      if (!$insert_roles_usuarios) {
        $rolIsertadoCorrectamente = false;
      }
    }

    if (!$rolIsertadoCorrectamente) {
      $return = array(
        'status' => true,
        'msg' => 'Algunos datos del usuario no fuerón registrados correctamente, ¡ Revisar !',
        'value' => 'success'
      );
      json($return);
    }

    $return = array(
      'status' => true,
      'msg' => 'Usuario registrado correctamente.',
      'value' => 'success'
    );
    json($return);
  }

  public function insertUsuarioBloqueo()
  {
    parent::verificarLogin(true);
    parent::verificarPermiso(3, true);

    $return = array(
      'status' => false,
      'msg' => 'Error al momento de bloquear al usuario.',
      'value' => 'error'
    );

    if (!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST) || !isset($_POST['usuarios_id']) || intval($_POST['usuarios_id']) === 0 || !isset($_POST['tipo_bloqueo_id']) || intval($_POST['tipo_bloqueo_id']) === 0) {
      json($return);
    }

    // Verificamos que exista este usuario con este ID
    $seleccionar_usuario = $this->model->selectUsuarioById($_POST['usuarios_id']);
    if (!$seleccionar_usuario) {
      json($return);
    }

    // Verificamos que exista este tipo de bloqueo con este ID
    $seleccionar_tipoBloqueo = $this->model->selectTipoBloqueoById($_POST['tipo_bloqueo_id']);
    if (!$seleccionar_tipoBloqueo) {
      json($return);
    }

    // Verificamos que no exista este usuario y tipo de bloqueo con estes IDs
    $seleccionar_tipoBloqueo = $this->model->selectTipoBloqueoUsuarioById($_POST['usuarios_id'], $_POST['tipo_bloqueo_id']);
    if ($seleccionar_tipoBloqueo) {
      $return['msg'] = 'Este usuario ya se encuentra bloqueado por este motivo.';
      $return['value'] = 'warning';
      json($return);
    }

    $insert_usuario_bloqueo = $this->model->insertUsuarioBloqueo($_POST['usuarios_id'], $_POST['tipo_bloqueo_id']);
    if (!$insert_usuario_bloqueo) {
      json($return);
    }

    $return = array(
      'status' => true,
      'msg' => 'Usuario bloqueado correctamente.',
      'value' => 'success'
    );

    json($return);
  }

  public function updateUsuario()
  {
    parent::verificarLogin(true);
    parent::verificarPermiso(1, true);

    $return = array(
      'status' => false,
      'msg' => 'Error al momento de actualizar el usuario.',
      'value' => 'error'
    );

    if (!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST) || !isset($_POST['usuarios_id']) || intval($_POST['usuarios_id']) === 0 || !isset($_POST['update_rol']) || (intval($_POST['update_rol']) !== 0 && intval($_POST['update_rol']) !== 1) || !isset($_POST['password_new']) || !isset($_POST['password_val']) || !isset($_POST['usuarios_nombres']) || empty($_POST['usuarios_nombres']) || !isset($_POST['usuarios_paterno']) || empty($_POST['usuarios_paterno']) || !isset($_POST['usuarios_materno']) || empty($_POST['usuarios_materno']) || !isset($_POST['usuarios_email']) || empty($_POST['usuarios_email']) || !isset($_POST['usuarios_login']) || empty($_POST['usuarios_login']) || !isset($_POST['usuarios_dni']) || empty($_POST['usuarios_dni']) || strlen($_POST['usuarios_dni']) !== 8) {
      json($return);
    }

    // Validamos el email
    if (!filter_var($_POST['usuarios_email'], FILTER_VALIDATE_EMAIL)) {
      $return['msg'] = 'Correo electrónico inválido.';
      $return['value'] = 'warning';
      json($return);
    }

    // Limpiamos los espacios en blanco de las cadenas
    $password = strClean($_POST['password_new']);
    $password_val = strClean($_POST['password_val']);
    $login = strClean($_POST['usuarios_login']);
    $nombres = strClean($_POST['usuarios_nombres']);
    $paterno = strClean($_POST['usuarios_paterno']);
    $materno = strClean($_POST['usuarios_materno']);
    $dni = strClean($_POST['usuarios_dni']);

    $updatePassword = false;
    // Validamos el password
    if (!empty($password) || !empty($password_val)) {
      if ($password === $password_val) {
        if (!validarPassword($password)[0]) {
          $return['msg'] = 'Las contraseñas son inválidas.';
          $return['value'] = 'warning';
          json($return);
        }
      } else {
        $return['msg'] = 'Las contraseñas no coinciden.';
        $return['value'] = 'warning';
        json($return);
      }

      $updatePassword = true;
    }

    // Verificamos que exista el usuario
    $seleccionar_usuario = $this->model->selectUsuarioById($_POST['usuarios_id']);
    if (!$seleccionar_usuario) {
      json($return);
    }

    // Actualizamos el usuario
    $update_usuario = $this->model->updateUsuario(
      $login,
      $nombres,
      $paterno,
      $materno,
      $dni,
      $_POST['usuarios_email'],
      $_POST['usuarios_id']
    );

    if (!$update_usuario) {
      json($return);
    }

    // Actualizamos el password del usuario
    if ($updatePassword) {
      $actualizar_Password = $this->model->updatePasswordUsuario($password, $_POST['usuarios_id']);
      if (!$actualizar_Password) {
        $return = array(
          'status' => true,
          'msg' => 'Algunos datos de usuario no fueron actualizados correctamente, ¡ Revisar !',
          'value' => 'success'
        );
        json($return);
      }
    }

    // Falta actualizar los roles
    if (intval($_POST['update_rol']) === 1) {
      $seleccionar_roles = $this->model->selectsRoles();

      $auxRolesSeleccionados = array();
      $cont = 0;
      foreach ($seleccionar_roles as $key => $value) {
        if (isset($_POST['roles_' . $value['roles_id']])) {
          $auxRolesSeleccionados[$cont++] = ['roles_id' => $value['roles_id']];
        }
      }

      if (!empty($auxRolesSeleccionados)) {
        // Eliminamos los roles del usuario asignados anteriormente
        $this->model->deleteRolUsuarioById($_POST['usuarios_id']);

        // insertamos los nuevos roles de usuario
        $rolIsertadoCorrectamente = true;
        foreach ($auxRolesSeleccionados as $key => $value) {
          $insert_roles_usuarios = $this->model->insertRolUsuario($value['roles_id'], $_POST['usuarios_id']);
          if (!$insert_roles_usuarios) {
            $rolIsertadoCorrectamente = false;
          }
        }

        if (!$rolIsertadoCorrectamente) {
          $return = array(
            'status' => true,
            'msg' => 'Algunos datos de usuario no fueron actualizados correctamente, ¡ Revisar !',
            'value' => 'success'
          );
          json($return);
        }
      }
    }

    $return = array(
      'status' => true,
      'msg' => 'Datos del usuario actualizado correctamente.',
      'value' => 'success'
    );
    json($return);
  }

  public function updateFotoPefilUsuario()
  {
    parent::verificarLogin(true);
    parent::verificarPermiso(1, true);

    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
      location('usuarios/lista_usuario');
    }

    $return = array(
      'status' => false,
      'msg' => 'Error al momento de intentar subir la foto de perfil',
      'value' => 'error',
      'name_foto' => null
    );

    if (!isset($_POST) || !isset($_POST['usuarios_id']) || intval($_POST['usuarios_id']) === 0) {
      json($return);
    }

    $file = $_FILES['fileprofile'];

    if (!isset($_FILES['fileprofile']) || $_FILES['fileprofile']['error'] !== 0) {
      $return = array(
        'status' => false,
        'msg' => 'Esta imagen es inválida o no existe.',
        'value' => 'warning'
      );

      json($return);
    }

    if ($_FILES['fileprofile']['type'] !== 'image/jpeg' && $_FILES['fileprofile']['type'] !== 'image/png') {
      $return['msg'] = 'Formato de imagen no válida.';
      $return['value'] = 'warning';

      json($return);
    }

    $file['name'] = getExtension($file['name']);
    $noValido = true;

    foreach (getExtFotos() as $key => $value) {
      if ($value == $file['name']) {
        $noValido = false;
        break;
      }
    }

    if ($file['name'] == false || $noValido) {
      $return['msg'] = 'Tipo de imagen no válida, seleccione otra';
      $return['value'] = 'warning';

      json($return);
    }

    // Varificamos que exista este usuario
    $seleccionar_usuario = $this->model->selectUsuarioById($_POST['usuarios_id']);
    if (!$seleccionar_usuario) {
      json($return);
    }

    $file['name'] = 'user_profile_' . date('Ymd_His') . '.' . $file['name'];
    $onlyName = $file['name'];
    $file['name'] = getPathFotoPerfil() . $file['name'];

    $uploaded = move_uploaded_file($file['tmp_name'], $file['name']);

    if (!$uploaded) {
      json($return);
    }

    $update = $this->model->updateFoto($onlyName, $_POST['usuarios_id']);
    if (!$update) {
      $return['msg'] = 'Foto de perfil cambiado correctamente, pero no fue asigando al usuario';
      $return['value'] = 'warning';
      $return['name_foto'] = $onlyName;
      json($return);
    }

    $return = array(
      'status' => true,
      'msg' => 'Foto de perfil cambiado correctamente.',
      'value' => 'success',
      'name_foto' => $onlyName
    );

    json($return);
  }

  public function deleteMotivoBloqueo()
  {
    parent::verificarLogin(true);
    parent::verificarPermiso(3, true);

    $return = array(
      'status' => false,
      'msg' => 'Error al eliminar el motivo de bloqueo del usuario.',
      'value' => 'error',
      'data' => null
    );

    if (!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST) || !isset($_POST['bloqueo_id']) || intval($_POST['bloqueo_id']) === 0) {
      json($return);
    }

    // Consultamos si existe el usuario y el motivo
    $select_bloqueo = $this->model->selectMotivoBloqueoById($_POST['bloqueo_id']);
    if (!$select_bloqueo) {
      json($return);
    }

    $usuarios_id = $select_bloqueo['usuarios_id'];
    $eliminar_bloqueo = $this->model->deleteMotivoBloqueo($_POST['bloqueo_id']);
    if (!$eliminar_bloqueo) {
      json($return);
    }

    // Consultamos nuevamente los bloqueos del usuario
    $usuario_bloqueos = $this->model->selectMotivoUsuarioById($usuarios_id);
    foreach ($usuario_bloqueos as $key => $value) {
      $usuario_bloqueos[$key]['numero'] = $key + 1;
    }
    $return = array(
      'status' => true,
      'msg' => 'Motivo eliminado correctamente.',
      'value' => 'success',
      'data' => ($usuario_bloqueos === []) ? null : $usuario_bloqueos
    );

    json($return);
  }

  public function deletePermisoPersonalizado()
  {
    parent::verificarLogin(true);
    parent::verificarPermiso(4, true);

    $return = array(
      'status' => false,
      'msg' => 'Error al eliminar el permiso del usuario.',
      'value' => 'error',
      'data' => null
    );

    if (!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST) || !isset($_POST['permisopersonalizado_id']) || intval($_POST['permisopersonalizado_id']) === 0) {
      json($return);
    }

    // Consultamos si existe el usuario y el permiso personalizado
    $select_permisoPersonalizado = $this->model->selectPermisoPersonalizadoById($_POST['permisopersonalizado_id']);
    if (!$select_permisoPersonalizado) {
      json($return);
    }

    $usuarios_id = $select_permisoPersonalizado['usuarios_id'];
    $eliminar_permiso_personalizado = $this->model->deletePermisoPersonalizado($_POST['permisopersonalizado_id']);
    if (!$eliminar_permiso_personalizado) {
      json($return);
    }

    // Consultamos nuevamente los permiso personalizados del usuario
    $usuario_permisos_personalizados = $this->model->selectPermisosUsuarioById($usuarios_id);
    foreach ($usuario_permisos_personalizados as $key => $value) {
      $usuario_permisos_personalizados[$key]['numero'] = $key + 1;
    }
    $return = array(
      'status' => true,
      'msg' => 'Permiso eliminado correctamente.',
      'value' => 'success',
      'data' => ($usuario_permisos_personalizados === []) ? null : $usuario_permisos_personalizados
    );

    json($return);
  }

  public function desbloquearUsuario()
  {
    parent::verificarLogin(true);
    parent::verificarPermiso(3, true);

    $return = array(
      'status' => false,
      'msg' => 'Error al momento de desbloquear al usuario.',
      'value' => 'error'
    );

    if (!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST) || !isset($_POST['usuarios_id']) || intval($_POST['usuarios_id']) === 0) {
      json($return);
    }

    // Verficamos que exista este usuario con este ID
    $seleccionar_usuario = $this->model->selectUsuarioById($_POST['usuarios_id']);
    if (!$seleccionar_usuario) {
      json($return);
    }

    // Elinamos todos los motivos de bloqueo del usuario
    $eliminar_bloqueos_usuario = $this->model->deleteBloqueosUsuario($_POST['usuarios_id']);
    if (!$eliminar_bloqueos_usuario) {
      json($return);
    }

    $return = array(
      'status' => true,
      'msg' => 'Usuario desbloqueado correctamente.',
      'value' => 'success'
    );

    json($return);
  }

  public function deletePermisosPersonalizados()
  {
    parent::verificarLogin(true);
    parent::verificarPermiso(4, true);

    $return = array(
      'status' => false,
      'msg' => 'Error al momento de eliminar los permisos del usuario.',
      'value' => 'error'
    );

    if (!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST) || !isset($_POST['usuarios_id']) || intval($_POST['usuarios_id']) === 0) {
      json($return);
    }

    // Verficamos que exista este usuario con este ID
    $seleccionar_usuario = $this->model->selectUsuarioById($_POST['usuarios_id']);
    if (!$seleccionar_usuario) {
      json($return);
    }

    // Elinamos todos los permisos del usuario
    $eliminar_permisos_usuario = $this->model->deletePermisosUsuario($_POST['usuarios_id']);
    if (!$eliminar_permisos_usuario) {
      json($return);
    }

    $return = array(
      'status' => true,
      'msg' => 'Permisos eliminados del usuario correctamente.',
      'value' => 'success'
    );

    json($return);
  }

  public function updateUsuarioPermisos()
  {
    parent::verificarLogin(true);
    parent::verificarPermiso(4, true);

    $return = [
      'status' => false,
      'msg' => 'Error al momento de actualizar los permisos del usuario.',
      'value' => 'error'
    ];

    if (!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST) || !isset($_POST['usuarios_id']) || intval($_POST['usuarios_id']) === 0) {
      json($return);
    }

    $auxPOST = array();
    foreach ($_POST as $key => $value) {
      if ($key !== 'usuarios_id') {
        $auxPOST[$key] = $value;
      }
    }

    if (empty($auxPOST)) {
      $return['msg'] = 'El usuario debe tener al menos un permiso.';
      $return['value'] = 'warning';
      json($return);
    }

    // Verificamos que exista el usuario
    $seleccionar_usuario = $this->model->selectUsuarioById($_POST['usuarios_id']);
    if(!$seleccionar_usuario)
    {
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

    $eliminar_permisos_usuario = $this->model->deletePermisosUsuario($_POST['usuarios_id']);
    if (!$eliminar_permisos_usuario) {
      json($return);
    }

    $todoCorrecto = true;
    foreach ($permisosActivos as $key => $value) {
      $insertar_permiso_usuario = $this->model->insertDetUsuarioPermiso($_POST['usuarios_id'], $value);
      if (!$insertar_permiso_usuario) {
        $todoCorrecto = false;
      }
    }

    if (!$todoCorrecto) {
      $return['msg'] = 'Revisar algunos de los permisos no se guardaron correctamente.';
      $return['value'] = 'warning';
      json($return);
    }

    $return = [
      'status' => true,
      'msg' => 'Permisos actualizados correctamente.',
      'value' => 'success'
    ];

    json($return);
  }
}
