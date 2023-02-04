<?php

function printHTMLRequired()
{
    echo '<div class="modal" id="semi_modal_loading" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="semi_modal_loadingLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-fullscreen-sm-down">
                <div class="modal-content">
                    <div class="modal-body text-center">
        
                        <div class="_modal_loader">
                            <div class="_modal_loader--dot"></div>
                            <div class="_modal_loader--dot"></div>
                            <div class="_modal_loader--dot"></div>
                            <div class="_modal_loader--dot"></div>
                            <div class="_modal_loader--dot"></div>
                            <div class="_modal_loader--dot"></div>
                            <div class="_modal_loader--text">Cargando</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="bg_semi_modal_loading" class="d-none"></div>
        
        <div id="container_alert_modal"></div>
        
        <div class="fixed_all d-none" id="bg_modal_soon_logout"></div>
        
        <div class="modal fade mt-5" id="modal_soon_logout" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_soon_logoutLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header header_modal_ui">
                        <h5 class="modal-title text-center w-100" id="modal_soon_logoutLabel">LA SESIÓN TERMINARÁ PRONTO</h5>
                    </div>
                    <div class="modal-body text-center">
                        La sesión se terminará pronto, por lo que tendrá que iniciar sesión nuevamente para ingresar al intranet. Recargue la página ahora para seguir navegando sin problemas.
                    </div>
                    <div class="modal-footer d-block title_modal_btt">
                        <div class="row mx-0 px-0">
                            <div class="col-4 px-0 mx-0">
                                <a type="button" class="pl-3 pr-1 mt-2" data-bs-dismiss="modal">Cerrar</a>
                            </div>
                            <div class="col-8 px-0 mx-0 text-right">
                                <button type="button" class="btn btn-primary">¡Recargar Ahora!</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="fixed_all d-none" id="bg_modal_session_expired"></div>
        
        <div class="modal fade mt-5" id="modal_session_expired" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_session_expiredLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header header_modal_ui">
                        <h5 class="modal-title text-center w-100" id="modal_session_expiredLabel">SESIÓN TERMINADA</h5>
                    </div>
                    <div class="modal-body text-center">
                        La sesión se ha finalizado, para continuar navegando tiene que volver a iniciar sesión.
                    </div>
                    <div class="modal-footer d-block title_modal_btt">
                        <div class="row mx-0 px-0">
                            <div class="col-12 px-0 mx-0 text-right">
                                <button type="button" class="btn btn-primary">Iniciar Sesión</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
}

function printReloadPage()
{
    echo '<div id="close_page" class="actualizar_page hide">
    <div class="accordion" id="accordionExample">
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingOne">
        <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            ACTUALIZAR PÁGINA
        </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
        <div class="accordion-body p-1">
        <div class="card-body p-2 small">
        Para visualizar los cambios actualiza la página <span class="fw-bold text-blue">Click en el botón</span>. <button onclick="location.reload()" title="Actualizar página" class="btn btn-sm btn-icon btn-primary"><i class="feather-loader"></i></button>
      </div>
      <div class="text-center">
        <button title="cerrar" class="btn_close_page btn btn-sm m-2 mt-0 btn-icon btn-danger"><i class="feather-x-circle"></i></button>
      </div>
        </div>
        </div>
    </div>
</div>
  </div>';
}
