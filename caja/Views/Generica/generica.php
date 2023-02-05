<?php headerAdmin($data) ?>
<main id="main" class="main">

  <div class="pagetitle">
    <h1><?= !empty($data['page_name']) ? $data['page_name'] : 'Sin Nombre' ?></h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">Modulo Caja</li>
        <li class="breadcrumb-item active">Generica</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  <section class="section">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="col-md-12 border border-2 border-secondary rounded p-2 mb-4">
              <button class="btn btn-sm btn-success btn_agregarCategorias"><i class="feather-file-plus"></i> &nbsp Agregar</button>
              <button class="btn btn-sm btn-danger"><i class="fa-solid fa-file-contract"></i> &nbsp Reporte</button>
            </div>
            <table id="lista_generica" class="table table-hover table-striped table-bordered w-100">
              <thead>
                <tr>
                  <th style="width: 10px;">N°</th>
                  <th>NOM. GENERICA</th>
                  <th style="width: 130px;">COD. GENERICA</th>
                  <th>NOM. CATEGORIA</th>
                  <th style="width: 80px;">ESTADO</th>
                  <th style="width: 80px;">ACCIONES</th>
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
</main>

<?php footerAdmin($data) ?>