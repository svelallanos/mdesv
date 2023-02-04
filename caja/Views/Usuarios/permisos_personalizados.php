<?php headerAdmin($data) ?>
<main id="main" class="main">
  <div class="pagetitle">
    <div class="menu-second d-flex justify-content-between">
      <h1><?= !empty($data['page_name']) ? $data['page_name'] : 'Sin Nombre' ?></h1>
      <div>
        <button class="btn btn-sm btn-primary open_modal_usuarios"><i class="fa-solid fa-square-plus"></i> &nbsp Agregar</button>
        <button class="btn btn-sm btn-danger"><i class="fa-solid fa-file-contract"></i> &nbsp Reporte</button>
      </div>
    </div>
    <nav class="d-flex justify-content-between align-items-center">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">Configuraciones</li>
        <li class="breadcrumb-item active">Permisos Personalizados</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  <section class="section">
    <div class="row">
      <div class="mensaje_eliminarpermisos"></div>
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body">
            <table id="tb_permisosPersonalizados" class="table table-hover table-bordered table-striped w-100">
              <thead>
                <tr>
                  <th>N°</th>
                  <th>NOMBRES Y APELLIDOS</th>
                  <th>DNI</th>
                  <th>CANTIDAD</th>
                  <th class="text-center">FECHA PERMISO</th>
                  <th>ACCIONES</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>

</main><!-- End #main -->
<?php
footerAdmin($data);
getModal('modal_detalle_permisos', $data);
?>