<?php headerAdmin($data) ?>
<main id="main" class="main">

  <div class="pagetitle">
    <h1><?= !empty($data['page_name']) ? $data['page_name'] : 'Sin Nombre' ?></h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">Modulo Caja</li>
        <li class="breadcrumb-item active">Categorias</li>
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
            <table id="lista_categorias" class="table table-hover table-striped table-bordered w-100">
              <thead>
                <tr>
                  <th style="width: 10px;">N°</th>
                  <th style="width: 80px;">CODIGO</th>
                  <th>DESCRIPCION</th>
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

<!-- Modal -->
<div class="modal fade" id="modal_editarCategorias" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h1 class="modal-title fw-bold fs-5" id="staticBackdropLabel">EDITAR CATEGORIAS</h1>
        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="form_editarCategorias" data-id="" autocomplete="off">
          <div class="form-group mb-2 col-md-6">
            <label class="fw-bold">Código :</label>
            <input required type="text" class="form-control" id="__edit_codigo" name="__edit_codigo" aria-describedby="emailHelp" placeholder="Código de registro">
            <small class="form-text text-muted">Código de registro.</small>
          </div>
          <div class="form-group mb-3">
            <label class="fw-bold">Descripción :</label>
            <input required type="text" class="form-control" id="__edit_descripcion" name="__edit_descripcion" placeholder="Ingrese la descripción">
            <small class="form-text text-muted">Descripción del registro.</small>
          </div>
          <div class="form-group mb-3">
            <label class="fw-bold">Estado :</label>
            <select required class="form-control" id="__edit_estado" name="__edit_estado">
              <option value="1">Activo</option>
              <option value="0">Inactivo</option>
            </select>
          </div>
          <div class="text-end">
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-repeat"></i> Actualizar</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal_agregarCategorias" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #00FF7F;">
        <h1 class="modal-title fw-bold fs-5" id="staticBackdropLabel">AGREGAR CATEGORIAS</h1>
        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="form_agregarCategorias" autocomplete="off">
          <div class="form-group mb-2 col-md-6">
            <label class="fw-bold">Código :</label>
            <input required type="text" class="form-control" id="__add_codigo" name="__add_codigo" aria-describedby="emailHelp" placeholder="Código de registro">
            <small class="form-text text-muted">Código de registro.</small>
          </div>
          <div class="form-group mb-1">
            <label class="fw-bold">Descripción :</label>
            <input required type="text" class="form-control" id="__add_descripcion" name="__add_descripcion" placeholder="Ingrese la descripción">
            <small class="form-text text-muted">Descripción del registro.</small>
          </div>
          <hr>
          <div class="text-end">
            <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Guardar</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php footerAdmin($data) ?>