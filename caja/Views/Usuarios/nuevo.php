<?php headerAdmin($data) ?>
<main id="main" class="main">

  <div class="pagetitle">
    <h1><?= !empty($data['page_name']) ? $data['page_name'] : 'Sin Nombre' ?></h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">Configuraciones</li>
        <li class="breadcrumb-item"><a href="<?= base_url() ?>Usuarios">Usuarios</a></li>
        <li class="breadcrumb-item active">Nuevo</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  <section class="section">
    <div class="row">
      <div class="col-md-12">
        <!-- Account details card-->
        <div class="mensaje"></div>
        <div class="card mb-4">
          <div class="card-header fw-bold" style="background-color: #8ce8ff;">Datos de perfil</div>
          <div class="card-body">
            <form id="consultarDatosDni">
              <div class="row">
                <div class="col-md-6 col-xl-4">
                  <label class="fw-500">Buscar datos</label>
                  <div class="input-group mb-3">
                    <input required type="text" class="form-control" id="dni_api" name="dni_api" placeholder="Ingrese número de DNI" aria-label="Recipient's username" aria-describedby="button-addon2">
                    <button class="btn btn-info" type="submit" id="button-addon2"><i class="fa-solid fa-magnifying-glass"></i></button>
                  </div>
                </div>
              </div>
            </form>
            <form id="form_agregar_usuario">
              <!-- Form Row-->
              <div class="row gx-3 mb-3">
                <!-- Form Group (first name)-->
                <label class="fw-bold mb-2">DETALLE DE DATOS DEL USUARIO</label>
                <div class="mb-2">
                  <label class="small"><i class="feather-chevron-right"></i>&nbsp El nombre de usuario solo debe contener letras y números, sin espacios blancos y en minúscula.</label>
                </div>
                <div class="col-md-6 col-xl-4 mb-2">
                  <label class="small mb-1">Usuario Login</label>
                  <input required class="form-control" id="usuarios_login" type="text" name="usuarios_login" placeholder="Usuario de inicio de sesion">
                </div>
                <div class="col-md-6 col-xl-4 mb-2">
                  <label class="small mb-1">DNI</label>
                  <input required class="form-control" id="usuarios_dni" name="usuarios_dni" type="text" placeholder="Ingrese número de dni">
                </div>
                <div class="col-md-6 col-xl-4 mb-2">
                  <label class="small mb-1">Nombre</label>
                  <input required class="form-control" name="usuarios_nombres" id="usuarios_nombres" type="text" placeholder="Ingrese nombre de usuario">
                </div>
                <!-- Form Group (last name)-->
                <div class="col-md-6 col-xl-4 mb-2">
                  <label class="small mb-1">Apellido Paterno</label>
                  <input required class="form-control" name="usuarios_paterno" id="usuarios_paterno" type="text" placeholder="Ingrese apellido paterno">
                </div>
                <div class="col-md-6 col-xl-4">
                  <label class="small mb-1">Apellido Materno</label>
                  <input required class="form-control" name="usuarios_materno" id="usuarios_materno" type="text" placeholder="Ingrese el apellido materno">
                </div>
              </div>
              <div class="row gx-3 mb-3">
                <div class="col-md-6">
                  <label class="small mb-1">Correo Electrónico</label>
                  <input required class="form-control" id="usuarios_email" name="usuarios_email" type="email" placeholder="name@example.com">
                </div>
              </div>
              <div class="row gx-3 mb-3">
                <label class="fw-bold mb-2">CAMBIAR CONTRASEÑA</label>
                <div class="col-md-6 col-xl-4">
                  <label class="small mb-1">Contraseña</label>
                  <input class="form-control" name="password" id="password" type="text" placeholder="Ingrese la contraseña" value="">
                </div>
              </div>
              <!-- Instrucciones de la contraseña -->
              <div class="mb-3 row">
                <label class="small mb-1"><i class="feather-chevron-right"></i>&nbsp La contraseña solo debe contener letras en minúsculas y sin espacios blancos.</label>
                <label class="small mb-1"><i class="feather-chevron-right"></i>&nbsp La contraseña debe estar formada mínimo por una letra y un número, además debe tener mínimo 5 caracteres.</label>
                <label class="small mb-1"><i class="feather-chevron-right"></i>&nbsp La contraseña solo puede estar formada por letras mayúsculas, minúsculas, números y los siguientes símbolos ( * - + . # $ & % = _ ).</label>
              </div>
              <div class="mb-2">
                <label class="fw-700 mb-2">ASIGNAR ROLES</label>
                <div class="alert alert-warning alert-solid p-2 border border-blue border-2" role="alert">Asigna los roles con precaución a los usuarios correspondientes para evitar inconvenientes en el funcionamiento del sistema.</div>
              </div>
              <div class="mb-3">
                <?php foreach ($data['data-roles'] as $key => $value) { ?>
                  <div class="form-check">
                    <input name="roles_<?= $value['roles_id'] ?>" class="form-check-input roles_update" id="roles_<?= $value['roles_id'] ?>" type="checkbox" value="<?= $value['roles_id'] ?>">
                    <label class="form-check-label" for="roles_<?= $value['roles_id'] ?>"><?= $value['roles_nombre'] ?></label>
                  </div>
                <?php } ?>
              </div>
              <!-- Submit button-->
              <div class="row">
                <div class="col-12 text-start text-md-end">
                  <button class="btn btn-primary" type="submit"><i class="feather-save"></i> &nbsp Guardar Cambios</button>
                  <a href="<?= base_url() ?>Usuarios" class="btn btn-secondary text-center"><i class="feather-x-circle"></i> &nbsp Cancelar</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

</main><!-- End #main -->
<?php footerAdmin($data) ?>