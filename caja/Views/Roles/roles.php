<?php headerAdmin($data) ?>
<main id="main" class="main">
  <div class="pagetitle">
    <div class="menu-second d-flex justify-content-between">
      <h1><?= !empty($data['page_name']) ? $data['page_name'] : 'Sin Nombre' ?></h1>
      <a href="<?= base_url() ?>Roles/Nuevo" class="btn btn-sm btn-primary"><i class="fa-solid fa-plus"></i> Agregar</a>
    </div>
    <nav class="d-flex justify-content-between align-items-center">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">Configuraciones</li>
        <li class="breadcrumb-item active">Roles</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  <section class="section">
    <div class="row">
      <div class="col-xs-12 col-lg-12 col-xl-8">
        <div class="card">
          <div class="card-body p-2 p-md-4">
            <table id="tb_roles" class="table table-hover table-bordered table-striped w-100">
              <thead>
                <tr>
                  <th class="text-center">N°</th>
                  <th>NOMBRE</th>
                  <th class="text-center">ESTADO</th>
                  <th class="text-center">ACCIONES</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($data['lista_roles'] !== []) {
                  foreach ($data['lista_roles'] as $key => $value) { ?>
                    <tr>
                      <td class="text-center"><?= ($key + 1) ?></td>
                      <td><?= $value['roles_nombre'] ?></td>
                      <td class="text-center">
                        <?= ($value['roles_estado'] == '1') ? '<span class="badge border rounded-pill bg-success">Activo</span>' : '<span class="badge border rounded-pill bg-danger">Inactivo</span>' ?>
                      </td>
                      <td class="text-center"><a href="<?= base_url() ?>Roles/editar?roles_id=<?= $value['roles_id'] ?>" class="btn btn-info btn-sm btn-icon"><i class="fa-solid fa-pencil"></i></a>
                        <?php
                        if ($value['roles_id'] != '1' && $value['roles_id'] != '2' && $value['roles_id'] != '3' && $value['roles_id'] != '4') { ?>
                          <a data-roles_id="<?= $value['roles_id'] ?>" class="btn btn-danger eliminar_rol btn-sm btn-icon"><i class="fa-solid fa-trash-can"></i></a>
                        <?php
                        }
                        ?>
                      </td>
                    </tr>
                <?php
                  }
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="d-none d-xl-block col-lg-3 p-3 border border-3 border-info rounded bg-white m-auto mt-0">
        <div class="row">
          <div class="col-md-12">
            <img class="shadow roles_img" src="<?= media() ?>/images/roles_1.png" alt="">
          </div>
          <div class="col-md-12">
            <h3 class="text-center p-3 pb-2 m-0 text-primary"><strong>Roles</strong></h3>
            <p class="text-center m-0">Recuerda que el nombre de los roles no deben ser iguales, ni similares, para evitar confundirlos.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

</main><!-- End #main -->
<?php footerAdmin($data) ?>