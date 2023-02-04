var listaUsuariosBloqueados;
var listaUsuarios;
var tabla_usuarios;
var lista_AlumnosIntranet;
var imgSeleccionada = 1;

$(document).ready(function () {
  cargarListaUsuariosBloqueados();
  cargarListUsuarios();
  openModal();
  actualizarUsuario();
  actualizarImagenPerfil();
  eliminarMotivoBloqueo();
  guardarBloqueoUsuario();
  desbloquearUsuario();

  // Habilitar el actualizar de roles del usuario
  habilitarRolesUpdate();
});

function cargarListaUsuariosBloqueados() {
  listaUsuariosBloqueados = $("#lista_bloqueos").DataTable({
    aProcessing: true,
    aServerSide: true,
    language: languajeDefault,
    ajax: {
      url: "selectsUsuariosBloqueados",
      dataSrc: "",
    },
    columns: [
      { data: "numero" },
      { data: "nombre_completo" },
      { data: "usuarios_dni" },
      { data: "usuarios_cantidad" },
      { data: "bloqueo_fechacreacion" },
      { data: "options" },
    ],
    resonsieve: "true",
    bDestroy: true,
    iDisplayLength: 10,
    Order: [[0, "desc"]],
    columnDefs: [
      {
        class: "col-1 text-center",
        targets: 0,
      },
      {
        class: "col-4",
        targets: 1,
      },
      {
        class: "col-1",
        targets: 2,
      },
      {
        class: "col-2 text-center",
        targets: 3,
      },
      {
        class: "col-3",
        targets: 4,
      },
      {
        class: "col-1 text-center",
        targets: 5,
      },
    ],
  });
}

function cargarListUsuarios() {
  listaUsuarios = $("#lista_usuarios").DataTable({
    aProcessing: true,
    aServerSide: true,
    language: languajeDefault,
    ajax: {
      url: "Usuarios/selectsUsers",
      dataSrc: "",
    },
    columns: [
      { data: "numero" },
      { data: "usuarios" },
      { data: "usuarios_dni" },
      { data: "fechacreacion" },
      { data: "roles" },
      { data: "estado" },
      { data: "options" },
    ],
    resonsieve: "true",
    bDestroy: true,
    iDisplayLength: 10,
    Order: [[0, "desc"]],
  });
}

function cargarTablaUsuarios() {
  tabla_usuarios = $("#tb_usuarios").DataTable({
    aProcessing: true,
    aServerSide: true,
    language: languajeDefault,
    ajax: {
      url: "selects_usuariosforBloqueo",
      dataSrc: "",
    },
    columns: [
      { data: "numero" },
      { data: "usuarios_nombres" },
      { data: "apellidos" },
      { data: "usuarios_dni" },
      { data: "options" },
    ],
    resonsieve: "true",
    bDestroy: true,
    iDisplayLength: 10,
    Order: [[0, "desc"]],
    columnDefs: [
      {
        class: "col-1",
        targets: 0,
      },
      {
        class: "col-3",
        targets: 1,
      },
      {
        class: "col-4",
        targets: 2,
      },
      {
        class: "col-3",
        targets: 3,
      },
      {
        class: "col-1",
        targets: 4,
      },
    ],
  });
}

