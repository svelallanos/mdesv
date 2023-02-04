<?php headerAdmin($data) ?>
<main id="main" class="main">

  <div class="pagetitle">
    <div class="menu-second d-flex justify-content-between">
      <h1><?= !empty($data['page_name']) ? $data['page_name'] : 'Sin Nombre' ?></h1>
      <a href="<?= base_url() ?>Usuarios" class="btn btn-sm btn-purple"><i class="fa-solid fa-reply"></i> Retornar</a>
    </div>
    <nav class="d-flex justify-content-between align-items-center">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">Configuraciones</li>
        <li class="breadcrumb-item"><a href="<?= base_url() ?>Usuarios">Usuarios</a></li>
        <li class="breadcrumb-item active">Editar</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  <section class="section">
    <div class="row">
      <div class="col-lg-4">
        <div class="mensaje_file">
        </div>
        <!-- Profile picture card-->
        <div class="card mb-4 mb-xl-0">
          <div class="card-header fw-bold bg-primary-10" style="color: #012970;">Imagen de Perfil</div>
          <div class="card-body text-center">
            <!-- Profile picture image-->
            <img data-path="<?= media() ?>/images/fotoperfil/" class="__img_editarperfil img-account-profile rounded-circle mb-2" src="<?= media() ?>/images/fotoperfil/<?= (empty($data['data-usuario']['usuarios_foto'] || is_null($data['data-usuario']['usuarios_foto'])) ? 'sin_foto.png' : $data['data-usuario']['usuarios_foto']) ?>" alt="">
            <!-- Profile picture help block-->
            <div class="small font-italic text-muted mb-2">JPG o PNG de un tamaño máximo de 3 MB</div>
            <!-- Profile picture upload button-->
            <form id="upload_perfil">
              <div class="mb-3 d-none">
                <input id="file_imagen_perfil" accept="image/jpeg, image/png" name="file_imagen_perfil" class="form-control" type="file">
              </div>
              <div class="container_loader hide">
                <div class="cargando">
                  <div class="pelotas"></div>
                  <div class="pelotas"></div>
                  <div class="pelotas"></div>
                </div>
              </div>
              <button class="btn btn-danger cargar_imagen" title="subir foto de perfil" type="button"><i class="feather-upload"></i> &nbsp Cargar imagen</button>
            </form>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <!-- Account details card-->
        <div class="mensaje"></div>
        <div class="card mb-4">
          <div class="card-header bg-primary-10 fw-bold" style="color: #012970;">Actualizar datos de perfil</div>
          <div class="card-body">
            <form id="form_update_usuario" data-usuario_id="<?= $data['data-usuario']['usuarios_id'] ?>">
              <!-- Form Row-->
              <div class="row gx-3 mb-3">
                <!-- Form Group (first name)-->
                <div class="col-md-6 mb-2">
                  <label class="small mb-1">Usuario Login</label>
                  <input required class="form-control" value="<?= $data['data-usuario']['usuarios_login'] ?>" id="usuarios_login" type="text" name="usuarios_login" placeholder="Usuario de inicio de sesion">
                </div>
                <div class="col-md-6 mb-2">
                  <label class="small mb-1">DNI</label>
                  <input required class="form-control" value="<?= $data['data-usuario']['usuarios_dni'] ?>" id="usuarios_dni" name="usuarios_dni" type="text" placeholder="Ingrese número de dni del usuario">
                </div>
                <div class="col-md-6 mb-2">
                  <label class="small mb-1">Nombre</label>
                  <input required class="form-control" value="<?= $data['data-usuario']['usuarios_nombres'] ?>" name="usuarios_nombres" id="usuarios_nombres" type="text" placeholder="Ingrese nombre de usuario">
                </div>
                <!-- Form Group (last name)-->
                <div class="col-md-6 mb-2">
                  <label class="small mb-1">Apellido Paterno</label>
                  <input required class="form-control" value="<?= $data['data-usuario']['usuarios_paterno'] ?>" name="usuarios_paterno" id="usuarios_paterno" type="text" placeholder="Ingrese apellido paterno del usuario">
                </div>
                <div class="col-md-6">
                  <label class="small mb-1">Apellido Materno</label>
                  <input required class="form-control" value="<?= $data['data-usuario']['usuarios_materno'] ?>" name="usuarios_materno" id="usuarios_materno" type="text" placeholder="Ingrese el apellido materno del usuario">
                </div>
              </div>
              <div class="mb-3">
                <label class="small mb-1">Correo Electrónico</label>
                <input required class="form-control" value="<?= $data['data-usuario']['usuarios_email'] ?>" id="usuarios_email" name="usuarios_email" type="email" placeholder="name@example.com">
              </div>
              <div class="row gx-3 mb-3">
                <label class="fw-700 mb-2">CAMBIAR CONTRASEÑA</label>
                <div class="col-md-6">
                  <label class="small mb-1">Nueva Contraseña</label>
                  <input class="form-control" name="password_new" id="password_new" type="password" placeholder="************" value="">
                </div>
                <div class="col-md-6">
                  <label class="small mb-1">Repita la Contraseña</label>
                  <input class="form-control" name="password_val" id="password_val" type="password" placeholder="************" value="">
                </div>
              </div>
              <!-- Instrucciones de la contraseña -->
              <div class="row mb-3">
                <label class="small mb-1"><i class="feather-chevron-right"></i>&nbsp Si no va a cambiar la contraseña, dejar el campo vacío.</label>
                <label class="small mb-1"><i class="feather-chevron-right"></i>&nbsp La contraseña debe estar formada mínimo por una letra y un número, además debe tener mínimo 5 caracteres.</label>
                <label class="small mb-1"><i class="feather-chevron-right"></i>&nbsp La contraseña solo puede estar formada por letras mayúsculas, minúsculas, números y los siguientes símbolos ( * - + . # $ & % = _ ).</label>
              </div>
              <div class="mb-2">
                <label class="mb-2">
                  <span class="fw-700">ROLES</span>
                  <input class="form-check-input cursor-pointer" id="check_editar_rol" type="checkbox">
                  <label>¿Actualizar roles?</label>
                </label>
                <div class="alert alert-warning alert-solid p-2 border border-blue border-2" role="alert">Asigna los roles con precaución a los usuarios correspondientes para evitar inconvenientes en el funcionamiento del sistema.</div>
              </div>
              <div class="mb-3">
                <?php foreach ($data['data-roles'] as $key => $value) { ?>
                  <div class="form-check">
                    <input name="roles_<?= $value['roles_id'] ?>" <?= (isset($data['data-roles-usuario'][$value['roles_id']]) ? 'checked' : '') ?> class="form-check-input roles_update" disabled id="roles_<?= $value['roles_id'] ?>" type="checkbox" value="<?= $value['roles_id'] ?>">
                    <label class="form-check-label" for="roles_<?= $value['roles_id'] ?>"><?= $value['roles_nombre'] ?></label>
                  </div>
                <?php } ?>
              </div>
              <!-- Submit button-->
              <div class="row">
                <div class="col-12 text-start text-md-end">
                  <button class="btn btn-primary" type="submit"><i class="feather-save"></i> &nbsp Guardar Cambios</button>
                  <a href="<?= base_url() ?>/Usuarios" class="btn btn-secondary text-center"><i class="feather-x-circle"></i> &nbsp Cancelar</a>
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