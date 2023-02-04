var isTableCategorias;

$(document).ready(function () {
    cargarCategorias();
    openModal();
    updateCategorias();
    saveCategorias();
});

function cargarCategorias() {
    isTableCategorias = $("#lista_categorias").DataTable({
        aProcessing: true,
        aServerSide: true,
        language: languajeDefault,
        ajax: {
            url: "Categorias/selectsCategorias",
            dataSrc: "",
        },
        columns: [
            { data: "numero", className: "text-center" },
            { data: "categoria_cod" },
            { data: "categoria_descripcion" },
            { data: "categoria_estadoD", className: "text-center" },
            { data: "options", className: "text-center" },
        ],
        resonsieve: "true",
        bDestroy: true,
        iDisplayLength: 10,
        Order: [[0, "desc"]],
    });
}

function openModal() {
    $(document).on('click', '.btn_editarCategorias', function () {

        // recogemos los datos de boton editar
        let id = $(this).attr('data-id');
        let codigo = $(this).attr('data-codigo');
        let descripcion = $(this).attr('data-descripcion');
        let estado = $(this).attr('data-estado');

        // agregamos los valores a los input
        $('#form_editarCategorias').attr('data-id', id);
        $('#__edit_codigo').val(codigo);
        $('#__edit_descripcion').val(descripcion);
        $('#__edit_estado').val(estado);

        $('#modal_editarCategorias').modal('show');
    });

    $('.btn_agregarCategorias').click(function () {
        $('#modal_agregarCategorias').modal('show');
    });
}

function updateCategorias() {
    $("#form_editarCategorias").submit(function (e) {
        e.preventDefault();

        let id = $(this).attr('data-id');
        const form = document.getElementById('form_editarCategorias');
        const formData = new FormData(form);
        formData.append('__edit_id', id);

        abrirLoadingModal();
        const request = axios.post(base_url + 'Categorias/updateCategorias', formData);

        request.then(res => {

            if (res.data.status) {
                $('#modal_editarCategorias').modal('hide');
                isTableCategorias.ajax.reload(() => cerrarLoadingModal());
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

function saveCategorias() {
    $('#form_agregarCategorias').submit(function (e) {
        e.preventDefault();

        const form = document.getElementById('form_agregarCategorias');
        const dataForm = new FormData(form);

        abrirLoadingModal();
        const request = axios.post(base_url + 'Categorias/saveCategorias', dataForm);

        request.then(res => {

            if (res.data.status) {
                $("#form_agregarCategorias").trigger("reset");
                isTableCategorias.ajax.reload(() => cerrarLoadingModal());
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