function openModal() {
  $(document).on("click", ".btn_ver_usuario_intranet", function () {
    abrirLoadingModal();
    let usuario = $(this).attr("data-nombre");
    let dni = $(this).attr("data-dni");
    let rol = $(this).attr("data-rol");
    let estado = $(this).attr("data-estado");
    let hora = $(this).attr("data-hora");
    let fecha = $(this).attr("data-fecha");

    let estado_activo =
      '<span class="badge bg-danger">Usuario Bloqueado</span>';
    if (estado == 1) {
      estado_activo = '<span class="badge bg-success">Activo</span>';
    }

    $(".ver_nombre").html(
      '<i class="feather-chevron-right"></i><span class="fw-700">NOMBRE: </span>' +
        usuario
    );
    $(".ver_dni").html(
      '<i class="feather-chevron-right"></i><span class="fw-700">DNI: </span>' +
        dni
    );
    $(".ver_rol").html(
      '<i class="feather-chevron-right"></i><span class="fw-700">ROL: </span>' +
        '<span class="badge bg-light text-black">' +
        rol +
        "</span>"
    );
    $(".ver_estado").html(
      '<i class="feather-chevron-right"></i><span class="fw-700">ESTADO: </span>' +
        estado_activo
    );
    $(".ver_fecha").html(
      '<i class="feather-chevron-right"></i><span class="fw-700">FECHA CREACIÓN: </span>' +
        '<span class="text-blue fw-700">' +
        hora +
        "</span> - " +
        fecha
    );
    cerrarLoadingModal();
    $("#modal_ver_usuario_intranet").modal("show");
  });

  $(document).on("click", ".openmodal_detalle_bloqueo", function () {
    let usuarios_id = $(this).attr("data-usuarios_id");
    let nombres = $(this).attr("data-nombres");
    let dni = $(this).attr("data-dni");
    let formData = new FormData();

    formData.append("usuarios_id", usuarios_id);
    abrirLoadingModal();

    const request = axios.post("selectsUsuarioBloqueos", formData);

    request.then((res) => {
      if (res.data.status) {
        html = "";
        res.data.data.forEach((element) => {
          html += `<tr>
                      <td class="text-center">${element.numero}</td>
                      <td>${element.tipo_bloqueo_descripcion}</td>
                      <td class="text-center"><button title="Eliminar motivo de bloqueo" data-bloqueo_id="${element.bloqueo_id}" type="button" class="btn btn-sm btn-icon btn-danger text-red border border-red btn_eliminar_bloqueo"><i class="feather-trash-2"></i></button></td>
                    </tr>`;
        });
        $("#bloqueo_nombre").val(nombres);
        $("#bloqueo_dni").val(dni);
        $("#tb_bloqueo_motivos").html(html);
        cerrarLoadingModal();
        $("#modal_detalle_bloqueo").modal("show");
      } else {
        cerrarLoadingModal();
        Swal.fire("ALERTA", res.data.msg, res.data.value);
      }
    });

    request.catch((error) => {
      console.log(error);
    });
  });

  $(".open_modal_usuarios").click(function () {
    abrirLoadingModal();
    cargarTablaUsuarios();
    cerrarLoadingModal();
    $("#modal_list_usuarios").modal("show");
  });

  $(document).on("click", ".open_modal_agregar_bloqueo", function () {
    abrirLoadingModal();
    let nombres = $(this).attr("data-nombres");
    let usuarios_id = $(this).attr("data-usuarios_id");

    $("#text_nombre_usuario").val(nombres);
    $("#form_bloqueo").attr("data-usuarios_id", usuarios_id);
    cerrarLoadingModal();
    $("#modal_bloqueos").modal("show");
  });
}

function habilitarRolesUpdate() {
  $("#check_editar_rol").click(function () {
    if ($(this).prop("checked")) {
      $(".roles_update").prop("disabled", false);
    } else {
      $(".roles_update").prop("disabled", true);
    }
  });
}

function actualizarUsuario() {
  $("#form_update_usuario").submit(function (e) {
    e.preventDefault();

    const form = document.getElementById("form_update_usuario");
    const formData = new FormData(form);
    let usuarios_id = $(this).attr("data-usuario_id");
    let update_rol = 0;

    if ($("#check_editar_rol").prop("checked")) {
      update_rol = 1;
    }

    formData.append("usuarios_id", usuarios_id);
    formData.append("update_rol", update_rol);
    abrirLoadingModal();

    const request = axios.post("updateUsuario", formData);

    request.then((res) => {
      cerrarLoadingModal();
      msgFlash("mensaje", res.data.msg, res.data.value, 5000);
      if (res.data.status) {
        uploadPage("#close_page", true);
      }
    });

    request.catch((error) => {
      console.log(error);
    });
  });
}

