<?php

class RolesModel extends Mysql
{
  function __construct()
  {
    parent::__construct();
  }

  // Funciones select_all

  public function selectsRoles(int $roles_estado = 1)
  {
    $sql = 'SELECT * FROM roles
    -- WHERE roles_estado = :roles_estado
    ';
    $request = $this->select_all($sql, array(), DB_CAJA);
    // $request = $this->select_all($sql, array('roles_estado' => $roles_estado), DB_CAJA);
    return $request;
  }

  public function selectsGrupoPermisos(int $grupo_permiso_estado = 1)
  {
    $auxConsulta = 'WHERE grupo_permiso_estado = :grupo_permiso_estado';
    $arrData = array('grupo_permiso_estado' => $grupo_permiso_estado);
    if ($grupo_permiso_estado == 0) {
      $auxConsulta = '';
      $arrData = array();
    }
    $sql = 'SELECT * FROM grupo_permiso
    ' . $auxConsulta;
    $request = $this->select_all($sql, $arrData, DB_CAJA);
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

  public function selectsPermisosRol(int $roles_id)
  {
    $sql = 'SELECT * FROM detalle_rol_permiso
    WHERE roles_id = :roles_id';
    $request = $this->select_all($sql, array('roles_id' => $roles_id), DB_CAJA);
    return $request;
  }

  // Funciones select

  public function selectRol(string $roles_nombre)
  {
    $sql = 'SELECT * FROM roles
    WHERE roles_nombre = :roles_nombre';
    $request = $this->select($sql, array('roles_nombre' => $roles_nombre), DB_CAJA);
    return $request;
  }

  public function selectRolId(int $roles_id)
  {
    $sql = 'SELECT * FROM roles
    WHERE roles_id = :roles_id';
    $request = $this->select($sql, array('roles_id' => $roles_id), DB_CAJA);
    return $request;
  }

  public function selectPermiso(int $permiso_id)
  {
    $sql = 'SELECT * FROM permiso
    WHERE permiso_id = :permiso_id';
    $request = $this->select($sql, array('permiso_id' => $permiso_id), DB_CAJA);
    return $request;
  }

  public function selectPermisoName(string $permiso_nombre)
  {
    $sql = 'SELECT * FROM permiso
    WHERE permiso_nombre = :permiso_nombre';
    $request = $this->select($sql, array('permiso_nombre' => $permiso_nombre), DB_CAJA);
    return $request;
  }

  public function selectGrupoPermiso(string $grupo_permiso_id)
  {
    $sql = 'SELECT * FROM grupo_permiso
    WHERE grupo_permiso_id = :grupo_permiso_id';
    $request = $this->select($sql, array('grupo_permiso_id' => $grupo_permiso_id), DB_CAJA);
    return $request;
  }

  public function selectGrupoPermisoNombre(string $grupo_permiso_nombre)
  {
    $sql = 'SELECT * FROM grupo_permiso
    WHERE grupo_permiso_nombre = :grupo_permiso_nombre';
    $request = $this->select($sql, array('grupo_permiso_nombre' => $grupo_permiso_nombre), DB_CAJA);
    return $request;
  }

  // Funciones insert
  public function setRol(string $roles_nombre, string $roles_descripcion = null)
  {
    if (is_null($roles_descripcion)) {
      $roles_descripcion = 'Rol creado para los usuarios que serán eliminados en algún momento';
    }

    $sql = 'INSERT INTO roles (roles_nombre, roles_descripcion) VALUES (:roles_nombre, :roles_descripcion)';
    $request = $this->insert($sql, array('roles_nombre' => $roles_nombre, 'roles_descripcion' => $roles_descripcion), DB_CAJA);
    return $request;
  }

  public function insertDetRolPermiso(int $permiso_id, int $roles_id)
  {
    $sql = 'INSERT INTO detalle_rol_permiso (permiso_id, roles_id) VALUES (:permiso_id, :roles_id)';
    $request = $this->insert($sql, array('permiso_id' => $permiso_id, 'roles_id' => $roles_id), DB_CAJA);
    return $request;
  }

  public function insertPermiso(string $permiso_nombre, int $grupo_permiso_id, int $permiso_orden = 0)
  {
    $orden = intval($permiso_orden);
    if ($permiso_orden === 0) {
      $sql = 'SELECT * FROM permiso
      ORDER BY permiso_orden DESC';
      $request = $this->select($sql, array(), DB_CAJA);

      $orden = (intval($request['permiso_orden']) + 1);
    }

    $sql = 'INSERT INTO permiso (permiso_nombre, grupo_permiso_id, permiso_orden) VALUES (:permiso_nombre, :grupo_permiso_id, :permiso_orden)';
    $request = $this->insert($sql, array('permiso_nombre' => $permiso_nombre, 'grupo_permiso_id' => $grupo_permiso_id, 'permiso_orden' => $orden), DB_CAJA);
    return $request;
  }

  public function insertGrupoPermiso(string $grupo_permiso_nombre)
  {
    $sql = 'INSERT INTO grupo_permiso (grupo_permiso_nombre) VALUES (:grupo_permiso_nombre)';
    $request = $this->insert($sql, array('grupo_permiso_nombre' => $grupo_permiso_nombre), DB_CAJA);
    return $request;
  }

  // Funciones update

  public function habilitarPermiso(int $permiso_id, int $permiso_estado = 1)
  {
    $sql = 'UPDATE permiso SET permiso_estado = :permiso_estado WHERE  permiso_id = :permiso_id';
    $request = $this->update($sql, array('permiso_estado' => $permiso_estado, 'permiso_id' => $permiso_id), DB_CAJA);
    return $request;
  }

  public function desabilitarPermiso(int $permiso_id, int $permiso_estado = 2)
  {
    $sql = 'UPDATE permiso SET permiso_estado = :permiso_estado WHERE  permiso_id = :permiso_id';
    $request = $this->update($sql, array('permiso_estado' => $permiso_estado, 'permiso_id' => $permiso_id), DB_CAJA);
    return $request;
  }

  public function updatePermiso(int $permiso_id, string $permiso_nombre)
  {
    $sql = 'UPDATE permiso SET permiso_nombre = :permiso_nombre WHERE  permiso_id = :permiso_id';
    $request = $this->update($sql, array('permiso_id' => $permiso_id, 'permiso_nombre' => $permiso_nombre), DB_CAJA);
    return $request;
  }

  public function updateGrupoPermiso(int $grupo_permiso_id, int $permiso_id)
  {
    $sql = 'UPDATE permiso SET grupo_permiso_id = :grupo_permiso_id WHERE permiso_id = :permiso_id';
    $request = $this->update($sql, array('grupo_permiso_id' => $grupo_permiso_id, 'permiso_id' => $permiso_id), DB_CAJA);
    return $request;
  }

  public function updateGrupoPermisoName(int $grupo_permiso_id, string $grupo_permiso_nombre)
  {
    $sql = 'UPDATE grupo_permiso SET grupo_permiso_nombre = :grupo_permiso_nombre WHERE grupo_permiso_id = :grupo_permiso_id';
    $request = $this->update($sql, array(
      'grupo_permiso_nombre' => $grupo_permiso_nombre, 'grupo_permiso_id' => $grupo_permiso_id
    ), DB_CAJA);
    return $request;
  }

  public function updateGrupoPermisoEstado(int $grupo_permiso_id, int $grupo_permiso_estado)
  {
    $sql = 'UPDATE grupo_permiso SET grupo_permiso_estado = :grupo_permiso_estado WHERE grupo_permiso_id = :grupo_permiso_id';
    $request = $this->update($sql, array('grupo_permiso_estado' => $grupo_permiso_estado, 'grupo_permiso_id' => $grupo_permiso_id), DB_CAJA);
    return $request;
  }

  public function updateRolName(int $roles_id, string $roles_nombre)
  {
    $sql = 'UPDATE roles SET roles_nombre = :roles_nombre WHERE roles_id = :roles_id';
    $request = $this->update($sql, array('roles_nombre' => $roles_nombre, 'roles_id' => $roles_id), DB_CAJA);
    return $request;
  }

  // Funciones delete
  public function deletePermiso(int $permiso_id)
  {
    $sql = 'DELETE FROM permiso WHERE permiso_id = :permiso_id';
    $request = $this->delete($sql, array('permiso_id' => $permiso_id), DB_CAJA);
    return $request;
  }

  public function deletePermisoRolById(int $roles_id)
  {
    $sql = 'DELETE FROM detalle_rol_permiso WHERE roles_id = :roles_id';
    $request = $this->delete($sql, array('roles_id' => $roles_id), DB_CAJA);
    return $request;
  }

  public function deleteRol(int $roles_id)
  {
    $sql = 'DELETE FROM roles WHERE roles_id = :roles_id';
    $request = $this->delete($sql, array('roles_id' => $roles_id), DB_CAJA);
    return $request;
  }

  public function deleteRolesUsuarioById(int $roles_id)
  {
    $sql = 'DELETE FROM detalle_rol_usuario WHERE roles_id = :roles_id';
    $request = $this->delete($sql, array('roles_id' => $roles_id), DB_CAJA);
    return $request;
  }

  public function deleteGrupoPermiso(int $grupo_permiso_id)
  {
    $sql = 'DELETE FROM grupo_permiso WHERE grupo_permiso_id = :grupo_permiso_id';
    $request = $this->delete($sql, array('grupo_permiso_id' => $grupo_permiso_id), DB_CAJA);
    return $request;
  }

  public function deletePermisosRol(int $roles_id, int $permiso_estado = 1)
  {
    $sql = 'DELETE detalle_rol_permiso FROM detalle_rol_permiso
    INNER JOIN permiso ON detalle_rol_permiso.permiso_id = permiso.permiso_id
    WHERE detalle_rol_permiso.roles_id = :roles_id AND permiso.permiso_estado = :permiso_estado';
    $request = $this->delete($sql, array('roles_id' => $roles_id, 'permiso_estado' => $permiso_estado), DB_CAJA);
    return $request;
  }
}
