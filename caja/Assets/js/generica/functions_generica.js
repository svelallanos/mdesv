var tablaGenerica;

$(document).ready(function() {
    cargarGenerica();
});

function cargarGenerica() {
    tablaGenerica = $('#lista_generica').dataTable({
        aProcessing: true,
        aServerSide: true,
        language: languajeDefault,
        ajax: {
            url: "Generica/selectsGenerica",
            dataSrc: "",
        },
        columns: [
            { data: "numero", className: "text-center" },
            { data: "generica_descripcion" },
            { data: "generica_codigo" },
            { data: "categoria_descripcion" },
            { data: "generica_estado", className: "text-center" },
            { data: "options", className: "text-center" },
        ],
        resonsieve: "true",
        bDestroy: true,
        iDisplayLength: 10,
        Order: [[0, "desc"]],
    });
}