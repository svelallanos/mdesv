<?php

class UsuariosModel extends Mysql
{
  function __construct()
  {
    parent::__construct();
  }

  // Funciones select_all

  public function getRoles(int $usuarios_id)
  {
    $sql = 'SELECT * FROM detalle_rol_usuario 
    INNER JOIN roles ON detalle_rol_usuario.roles_id = roles.roles_id 
    WHERE detalle_rol_usuario.usuarios_id = :usuarios_id';
    $result = $this->select_all($sql, array('usuarios_id'=>$usuarios_id), DB_CAJA);
    return $result;
  }

  public function selectsUsersByEstado(int $usuarios_estado = 1)
  {
    $sql = 'SELECT * FROM usuarios';
    $request = $this->select_all($sql, array(), DB_CAJA);
    return $request;
  }

  public function selectsUsuariosGlobal()
  {
    $sql = 'SELECT * FROM usuarios';
    $request = $this->select_all($sql, array(), DB_CAJA);
    return $request;
  }

  public function selectsRolUsuarioByIdUsuario(int $usuarios_id)
  {
    $sql = 'SELECT * FROM detalle_rol_usuario
    WHERE usuarios_id = :usuarios_id';
    $request = $this->select_all($sql, array('usuarios_id' => $usuarios_id), DB_CAJA);
    return $request;
  }

  public function selectsRolUsuarioBib()
  {
    $sql = 'SELECT * FROM detalle_rol_usuario
    INNER JOIN roles ON detalle_rol_usuario.roles_id = roles.roles_id
    ORDER BY usuarios_id';
    $request = $this->select_all($sql, array(), DB_CAJA);
    return $request;
  }

  public function selectsRoles(int $roles_estado = 1)
  {
    $sql = 'SELECT * FROM roles
    WHERE roles_estado = :roles_estado';
    $request = $this->select_all($sql, array('roles_estado' => $roles_estado), DB_CAJA);
    return $request;
  }

  public function selectsTipoBloqueo()
  {
    $sql = 'SELECT * FROM tipo_bloqueo
    ORDER BY tipo_bloqueo_descripcion ASC';
    $request = $this->select_all($sql, array(), DB_CAJA);
    return $request;
  }

  public function usuarios_bloqueados()
  {
    $sql = 'SELECT * FROM bloqueo
    INNER JOIN usuarios ON bloqueo.usuarios_id = usuarios.usuarios_id
    INNER JOIN tipo_bloqueo ON bloqueo.tipo_bloqueo_id = tipo_bloqueo.tipo_bloqueo_id
    ORDER BY bloqueo.usuarios_id ASC, bloqueo.tipo_bloqueo_id ASC';
    $request = $this->select_all($sql, array(), DB_CAJA);
    return $request;
  }

  public function usuarios_permisoPersonalizados()
  {
    $sql = 'SELECT * FROM det_permiso_usuarios
    INNER JOIN usuarios ON det_permiso_usuarios.usuarios_id = usuarios.usuarios_id
    INNER JOIN permiso ON det_permiso_usuarios.permiso_id = permiso.permiso_id
    ORDER BY det_permiso_usuarios.usuarios_id ASC, det_permiso_usuarios.permiso_id ASC';
    $request = $this->select_all($sql, array(), DB_CAJA);
    return $request;
  }

  public function usuariosBloqueadosGroupBy()
  {
    $sql = 'SELECT usuarios_id FROM bloqueo
    GROUP BY usuarios_id';
    $request = $this->select_all($sql, array(), DB_CAJA);
    return $request;
  }

  public function selectMotivoUsuarioById(int $usuarios_id)
  {
    $sql = 'SELECT * FROM bloqueo
    INNER JOIN tipo_bloqueo ON bloqueo.tipo_bloqueo_id = tipo_bloqueo.tipo_bloqueo_id
    WHERE usuarios_id = :usuarios_id
    ORDER BY tipo_bloqueo.tipo_bloqueo_descripcion ASC';
    $request = $this->select_all($sql, array('usuarios_id' => $usuarios_id), DB_CAJA);
    return $request;
  }

  public function selectPermisosUsuarioById(int $usuarios_id)
  {
    $sql = 'SELECT * FROM det_permiso_usuarios
    INNER JOIN permiso ON det_permiso_usuarios.permiso_id = permiso.permiso_id
    WHERE usuarios_id = :usuarios_id
    ORDER BY permiso.permiso_nombre ASC';
    $request = $this->select_all($sql, array('usuarios_id' => $usuarios_id), DB_CAJA);
    return $request;
  }

  public function selectsPermisosUsuario(int $usuarios_id)
  {
    $sql = 'SELECT * FROM det_permiso_usuarios
    WHERE usuarios_id = :usuarios_id';
    $request = $this->select_all($sql, array('usuarios_id' => $usuarios_id), DB_CAJA);
    return $request;
  }

