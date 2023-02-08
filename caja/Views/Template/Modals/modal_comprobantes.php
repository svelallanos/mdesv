<!-- Modal edit comprobantes-->
<div class="modal fade" id="modal_editarComprobantes" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h1 class="modal-title fw-bold fs-5" id="staticBackdropLabel">EDITAR COMPROBANTES</h1>
                <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form_editarComprobantes" data-id="" autocomplete="off">
                    <div class="form-group mb-2 col-md-6">
                        <label class="fw-bold">Serie :</label>
                        <input required type="text" class="form-control" id="__edit_serie" name="__edit_serie" aria-describedby="emailHelp" placeholder="000" maxlength="3" minlength="1">
                        <small class="form-text text-muted">Serie de registro.</small>
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

<!-- Modal add comprobantes-->
<div class="modal fade" id="modal_agregarComprobantes" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #00FF7F;">
                <h1 class="modal-title fw-bold fs-5" id="staticBackdropLabel">AGREGAR COMPROBANTES</h1>
                <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form_agregarComprobantes" autocomplete="off">
                    <div class="form-group mb-2 col-md-6">
                        <label class="fw-bold">Serie :</label>
                        <input required type="text" class="form-control" id="__add_serie" name="__add_serie" aria-describedby="emailHelp" placeholder="000" maxlength="3" minlength="1">
                        <small class="form-text text-muted">Serie de registro.</small>
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