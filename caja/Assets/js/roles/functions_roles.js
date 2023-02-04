$(document).ready(function () {
  registrarRol();
  eliminarRol();
  cargarRoles();
});

function registrarRol() {
  $("#form_rol_permisos").submit(function (e) {
    e.preventDefault();
    let form = document.querySelector("#form_rol_permisos");
    let dataform = new FormData(form);

    abrirLoadingModal();

    const request = axios.post("registrarRol", dataform);

    request.then(function (response) {
      cerrarLoadingModal();
      if (response.data.status) {
        msgFlash("mensaje", response.data.msg, response.data.value, 5000);
      } else {
        msgFlash("mensaje", response.data.msg, response.data.value, 5000);
      }
    });

    request.catch(function (error) {
      msgFlash("mensaje", error, "error", 5000);
    });
  });
}

function eliminarRol() {
  $(document).on('click', '.eliminar_rol', function () {
    let roles_id = $(this).attr('data-roles_id');

    Swal.fire({
      title: 'ELIMINAR ROL',
      text: "¿Estas seguro de eliminar este rol, no podrás revertir esto?",
      icon: 'info',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ok',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {

        const formData = new FormData();

        formData.append('roles_id', roles_id);

        const request = axios.post('Roles/deleteRol', formData);

        request.then(res => {
          if (res.data.status) {
            Swal.fire(
              'CORRECTO',
              res.data.msg,
              res.data.value
            );

            location.reload();
          } else {
            Swal.fire(
              'ALERTA',
              res.data.msg,
              res.data.value
            );
          }
        });

        request.catch(error => {
          console.log(error);
        });
      }
    })

    console.log(roles_id);
  });
}

const cargarRoles = () => {
  $('#tb_roles').DataTable({
    language: languajeDefault,
  });
}