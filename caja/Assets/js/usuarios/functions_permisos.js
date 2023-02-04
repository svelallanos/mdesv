var listaPermisosPersonalizados

$(document).ready(function () {
  cargarPermisosPersonalizados();
  openModal();
  eliminarPermisoPersonalizado();
  actualizarUsuarioPermisos();
  eliminarPermisoUsuario();
});

function cargarPermisosPersonalizados() {
  listaPermisosPersonalizados = $("#tb_permisosPersonalizados").DataTable({
    aProcessing: true,
    aServerSide: true,
    language: languajeDefault,
    ajax: {
      url: "selectsPermisosPersonalizados",
      dataSrc: "",
    },
    columns: [
      { data: "numero" },
      { data: "nombre_completo" },
      { data: "usuarios_dni" },
      { data: "usuarios_cantidad" },
      { data: "dpu_fechacreacion" },
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

function cargarTablaUsuarios() {
  tabla_usuarios = $("#tb_usuarios").DataTable({
    aProcessing: true,
    aServerSide: true,
    language: languajeDefault,
    ajax: {
      url: "selects_usuariosforPermisos",
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
  $(document).on("click", ".openmodal_permiso_personalizados", function () {
    let usuarios_id = $(this).attr("data-usuarios_id");
    let nombres = $(this).attr("data-nombres");
    let dni = $(this).attr("data-dni");
    let formData = new FormData();

    formData.append("usuarios_id", usuarios_id);
    abrirLoadingModal();

    const request = axios.post("selectsPermisoPersonalizados", formData);

    request.then((res) => {
      if (res.data.status) {
        html = "";
        if (res.data.data !== null) {
          res.data.data.forEach((element) => {
            html += `<tr>
                        <td class="text-center">${element.numero}</td>
                        <td>${element.permiso_nombre}</td>
                        <td class="text-center"><button title="Eliminar motivo de bloqueo" data-permisopersonalizado_id="${element.dpu_id}" type="button" class="btn btn-sm btn-icon btn-danger text-red border border-red btn_eliminar_permiso"><i class="feather-trash-2"></i></button></td>
                      </tr>`;
          });
        }
        $("#permiso_nombre").val(nombres);
        $("#permiso_dni").val(dni);

        $("#tb_permiso_personzalizados").html(html);
        cerrarLoadingModal();
        $('#modal_detalle_permisos').modal('show');
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
    $("#form_permiso").attr("data-usuarios_id", usuarios_id);
    cerrarLoadingModal();
    $("#modal_permiso").modal("show");
  });
}

function eliminarPermisoPersonalizado() {
  $(document).on("click", ".btn_eliminar_permiso", function () {
    let permisopersonalizado_id = $(this).attr("data-permisopersonalizado_id");

    const formData = new FormData();
    formData.append("permisopersonalizado_id", permisopersonalizado_id);

    abrirLoadingModal();

    const request = axios.post("deletePermisoPersonalizado", formData);

    request.then((res) => {
      if (res.data.status) {
        html = "";
        msgFlash("mensaje_permiso", res.data.msg, res.data.value, 5000);
        if (res.data.data !== null) {
          res.data.data.forEach((element) => {
            html += `<tr>
                        <td class="text-center">${element.numero}</td>
                        <td>${element.permiso_nombre}</td>
                        <td class="text-center"><button title="Eliminar motivo de bloqueo" data-permisopersonalizado_id="${element.dpu_id}" type="button" class="btn btn-sm btn-icon btn-danger text-red border border-red btn_eliminar_permiso"><i class="feather-trash-2"></i></button></td>
                      </tr>`;
          });
        }
        listaPermisosPersonalizados.ajax.reload(() => cerrarLoadingModal());
        $("#tb_permiso_personzalizados").html(html);
      } else {
        cerrarLoadingModal();
        Swal.fire("ALERTA", res.data.msg, res.data.value);
      }
    });
  });
}

function actualizarUsuarioPermisos() {
  $('#form_permiso_personalizados').submit(function (e) {
    e.preventDefault();

    let usuarios_id = $(this).attr('data-usuarios_id');
    let form = document.getElementById('form_permiso_personalizados');
    let form_data = new FormData(form);

    form_data.append('usuarios_id', usuarios_id);

    const request = axios.post('updateUsuarioPermisos', form_data);

    request.then(function (res) {
      if (res.data.status) {
        Swal.fire({
          icon: res.data.value,
          title: 'Correcto',
          text: res.data.msg
        });
        window.location.reload();
      } else {
        Swal.fire({
          icon: res.data.value,
          title: 'Correcto',
          text: res.data.msg
        });
      }
    });

    request.catch(function (error) {
      console.log(error);
    });
  });
}

function eliminarPermisoUsuario() {
  $(document).on('click', '.btn_eliminar_permisos_personalizados', function(){
    let usuarios_id = $(this).attr("data-usuarios_id");
    let nombres = $(this).attr("data-nombres");

    Swal.fire({
      title: "ELIMINAR PERMISOS",
      text: "¿Estas seguro de eliminar los permisos personalizados del usuario : " + nombres + "?",
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
        const request = axios.post("deletePermisosPersonalizados", formData);

        request.then((res) => {
          if (res.data.status) {
            msgFlash("mensaje_eliminarpermisos", res.data.msg, res.data.value, 5000);
            listaPermisosPersonalizados.ajax.reload(() => cerrarLoadingModal());
          } else {
            cerrarLoadingModal();
            Swal.fire("ALERTA", res.data.msg, res.data.value);
          }
        });
      }
    });
  });
}