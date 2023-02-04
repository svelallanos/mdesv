$(document).ready(function() {
  actualizarRolPermisos();
});

function actualizarRolPermisos() {
  $('#form_rol_permisos_update').submit(function (e) {
    e.preventDefault();

    let roles_id = $(this).attr('data-roles-id');
    let form = document.getElementById('form_rol_permisos_update');
    let form_data = new FormData(form);

    form_data.append('roles_id', roles_id);

    const request = axios.post('updateRolPermisos', form_data);

    request.then(function (response) {
      if(response.data.status){
        Swal.fire({
          icon: response.data.value,
          title: 'Correcto',
          text: response.data.msg
        });
        window.location.reload();
      }else{
        Swal.fire({
          icon: response.data.value,
          title: 'Correcto',
          text: response.data.msg
        });
      }
    });

    request.catch(function (error) {
      console.log(error);
    });
  });
}