  public function selectsPermisos(int $permiso_estado = 1, bool $valEstado = false)
  {
    $auxsql = '';
    if ($valEstado) {
      $auxsql = 'WHERE p.permiso_estado = :permiso_estado';
    }
    $sql = 'SELECT p.permiso_id, p.permiso_nombre, p.permiso_orden, p.permiso_id, p.permiso_estado, p.grupo_permiso_id, gp.grupo_permiso_nombre FROM permiso AS p
    INNER JOIN grupo_permiso AS gp ON p.grupo_permiso_id = gp.grupo_permiso_id
    ' . $auxsql . '
    ORDER BY p.grupo_permiso_id ASC';

    if ($valEstado) {
      $request = $this->select_all($sql, array('permiso_estado' => $permiso_estado), DB_CAJA);
    } else {
      $request = $this->select_all($sql, array(), DB_CAJA);
    }
    return $request;
  }

  // Funciones select

  public function selectUsuarioNombreApellido(string $nombres, string $apellidoPaterno, string $apellidoMaterno)
  {
    $sql = 'SELECT * FROM usuarios
    WHERE usuarios_nombres = :usuarios_nombres AND usuarios_paterno = :usuarios_paterno AND usuarios_materno = :usuarios_materno';
    $request = $this->select($sql, array('usuarios_nombres' => $nombres, 'usuarios_paterno' => $apellidoPaterno, 'usuarios_materno' => $apellidoMaterno), DB_CAJA);
    return $request;
  }

  public function selectUsuarioById(int $usuarios_id)
  {
    $sql = 'SELECT * FROM usuarios
    WHERE usuarios_id = :usuarios_id';
    $request = $this->select($sql, array('usuarios_id' => $usuarios_id), DB_CAJA);
    return $request;
  }

  public function selectUsuarioByDni(int $usuarios_dni)
  {
    $sql = 'SELECT * FROM usuarios
    WHERE usuarios_dni = :usuarios_dni';
    $request = $this->select($sql, array('usuarios_dni' => $usuarios_dni), DB_CAJA);
    return $request;
  }


  public function selectUsuarioLogin(string $usuarios_login)
  {
    $sql = 'SELECT * FROM usuarios
    WHERE usuarios_login = :usuarios_login';
    $request = $this->select($sql, array('usuarios_login' => $usuarios_login), DB_CAJA);
    return $request;
  }

  public function selectAlumnoBibliotecaByDni(string $usuarios_dni)
  {
    $sql = 'SELECT * FROM usuarios
    WHERE usuarios_dni = :usuarios_dni';
    $request = $this->select($sql, array('usuarios_dni' => $usuarios_dni), DB_CAJA);
    return $request;
  }

  public function selectMotivoBloqueoById(int $bloqueo_id)
  {
    $sql = 'SELECT * FROM bloqueo
    WHERE bloqueo_id = :bloqueo_id';
    $request = $this->select($sql, array('bloqueo_id' => $bloqueo_id), DB_CAJA);
    return $request;
  }

  public function selectPermisoPersonalizadoById(int $dpu_id)
  {
    $sql = 'SELECT * FROM det_permiso_usuarios
    WHERE dpu_id = :dpu_id';
    $request = $this->select($sql, array('dpu_id' => $dpu_id), DB_CAJA);
    return $request;
  }

  public function selectTipoBloqueoById(int $tipo_bloqueo_id)
  {
    $sql = 'SELECT * FROM tipo_bloqueo
    WHERE tipo_bloqueo_id = :tipo_bloqueo_id';
    $request = $this->select($sql, array('tipo_bloqueo_id' => $tipo_bloqueo_id), DB_CAJA);
    return $request;
  }

  public function selectTipoBloqueoUsuarioById(int $usuarios_id, int $tipo_bloqueo_id)
  {
    $sql = 'SELECT * FROM bloqueo
    WHERE usuarios_id = :usuarios_id AND tipo_bloqueo_id = :tipo_bloqueo_id';
    $request = $this->select($sql, array('usuarios_id' => $usuarios_id, 'tipo_bloqueo_id' => $tipo_bloqueo_id), DB_CAJA);
    return $request;
  }

  // Funciones insert

  public function insertUsuario(string $usuarios_login, string $usuarios_nombres, string $usuarios_paterno, string $usuarios_materno, string $usuarios_dni, string $usuarios_email, string $usuarios_password)
  {
    // Encriptamos la contraseña
    $password = password_hash($usuarios_password, PASSWORD_BCRYPT);

    $sql = 'INSERT INTO usuarios(usuarios_login,usuarios_nombres,usuarios_paterno,usuarios_materno,usuarios_dni,usuarios_email,usuarios_password, usuarios_foto) VALUES (:usuarios_login, :usuarios_nombres, :usuarios_paterno, :usuarios_materno, :usuarios_dni, :usuarios_email, :usuarios_password, :usuarios_foto)';
    $arrData = [
      'usuarios_login' => $usuarios_login,
      'usuarios_nombres' => $usuarios_nombres,
      'usuarios_paterno' => $usuarios_paterno,
      'usuarios_materno' => $usuarios_materno,
      'usuarios_dni' => $usuarios_dni,
      'usuarios_email' => $usuarios_email,
      'usuarios_password' => $password,
      'usuarios_foto' => 'sin_foto.png'
    ];
    $request = $this->insert($sql, $arrData, DB_CAJA);
    return $request;
  }