function actualizarImagenPerfil() {
  $(".cargar_imagen").click(function () {
    $("#file_imagen_perfil").click();
  });

  $("#file_imagen_perfil").change(function () {
    let pathImage = $(".img-account-profile").attr("data-path");
    if (imgSeleccionada == 0) {
      $("#file_imagen_perfil").val("");
      return false;
    }

    $(".cargar_imagen").attr("disabled", true);
    $(".container_loader").removeClass("hide");
    $(".container_loader").addClass("show");

    iconLoader(".container_loader", "show");

    let inputFile = $("#file_imagen_perfil");
    if (inputFile.val() === "") {
      console.log("sin foto");
      return;
    }

    let usuarios_id = $("#form_update_usuario").attr("data-usuario_id");
    let formData = new FormData();
    let files = inputFile[0].files[0];
    $("#file_imagen_perfil").val("");

    formData.append("fileprofile", files);
    formData.append("usuarios_id", usuarios_id);

    abrirLoadingModal();
    var request = axios.post("updateFotoPefilUsuario", formData);

    request.then((res) => {
      if (res.data.status) {
        msgFlash("mensaje_file", res.data.msg, res.data.value, 5000);
        $(".img-account-profile").attr("src", pathImage + res.data.name_foto);
      } else {
        msgFlash("mensaje_file", res.data.msg, res.data.value, 5000);
        if (res.data.name_foto != null) {
          $(".img-account-profile").attr("src", pathImage + res.data.name_foto);
        }
      }

      iconLoader(".container_loader", "hide");
      $(".cargar_imagen").attr("disabled", false);

      cerrarLoadingModal();
    });

    request.catch((error) => {
      console.log(error);
    });
  });
}

function eliminarMotivoBloqueo() {
  $(document).on("click", ".btn_eliminar_bloqueo", function () {
    let bloqueo_id = $(this).attr("data-bloqueo_id");

    const formData = new FormData();
    formData.append("bloqueo_id", bloqueo_id);

    abrirLoadingModal();

    const request = axios.post("deleteMotivoBloqueo", formData);

    request.then((res) => {
      if (res.data.status) {
        html = "";
        msgFlash("mensaje_bloqueo", res.data.msg, res.data.value, 5000);
        if (res.data.data !== null) {
          res.data.data.forEach((element) => {
            html += `<tr>
                      <td class="text-center">${element.numero}</td>
                      <td>${element.tipo_bloqueo_descripcion}</td>
                      <td class="text-center"><button title="Eliminar motivo de bloqueo" data-bloqueo_id="${element.bloqueo_id}" type="button" class="btn btn-sm btn-icon btn-danger text-red border border-red btn_eliminar_bloqueo"><i class="feather-trash-2"></i></button></td>
                    </tr>`;
          });
        }
        listaUsuariosBloqueados.ajax.reload(() => cerrarLoadingModal());
        $("#tb_bloqueo_motivos").html(html);
      } else {
        cerrarLoadingModal();
        Swal.fire("ALERTA", res.data.msg, res.data.value);
      }
    });

    request.catch(error => {
      console.log(error);
    });
  });
}

function guardarBloqueoUsuario() {
  $("#form_bloqueo").submit(function (e) {
    e.preventDefault();

    let usuarios_id = $(this).attr("data-usuarios_id");
    let form = document.getElementById("form_bloqueo");
    const formData = new FormData(form);

    formData.append("usuarios_id", usuarios_id);
    abrirLoadingModal();
    const request = axios.post("insertUsuarioBloqueo", formData);

    request.then((res) => {
      if (res.data.status) {
        listaUsuariosBloqueados.ajax.reload(() => cerrarLoadingModal());
        Swal.fire("CORRECTO", res.data.msg, res.data.value);
      } else {
        cerrarLoadingModal();
        Swal.fire("ALERTA", res.data.msg, res.data.value);
      }
    });

    request.catch((error) => {
      console.log(error);
    });
  });
}

function desbloquearUsuario() {
  $(document).on("click", ".btn_desbloquear", function () {
    let usuarios_id = $(this).attr("data-usuarios_id");
    let nombres = $(this).attr("data-nombres");

    Swal.fire({
      title: "DESBLOQUEAR USUARIO",
      text: "¿Estas seguro de desbloquear al usuario : " + nombres + "?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ok",
      cancelButtonText: "Cancelar",
    }).then((result) => {
      if (result.isConfirmed) {
        const formData = new FormData();
        formData.append("usuarios_id", usuarios_id);

        abrirLoadingModal();
        const request = axios.post("desbloquearUsuario", formData);

        request.then((res) => {
          if (res.data.status) {
            msgFlash("mensaje_desbloqueo", res.data.msg, res.data.value, 5000);
            listaUsuariosBloqueados.ajax.reload(() => cerrarLoadingModal());
          } else {
            cerrarLoadingModal();
            Swal.fire("ALERTA", res.data.msg, res.data.value);
          }
        });
      }
    });
  });
}
