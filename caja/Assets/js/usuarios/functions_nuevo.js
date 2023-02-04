$(document).ready(function () {
  consultarDatosApi();
  agregarUsuario();
});

function consultarDatosApi() {
  $('#consultarDatosDni').submit(function (e) {
    e.preventDefault();

    let form = document.getElementById('consultarDatosDni');
    const formData = new FormData(form);

    abrirLoadingModal();
    const request = axios.post('consultarDatosDni', formData);

    request.then(res => {
      if (res.data.status) {
        console.log(res.data.data);
        $('#usuarios_login').val(res.data.data.dni);
        $('#usuarios_dni').val(res.data.data.dni);
        $('#usuarios_nombres').val(res.data.data.nombres);
        $('#usuarios_paterno').val(res.data.data.apellido_paterno);
        $('#usuarios_materno').val(res.data.data.apellido_materno);
        $('#password').val(((res.data.data.apellido_paterno[0].toUpperCase() + (res.data.data.apellido_paterno.slice(1).toLowerCase())) + '.' + res.data.data.dni).trim());
      } else {
        msgFlash("mensaje", res.data.msg, res.data.value, 5000);
      }
      
      cerrarLoadingModal();
    });
    request.catch(error => {
      console.log(error);
    });
  });
}

function agregarUsuario() {
  $('#form_agregar_usuario').submit(function (e) {
    e.preventDefault();

    const form = document.getElementById('form_agregar_usuario');
    const formData = new FormData(form);
    abrirLoadingModal();
    const request = axios.post(base_url + 'Usuarios/agregarUsuario', formData);

    request.then(res => {
      msgFlash("mensaje", res.data.msg, res.data.value, 5000);
      if (res.data.status) {
        form.reset();
        const formBuscador = document.getElementById('consultarDatosDni');
        formBuscador.reset();
      }

      cerrarLoadingModal();
    });

    request.catch(error => {
      console.log(error);
    });
  });
}