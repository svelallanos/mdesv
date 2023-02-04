<!-- Modal -->
<div class="modal fade" id="modal_detalle_bloqueo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h1 class="modal-title text-white fs-5" id="exampleModalLabel">MOTIVO DE BLOQUEO</h1>
        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="mensaje_bloqueo"></div>
          <div class="col-md-12">
            <div class="mb-3">
              <label class="fw-bold" for="exampleFormControlInput1">Nombre :</label>
              <input class="form-control" disabled id="bloqueo_nombre" type="text">
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="fw-bold" for="exampleFormControlInput1">Dni :</label>
              <input class="form-control" disabled id="bloqueo_dni" type="text">
            </div>
          </div>
          <div class="col-md-12">
            <div class="accordion" id="accordionExample">
              <div class="accordion-item">
                <h2 class="accordion-header" id="lista_motivos_delete">
                  <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Lista de Motivos
                  </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="lista_motivos_delete" data-bs-parent="#accordionExample" style="">
                  <div class="accordion-body">
                    <div class="table-responsive">
                      <table class="table m-0 table-hover table-bordered table-striped w-100">
                        <thead>
                          <tr>
                            <th class="text-center">N°</th>
                            <th>MOTIVO</th>
                            <th>ACCIONES</th>
                          </tr>
                        </thead>
                        <tbody id="tb_bloqueo_motivos">
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal_list_usuarios" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #0cd10c;">
        <h1 class="fw-bold modal-title fs-5 text-white">LISTA DE USUARIOS</h1>
        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table id="tb_usuarios" class="table table-hover table-bordered table-striped w-100">
            <thead>
              <tr>
                <th>N°</th>
                <th>NOMBRES</th>
                <th>APELLIDOS</th>
                <th>DNI</th>
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
</div>

<!-- Modal -->
<div class="modal fade" id="modal_bloqueos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #e50b33;">
        <h1 class="fw-700 modal-title fs-5 text-white">MOTIVO BLOQUEO</h1>
        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="form_bloqueo" data-usuarios_id="">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="mb-3">
                <label class="fw-bold">Usuario:</label>
                <input disabled class="form-control" id="text_nombre_usuario" type="text">
              </div>
            </div>
            <div class="col-md-12">
              <div class="mb-0">
                <label class="fw-bold">Motivo de Bloqueo:</label>
                <select required class="form-control" name="tipo_bloqueo_id" id="tipo_bloqueo_id">
                  <?php foreach ($data['data-tipo-bloqueo'] as $key => $value) { ?>
                    <option value="<?= $value['tipo_bloqueo_id'] ?>"><?= $value['tipo_bloqueo_descripcion'] ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer p-2">
          <button type="submit" class="btn btn-primary"><i class="feather-plus-circle"></i> &nbsp Agregar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark"></i> &nbsp Cerrar</button>
        </div>
      </form>
    </div>
  </div>
</div>