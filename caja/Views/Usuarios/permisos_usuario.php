<?php headerAdmin($data) ?>
<main id="main" class="main">
  <div class="pagetitle">
    <div class="menu-second d-flex justify-content-between">
      <h1><?= !empty($data['page_name']) ? $data['page_name'] : 'Sin Nombre' ?></h1>
    </div>
    <nav class="d-flex justify-content-between align-items-center">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">Configuraciones</li>
        <li class="breadcrumb-item active"><a href="<?= base_url() ?>Usuarios/permisos_personalizados">Permisos Personalizados</a></li>
        <li class="breadcrumb-item active">Permisos Usuario</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  <section class="section">
    <div class="row">
      <div class="col-md-12">
        <form id="form_permiso_personalizados" data-usuarios_id="<?= $data['usuario']['usuarios_id'] ?>">
          <div class="card">
            <!-- lift : Sirve para dar movimiento a las cards y demas estilos -->
            <div class="card-body">
              <div class="mensaje"></div>
              <div class="col-12">
                <div class="row">
                  <label class="mb-2">Nombre :</label>
                  <div class="col-8 col-sm-7 col-md-6 col-xl-4 col-xxl-3 __nombre_rol">
                    <div class="input-group input-group-joined">
                      <span class="input-group-text">
                        <i class="fa-solid fa-user-gear"></i>
                      </span>
                      <input disabled value="<?= $data['usuario']['usuarios_nombres'] . ', ' . $data['usuario']['usuarios_paterno'] . ' ' . $data['usuario']['usuarios_materno'] ?>" autocomplete="off" required class="form-control pe-0" type="text" placeholder="Nombre del usuario">
                    </div>
                  </div>
                  <div class="col-12 col-md-6 col-xl-8 col-xxl-9 mt-2 mt-md-0 text-md-end">
                    <button type="submit" class="btn btn-primary mr-2"><i class="fa-brands fa-pushed"></i> &nbsp Guardar cambios</button>
                    <a href="<?= base_url() ?>Usuarios/permisos_personalizados" class="btn btn-secondary"><i class="feather-x-circle"></i> &nbsp Cancelar</a>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-12">
                <label class="mt-3 mb-2">Permisos :</label>
                <?php
                if ($data['lista_permisos_rol'] === []) { ?>
                  No hay ningún permiso
                  <?php } else {
                  $auxGrupo = 'ASDBUDWD';
                  foreach ($data['lista_permisos_rol'] as $key => $value) {
                    if ($auxGrupo !== $value['grupo_permiso_id']) {
                      $auxGrupo = $value['grupo_permiso_id'];
                  ?>
                      <div class="row mb-2">
                        <div class="col-md-12">
                          <div class="alert fw-bold alert-info alert-solid py-2" role="alert"><?= $value['grupo_permiso_nombre'] ?></div>
                        </div>
                        <div class="row px-5">
                        <?php } ?>
                        <div class="col-12 col-sm-6 col-md-4">
                          <div class="form-check">
                            <input <?= (!empty($data['permisos_habilitados']) ? ((isset($data['permisos_habilitados'][$value['permiso_id']])) ? 'checked' : '') : '') ?> <?= ($value['permiso_estado'] === '2') ? 'disabled' : '' ?> class="form-check-input" name="permiso_<?= $value['permiso_id'] ?>" value="<?= $value['permiso_id'] ?>" id="permiso_<?= $value['permiso_id'] ?>" type="checkbox" value="">
                            <label class="form-check-label <?= ($value['permiso_estado'] === '2') ? 'text-decoration-line-through text-danger' : '' ?>" for="permiso_<?= $value['permiso_id'] ?>"><?= $value['permiso_nombre'] ?></label>
                          </div>
                        </div>
                        <?php
                        if (isset($data['lista_permisos_rol'][($key + 1)]['grupo_permiso_id']) && $auxGrupo !== $data['lista_permisos_rol'][($key + 1)]['grupo_permiso_id']) { ?>
                        </div>
                      </div>

                <?php }
                      }
                    } ?>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>

</main><!-- End #main -->
<?php
footerAdmin($data);
?>