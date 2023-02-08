  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link" href="<?= base_url() ?>Inicio">
          <i class="feather-box" style="width: 20px;"></i>
          <span>Inicio</span>
        </a>
      </li>

      <?php if (verificarPermiso($data, 1) || verificarPermiso($data, 2) || verificarPermiso($data, 3) || verificarPermiso($data, 4)) { ?>
        <li class="nav-heading fw-bold">PANEL ADMINISTRADOR</li>
        <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
            <i class="fa-solid fa-gears" style="width: 20px;"></i><span>Configuraciones</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="components-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
            <?php if (verificarPermiso($data, 1)) { ?>
              <li>
                <a href="<?= base_url() ?>Usuarios">
                  <i class="bi bi-circle"></i><span>Usuarios</span>
                </a>
              </li>
            <?php } ?>
            <?php if (verificarPermiso($data, 2)) { ?>
              <li>
                <a href="<?= base_url() ?>Roles">
                  <i class="bi bi-circle"></i><span>Roles</span>
                </a>
              </li>
            <?php } ?>
            <?php if (verificarPermiso($data, 3)) { ?>
              <li>
                <a href="<?= base_url() ?>Usuarios/bloqueos">
                  <i class="bi bi-circle"></i><span>Bloqueos</span>
                </a>
              </li>
            <?php } ?>
            <?php if (verificarPermiso($data, 4)) { ?>
              <li>
                <a href="<?= base_url() ?>Usuarios/permisos_personalizados">
                  <i class="bi bi-circle"></i><span>Permisos Personalizados</span>
                </a>
              </li>
            <?php } ?>
          </ul>
        </li>
      <?php } ?>
      <li class="nav-heading fw-bold">MODULOS</li>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text" style="width: 20px;"></i><span>Modulo Caja</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?= base_url() ?>Categorias">
              <i class="bi bi-circle"></i><span>Categorias</span>
            </a>
          </li>
          <li>
            <a href="<?= base_url() ?>Categorias/generica">
              <i class="bi bi-circle"></i><span>Generica</span>
            </a>
          </li>
          <li>
            <a href="<?= base_url() ?>Categorias/subgenerica">
              <i class="bi bi-circle"></i><span>Sub Generica</span>
            </a>
          </li>
          <li>
            <a href="<?= base_url() ?>Categorias/especifica">
              <i class="bi bi-circle"></i><span>Especifica</span>
            </a>
          </li>
          <?php if (verificarPermiso($data, 6)) { ?>
            <li>
              <a href="<?= base_url() ?>Comprobantes">
                <i class="bi bi-circle"></i><span>Comprobantes</span>
              </a>
            </li>
          <?php } ?>
        </ul>
      </li><!-- End Forms Nav -->

      <?php if (verificarPermiso($data, 99)) { ?>
        <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-layout-text-window-reverse"></i><span>Tables</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li>
              <a href="tables-general.html">
                <i class="bi bi-circle"></i><span>General Tables</span>
              </a>
            </li>
            <li>
              <a href="tables-data.html">
                <i class="bi bi-circle"></i><span>Data Tables</span>
              </a>
            </li>
          </ul>
        </li><!-- End Tables Nav -->

        <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-bar-chart"></i><span>Charts</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li>
              <a href="charts-chartjs.html">
                <i class="bi bi-circle"></i><span>Chart.js</span>
              </a>
            </li>
            <li>
              <a href="charts-apexcharts.html">
                <i class="bi bi-circle"></i><span>ApexCharts</span>
              </a>
            </li>
            <li>
              <a href="charts-echarts.html">
                <i class="bi bi-circle"></i><span>ECharts</span>
              </a>
            </li>
          </ul>
        </li><!-- End Charts Nav -->

        <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-gem"></i><span>Icons</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li>
              <a href="icons-bootstrap.html">
                <i class="bi bi-circle"></i><span>Bootstrap Icons</span>
              </a>
            </li>
            <li>
              <a href="icons-remix.html">
                <i class="bi bi-circle"></i><span>Remix Icons</span>
              </a>
            </li>
            <li>
              <a href="icons-boxicons.html">
                <i class="bi bi-circle"></i><span>Boxicons</span>
              </a>
            </li>
          </ul>
        </li><!-- End Icons Nav -->

        <li class="nav-heading">Pages</li>

        <li class="nav-item">
          <a class="nav-link collapsed" href="<?= base_url() ?>BusquedaInteligente/motorBusqueda">
            <i class="bi bi-person"></i>
            <span>Profile</span>
          </a>
        </li><!-- End Profile Page Nav -->

        <li class="nav-item">
          <a class="nav-link collapsed" href="pages-faq.html">
            <i class="bi bi-question-circle"></i>
            <span>F.A.Q</span>
          </a>
        </li><!-- End F.A.Q Page Nav -->

        <li class="nav-item">
          <a class="nav-link collapsed" href="pages-contact.html">
            <i class="bi bi-envelope"></i>
            <span>Contact</span>
          </a>
        </li><!-- End Contact Page Nav -->

        <li class="nav-item">
          <a class="nav-link collapsed" href="pages-register.html">
            <i class="bi bi-card-list"></i>
            <span>Register</span>
          </a>
        </li><!-- End Register Page Nav -->

        <li class="nav-item">
          <a class="nav-link collapsed" href="pages-login.html">
            <i class="bi bi-box-arrow-in-right"></i>
            <span>Login</span>
          </a>
        </li><!-- End Login Page Nav -->

        <li class="nav-item">
          <a class="nav-link collapsed" href="pages-error-404.html">
            <i class="bi bi-dash-circle"></i>
            <span>Error 404</span>
          </a>
        </li><!-- End Error 404 Page Nav -->

        <li class="nav-item">
          <a class="nav-link collapsed" href="pages-blank.html">
            <i class="bi bi-file-earmark"></i>
            <span>Blank</span>
          </a>
        </li><!-- End Blank Page Nav -->
      <?php } ?>
    </ul>

  </aside><!-- End Sidebar-->