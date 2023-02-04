<?php headerAdmin($data) ?>
<main id="main" class="main">

  <div class="pagetitle">
    <h1><?= !empty($data['page_name']) ? $data['page_name'] : 'Sin Nombre' ?></h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">Configuraciones</li>
        <li class="breadcrumb-item active">Usuarios</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  <section class="section">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="col-md-12 border border-2 border-secondary rounded p-2 mb-4">
              <a href="<?= base_url() ?>Usuarios/nuevo" class="btn btn-sm btn-primary"><i class="fa-solid fa-square-plus"></i> &nbsp Agregar</a>
              <button class="btn btn-sm btn-danger"><i class="fa-solid fa-file-contract"></i> &nbsp Reporte</button>
            </div>
            <table id="lista_usuarios" class="table table-hover table-striped table-bordered w-100">
              <thead>
                <tr>
                  <th>N°</th>
                  <th>NOMBRES</th>
                  <th>DNI</th>
                  <th>CREACIÓN</th>
                  <th>ROLES</th>
                  <th>ESTADO</th>
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
<?php footerAdmin($data) ?>