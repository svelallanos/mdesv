<!DOCTYPE html>

<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title><?= (isset($data['page_title']) ? $data['page_title'] : 'Sin nombre de página') ?></title>

  <link rel="icon" type="image/x-icon" href="<?= media() ?>/images/Insignia-MDESV.png" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

  <link rel="stylesheet" href="<?= media() ?>/css/general/login/boxicons.css" />

  <link rel="stylesheet" href="<?= media() ?>/css/general/login/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="<?= media() ?>/css/general/login/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="<?= media() ?>/css/general/login/demo.css" />
  <link rel="stylesheet" href="<?= media() ?>/css/general/login/perfect-scrollbar.css" />
  <link rel="stylesheet" href="<?= media() ?>/css/general/login/page-auth.css" />
  <link href="<?= media() ?>/css/general/style_customized.css?version=<?= getVerion() ?>" rel="stylesheet" />
  <script src="<?= media() ?>/js/general/login/helpers.js"></script>
  <script src="<?= media() ?>/js/general/login/config.js"></script>
</head>

<body>
  <!-- Content -->

  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
        <!-- Register -->
        <div class="card">
          <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center">
              <a href="login" class="app-brand-link gap-2">
                <span class="app-brand-logo demo">
                  <img style="width: 4rem;" src="<?= media() ?>/images/Logo-MDESV.png" alt="">
                </span>
                <span class="demo text-body fw-bolder fs-3">INICIO DE SESIÓN</span>
              </a>
            </div>
            <!-- /Logo -->
            <h4 class="mb-2">Bienvenidos a Caja 👋</h4>
            <p class="mb-4">Inicia sesión en tu cuenta</p>
            <form id="form_login" class="mb-3">
              <div class="mb-3">
                <label for="text" class="form-label fw-bold">USUARIO</label>
                <input type="text" class="form-control" name="nombre_usuario" id="nombre_usuario" required placeholder="Ingrese nombre de usuario" autofocus />
              </div>
              <div class="mb-3 form-password-toggle">
                <div class="d-flex justify-content-between">
                  <label class="form-label fw-bold" for="password">CONTRASEÑA</label>
                </div>
                <div class="input-group input-group-merge">
                  <input type="password" class="form-control" name="pass_usuario" id="pass_usuario" required placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
              </div>
              <div class="mb-3">
                <button class="btn btn-success d-grid w-100" type="submit">Acceder</button>
              </div>
            </form>

            <p class="text-center">
              <span class="fw-bold">Nota: </span>
              <span class="text-secondary">Sino tiene cuenta comunicate con el administrador.</span>
            </p>
          </div>
        </div>
        <!-- /Register -->
      </div>
    </div>
  </div>

  <?php printHTMLRequired() ?>

  <script type="text/javascript">
    var base_url = '<?= base_url() ?>';
  </script>

  <!-- Core JS -->
  <!-- build:js assets/vendor/js/core.js -->
  <script src="<?= media() ?>/js/general/login/jquery.js"></script>
  <script src="<?= media() ?>/js/general/login/popper.js"></script>
  <script src="<?= media() ?>/js/general/login/bootstrap.js"></script>
  <script src="<?= media() ?>/js/general/login/perfect-scrollbar.js"></script>
  <script src="<?= media() ?>/js/general/login/menu.js"></script>
  <script src="<?= media() ?>/js/general/login/main.js"></script>
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <script src="<?= media() ?>/js/general/axios.min.js?version=<?= getVerion() ?>"></script>

  <script src="<?= media() ?>/js/general/filerequired.js?version=<?= getVerion() ?>"></script>

  <?php if (isset($data['page_function_js']) && !empty($data['page_function_js'])) { ?>
    <script src="<?= media() ?>/js/<?= $data['page_function_js'] ?>.js?version=<?= getVerion() ?>"></script>
  <?php } ?>

  <!-- Modal de alertas de sesion -->
  <?php getModal('modal_login', $data) ?>
  <!-- Fin de alertas -->

</body>

</html>