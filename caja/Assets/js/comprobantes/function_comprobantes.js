var isTableComprobantes;

$(document).ready(function () {
    listarComprobantes();
    openModal();
    updateComprobantes();
    saveComprobantes();
    deleteComprobantes();
});

function listarComprobantes() {
    isTableComprobantes = $("#lista_comprobantes").DataTable({
        aProcessing: true,
        aServerSide: true,
        language: languajeDefault,
        ajax: {
            url: "Comprobantes/listComprobantes",
            dataSrc: "",
        },
        columns: [
            { data: "numero", className: "text-center" },
            { data: "comprobantes_descripcion" },
            { data: "comprobantes_serie" },
            { data: "comprobantes_estado", className: "text-center" },
            { data: "options", className: "text-center" },
        ],
        resonsieve: "true",
        bDestroy: true,
        iDisplayLength: 10,
        Order: [[0, "desc"]],
    });
}

function openModal() {
    $(document).on('click', '.btn_editarComprobantes', function () {

        // recogemos los datos de boton editar
        let id = $(this).attr('data-id');
        let codigo = $(this).attr('data-serie');
        let descripcion = $(this).attr('data-descripcion');
        let estado = $(this).attr('data-estado');

        //agregamos los valores a los input
        $('#form_editarComprobantes').attr('data-id', id);
        $('#__edit_serie').val(codigo);
        $('#__edit_descripcion').val(descripcion);
        $('#__edit_estado').val(estado);

        $('#modal_editarComprobantes').modal('show');
    });

    $('.btn_agregarComprobantes').click(function () {
        $('#modal_agregarComprobantes').modal('show');
    });
}

function updateComprobantes() {
    $("#form_editarComprobantes").submit(function (e) {
        e.preventDefault();

        let id = $(this).attr('data-id');
        const form = document.getElementById('form_editarComprobantes');
        const formData = new FormData(form);
        formData.append('__edit_id', id);

        abrirLoadingModal();
        const request = axios.post(base_url + 'Comprobantes/updateComprobantes', formData);

        request.then(res => {

            if (res.data.status) {
                $('#modal_editarComprobantes').modal('hide');
                isTableComprobantes.ajax.reload(() => cerrarLoadingModal());
                Toast.fire({
                    icon: res.data.isValue,
                    title: res.data.message
                })
            } else {
                cerrarLoadingModal();
                Toast.fire({
                    icon: res.data.isValue,
                    title: res.data.message
                })
            }
        });

        request.catch(error => {
            Toast.fire({
                icon: 'error',
                title: 'Error del servidor : ' + error
            })
        });
    });
}

function saveComprobantes() {
    $('#form_agregarComprobantes').submit(function (e) {
        e.preventDefault();

        const form = document.getElementById('form_agregarComprobantes');
        const dataForm = new FormData(form);

        abrirLoadingModal();
        const request = axios.post(base_url + 'Comprobantes/saveComprobantes', dataForm);

        request.then(res => {

            if (res.data.status) {
                $("#form_agregarComprobantes").trigger("reset");
                isTableComprobantes.ajax.reload(() => cerrarLoadingModal());
                Toast.fire({
                    icon: res.data.isValue,
                    title: res.data.message
                })

            } else {
                cerrarLoadingModal();
                Toast.fire({
                    icon: res.data.isValue,
                    title: res.data.message
                })
            }
        });

        request.catch(error => {
            Toast.fire({
                icon: 'error',
                title: 'Error del servidor : ' + error
            })
        });
    });
}

function deleteComprobantes() {
    $(document).on("click", ".btn_deleteCategorias", function () {
        let id = $(this).attr("data-id");
        let descripcion = $(this).attr("data-descripcion");

        Swal.fire({
            title: 'ELIMINAR REGISTRO',
            text: '¿Estas seguro de eliminar el registro: ' + descripcion.toUpperCase() + '?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Continuar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {

                const formData = new FormData();
                formData.append('comprobanes_id', id);

                abrirLoadingModal();
                const request = axios.post(base_url + 'Comprobantes/deleteComprobantes', formData);

                request.then(res => {

                    cerrarLoadingModal();
                    if (res.data.status) {
                        isTableComprobantes.ajax.reload(() => cerrarLoadingModal());
                        Toast.fire({
                            icon: 'success',
                            title: 'Registro : ' + descripcion.toUpperCase() + ' eliminado correctamente.',
                        });
                    } else {
                        Toast.fire({
                            icon: res.data.isValue,
                            title: res.data.message
                        });
                    }
                });

                request.catch(error => {
                    Toast.fire({
                        icon: 'error',
                        title: 'Error del servidor : ' + error
                    })
                });
            }
        });
    });
}