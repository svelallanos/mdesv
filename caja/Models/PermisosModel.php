<?php
class PermisosModel extends Mysql
{
  public function __construct()
  {
    parent::__construct();
  }

  public function getPermisosRolById(int $roles_id)
  {
    $sql = 'SELECT * FROM detalle_rol_permiso 
    INNER JOIN roles ON detalle_rol_permiso.roles_id = roles.roles_id 
    WHERE detalle_rol_permiso.roles_id = :roles_id';
    $result = $this->select_all($sql, array('roles_id'=>$roles_id), DB_CAJA);
    return $result;
  }

  public function getPermisos($usuarios_id)
  {
    $sql = 'SELECT * FROM detalle_rol_usuario 
    INNER JOIN roles ON detalle_rol_usuario.roles_id = roles.roles_id
    INNER JOIN detalle_rol_permiso ON detalle_rol_permiso.roles_id = roles.roles_id 
    WHERE detalle_rol_usuario.usuarios_id = :usuarios_id';
    $result = $this->select_all($sql, array('usuarios_id'=>$usuarios_id), DB_CAJA);
    return $result;
  }

  public function getPermisosUsuario($usuarios_id)
  {
    $sql = 'SELECT * FROM det_permiso_usuarios WHERE usuarios_id = :usuarios_id';
    $resData = $this->select_all($sql, array('usuarios_id' => $usuarios_id), DB_CAJA);
    return $resData;
  }
}