  public function insertRolUsuario(int $roles_id, int $usuarios_id)
  {
    $sql = 'INSERT INTO detalle_rol_usuario (roles_id, usuarios_id) VALUES (:roles_id, :usuarios_id)';
    $request = $this->insert($sql, array('roles_id' => $roles_id, 'usuarios_id' => $usuarios_id), DB_CAJA);
    return $request;
  }

  public function insertUsuarioBloqueo(int $usuarios_id, int $tipo_bloqueo_id)
  {
    $sql = 'INSERT INTO bloqueo (usuarios_id, tipo_bloqueo_id) VALUES (:usuarios_id, :tipo_bloqueo_id)';
    $request = $this->insert($sql, array('usuarios_id' => $usuarios_id, 'tipo_bloqueo_id' => $tipo_bloqueo_id), DB_CAJA);
    return $request;
  }

  public function insertDetUsuarioPermiso(int $usuarios_id, int $permiso_id)
  {
    $sql = 'INSERT INTO det_permiso_usuarios (usuarios_id, permiso_id) VALUES (:usuarios_id, :permiso_id)';
    $request = $this->insert($sql, array('usuarios_id' => $usuarios_id, 'permiso_id' => $permiso_id), DB_CAJA);
    return $request;
  }

  // Funciones update
  public function updateUsuario(string $usuarios_login, string $usuarios_nombres, string $usuarios_paterno, string $usuarios_materno, string $usuarios_dni, string $usuarios_email, int $usuarios_id)
  {

    $sql = 'UPDATE usuarios SET 
    usuarios_login = :usuarios_login, 
    usuarios_nombres = :usuarios_nombres,
    usuarios_paterno = :usuarios_paterno,
    usuarios_materno = :usuarios_materno,
    usuarios_dni = :usuarios_dni,
    usuarios_email = :usuarios_email
    WHERE usuarios_id = :usuarios_id';

    $arrData = array(
      'usuarios_login' => $usuarios_login,
      'usuarios_nombres' => $usuarios_nombres,
      'usuarios_paterno' => $usuarios_paterno,
      'usuarios_materno' => $usuarios_materno,
      'usuarios_dni' => $usuarios_dni,
      'usuarios_email' => $usuarios_email,
      'usuarios_id' => $usuarios_id
    );

    $request = $this->update($sql, $arrData, DB_CAJA);
    return $request;
  }

  public function updatePasswordUsuario(string $usuarios_password, int $usuarios_id)
  {
    // Encriptamos la contraseña
    $password = password_hash($usuarios_password, PASSWORD_BCRYPT);

    $sql = 'UPDATE usuarios SET usuarios_password = :usuarios_password
    WHERE usuarios_id = :usuarios_id';
    $request = $this->update($sql, array('usuarios_password' => $password, 'usuarios_id' => $usuarios_id), DB_CAJA);
    return $request;
  }

  public function updateFoto(string $usuarios_foto, int $usuarios_id)
  {
    $sql = 'UPDATE usuarios SET usuarios_foto = :usuarios_foto
    WHERE usuarios_id = :usuarios_id';
    $request = $this->update($sql, array('usuarios_foto' => $usuarios_foto, 'usuarios_id' => $usuarios_id), DB_CAJA);
    return $request;
  }
  // Funciones delete

  public function deleteRolUsuarioById(int $usuarios_id)
  {
    $sql = 'DELETE FROM detalle_rol_usuario WHERE usuarios_id = :usuarios_id';
    $request = $this->update($sql, array('usuarios_id' => $usuarios_id), DB_CAJA);
    return $request;
  }

  public function deleteMotivoBloqueo(int $bloqueo_id)
  {
    $sql = 'DELETE FROM bloqueo WHERE bloqueo_id = :bloqueo_id';
    $request = $this->update($sql, array('bloqueo_id' => $bloqueo_id), DB_CAJA);
    return $request;
  }

  public function deletePermisoPersonalizado(int $dpu_id)
  {
    $sql = 'DELETE FROM det_permiso_usuarios WHERE dpu_id = :dpu_id';
    $request = $this->update($sql, array('dpu_id' => $dpu_id), DB_CAJA);
    return $request;
  }

  public function deleteBloqueosUsuario(int $usuarios_id)
  {
    $sql = 'DELETE FROM bloqueo WHERE usuarios_id = :usuarios_id';
    $request = $this->update($sql, array('usuarios_id' => $usuarios_id), DB_CAJA);
    return $request;
  }

  public function deletePermisosUsuario(int $usuarios_id)
  {
    $sql = 'DELETE FROM det_permiso_usuarios WHERE usuarios_id = :usuarios_id';
    $request = $this->update($sql, array('usuarios_id' => $usuarios_id), DB_CAJA);
    return $request;
  }
}
