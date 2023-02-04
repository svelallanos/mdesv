$(document).ready(function () {

  setTimeout(() => {
    $('.flash_msg_remove').remove();
  }, 120000);

  $(document).on("click", ".flash_msg_close", function (e) {
    $(this).parent().remove();
  });

  $(document).on("click", ".click_for_loading", function (e) {

    abrirLoadingModal($(this).attr('data-load'));
    controlarOpenCloseModalLoas = true;

    if (e.currentTarget.localName.toLowerCase() == 'a') {
      let hrefAttr = $.trim($(this).attr('href'));

      if (hrefAttr != undefined && hrefAttr != '' && hrefAttr != null) {
        e.preventDefault();
        location.href = hrefAttr;
      }
    }

  });

  $(document).on("submit", ".submit_for_loading", function (e) {

    abrirLoadingModal($(this).attr('data-load'));
    controlarOpenCloseModalLoas = true;
    e.preventDefault();
    e.target.submit();

  });

  if ($('.reload_open_modal_load').length > 0) {
    window.onbeforeunload = function () {
      if (controlarOpenCloseModalLoas == false) {
        abrirLoadingModal();
      }
    };
  }

  $('#modal_soon_logout .btn').click(function () {
    location.reload();
  });

  $('#modal_session_expired .btn').click(function () {
    location.reload();
  });
});

// Funcion para cerrar el modal de actualizar página
function uploadPage(idPage, habilitar = false) {
  if (habilitar) {
    $(idPage).removeClass('hide');
    $(idPage).addClass('show');
    $('.btn_close_page').click(function () {
      $(idPage).removeClass('show');
      $(idPage).addClass('hide');
    });
  }
}

function iconLoader(clase, estado) {
  if (estado === 'show') {
    $(clase).removeClass('hide');
    $(clase).addClass(estado);
  } else if (estado === 'hide') {
    $(clase).removeClass('show');
    $(clase).addClass(estado);
  } else {
    console.log('La clase Loader y el estado no estan definido correctamente.');
  }
}

const languajeDefault = {
  "processing": "Procesando...",
  "lengthMenu": "Mostrar _MENU_ registros",
  "zeroRecords": "No se encontraron resultados",
  "emptyTable": "Ningún dato disponible en esta tabla",
  "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
  "infoFiltered": "(filtrado de un total de _MAX_ registros)",
  "search": "Buscar:",
  "infoThousands": ",",
  "loadingRecords": "Cargando...",
  "paginate": {
    "first": '<i class="fa-solid fa-backward-fast"></i>',
    "last": '<i class="fa-solid fa-forward-fast"></i>',
    "next": '<i class="fa-solid fa-angles-right"></i>',
    "previous": '<i class="fa-solid fa-angles-left"></i>'
  },
  "aria": {
    "sortAscending": ": Activar para ordenar la columna de manera ascendente",
    "sortDescending": ": Activar para ordenar la columna de manera descendente"
  },
  "buttons": {
    "copy": "Copiar",
    "colvis": "Visibilidad",
    "collection": "Colección",
    "colvisRestore": "Restaurar visibilidad",
    "copyKeys": "Presione ctrl o u2318 + C para copiar los datos de la tabla al portapapeles del sistema. <br \/> <br \/> Para cancelar, haga clic en este mensaje o presione escape.",
    "copySuccess": {
      "1": "Copiada 1 fila al portapapeles",
      "_": "Copiadas %ds fila al portapapeles"
    },
    "copyTitle": "Copiar al portapapeles",
    "csv": "CSV",
    "excel": "Excel",
    "pageLength": {
      "-1": "Mostrar todas las filas",
      "_": "Mostrar %d filas"
    },
    "pdf": "PDF",
    "print": "Imprimir",
    "renameState": "Cambiar nombre",
    "updateState": "Actualizar",
    "createState": "Crear Estado",
    "removeAllStates": "Remover Estados",
    "removeState": "Remover",
    "savedStates": "Estados Guardados",
    "stateRestore": "Estado %d"
  },
  "autoFill": {
    "cancel": "Cancelar",
    "fill": "Rellene todas las celdas con <i>%d<\/i>",
    "fillHorizontal": "Rellenar celdas horizontalmente",
    "fillVertical": "Rellenar celdas verticalmentemente"
  },
  "decimal": ",",
  "searchBuilder": {
    "add": "Añadir condición",
    "button": {
      "0": "Constructor de búsqueda",
      "_": "Constructor de búsqueda (%d)"
    },
    "clearAll": "Borrar todo",
    "condition": "Condición",
    "conditions": {
      "date": {
        "after": "Despues",
        "before": "Antes",
        "between": "Entre",
        "empty": "Vacío",
        "equals": "Igual a",
        "notBetween": "No entre",
        "notEmpty": "No Vacio",
        "not": "Diferente de"
      },
      "number": {
        "between": "Entre",
        "empty": "Vacio",
        "equals": "Igual a",
        "gt": "Mayor a",
        "gte": "Mayor o igual a",
        "lt": "Menor que",
        "lte": "Menor o igual que",
        "notBetween": "No entre",
        "notEmpty": "No vacío",
        "not": "Diferente de"
      },
      "string": {
        "contains": "Contiene",
        "empty": "Vacío",
        "endsWith": "Termina en",
        "equals": "Igual a",
        "notEmpty": "No Vacio",
        "startsWith": "Empieza con",
        "not": "Diferente de",
        "notContains": "No Contiene",
        "notStarts": "No empieza con",
        "notEnds": "No termina con"
      },
      "array": {
        "not": "Diferente de",
        "equals": "Igual",
        "empty": "Vacío",
        "contains": "Contiene",
        "notEmpty": "No Vacío",
        "without": "Sin"
      }
    },
    "data": "Data",
    "deleteTitle": "Eliminar regla de filtrado",
    "leftTitle": "Criterios anulados",
    "logicAnd": "Y",
    "logicOr": "O",
    "rightTitle": "Criterios de sangría",
    "title": {
      "0": "Constructor de búsqueda",
      "_": "Constructor de búsqueda (%d)"
    },
    "value": "Valor"
  },
  "searchPanes": {
    "clearMessage": "Borrar todo",
    "collapse": {
      "0": "Paneles de búsqueda",
      "_": "Paneles de búsqueda (%d)"
    },
    "count": "{total}",
    "countFiltered": "{shown} ({total})",
    "emptyPanes": "Sin paneles de búsqueda",
    "loadMessage": "Cargando paneles de búsqueda",
    "title": "Filtros Activos - %d",
    "showMessage": "Mostrar Todo",
    "collapseMessage": "Colapsar Todo"
  },
  "select": {
    "cells": {
      "1": "1 celda seleccionada",
      "_": "%d celdas seleccionadas"
    },
    "columns": {
      "1": "1 columna seleccionada",
      "_": "%d columnas seleccionadas"
    },
    "rows": {
      "1": "1 fila seleccionada",
      "_": "%d filas seleccionadas"
    }
  },
  "thousands": ".",
  "datetime": {
    "previous": "Anterior",
    "next": "Proximo",
    "hours": "Horas",
    "minutes": "Minutos",
    "seconds": "Segundos",
    "unknown": "-",
    "amPm": [
      "AM",
      "PM"
    ],
    "months": {
      "0": "Enero",
      "1": "Febrero",
      "10": "Noviembre",
      "11": "Diciembre",
      "2": "Marzo",
      "3": "Abril",
      "4": "Mayo",
      "5": "Junio",
      "6": "Julio",
      "7": "Agosto",
      "8": "Septiembre",
      "9": "Octubre"
    },
    "weekdays": [
      "Dom",
      "Lun",
      "Mar",
      "Mie",
      "Jue",
      "Vie",
      "Sab"
    ]
  },
  "editor": {
    "close": "Cerrar",
    "create": {
      "button": "Nuevo",
      "title": "Crear Nuevo Registro",
      "submit": "Crear"
    },
    "edit": {
      "button": "Editar",
      "title": "Editar Registro",
      "submit": "Actualizar"
    },
    "remove": {
      "button": "Eliminar",
      "title": "Eliminar Registro",
      "submit": "Eliminar",
      "confirm": {
        "_": "¿Está seguro que desea eliminar %d filas?",
        "1": "¿Está seguro que desea eliminar 1 fila?"
      }
    },
    "error": {
      "system": "Ha ocurrido un error en el sistema (<a target=\"\\\" rel=\"\\ nofollow\" href=\"\\\">Más información&lt;\\\/a&gt;).<\/a>"
    },
    "multi": {
      "title": "Múltiples Valores",
      "info": "Los elementos seleccionados contienen diferentes valores para este registro. Para editar y establecer todos los elementos de este registro con el mismo valor, hacer click o tap aquí, de lo contrario conservarán sus valores individuales.",
      "restore": "Deshacer Cambios",
      "noMulti": "Este registro puede ser editado individualmente, pero no como parte de un grupo."
    }
  },
  "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
  "stateRestore": {
    "creationModal": {
      "button": "Crear",
      "name": "Nombre:",
      "order": "Clasificación",
      "paging": "Paginación",
      "search": "Busqueda",
      "select": "Seleccionar",
      "columns": {
        "search": "Búsqueda de Columna",
        "visible": "Visibilidad de Columna"
      },
      "title": "Crear Nuevo Estado",
      "toggleLabel": "Incluir:"
    },
    "emptyError": "El nombre no puede estar vacio",
    "removeConfirm": "¿Seguro que quiere eliminar este %s?",
    "removeError": "Error al eliminar el registro",
    "removeJoiner": "y",
    "removeSubmit": "Eliminar",
    "renameButton": "Cambiar Nombre",
    "renameLabel": "Nuevo nombre para %s",
    "duplicateError": "Ya existe un Estado con este nombre.",
    "emptyStates": "No hay Estados guardados",
    "removeTitle": "Remover Estado",
    "renameTitle": "Cambiar Nombre Estado"
  }
}

function abrirLoadingModal(text = null) {
  controlarOpenCloseModalLoas = true;

  switch (text) {
    case 'Save':
      text = 'Guardando';
      break;
    case 'Cancel':
      text = 'Cancelando';
      break;
    case 'Update':
      text = 'Actualizando';
      break;
    case 'Delete':
      text = 'Borrando';
      break;
    case 'Send':
      text = 'Enviando';
      break;
    default:
      text = 'Cargando';
      break;
  }

  $('#semi_modal_loading ._modal_loader--text').html(text);
  $('#bg_semi_modal_loading').removeClass('d-none');
  $('#semi_modal_loading').modal('show');
  $('#semi_modal_loading').addClass('fade');
}

function cerrarLoadingModal() {
  controlarOpenCloseModalLoas = false;
  $('#semi_modal_loading').removeClass('fade');
  $('#semi_modal_loading').modal('hide');
  $('#bg_semi_modal_loading').addClass('d-none');
}

function msgAlert(type = 'danger', text = 'Ocurrió un error desconocido', time = 120000) {
  let icon = '';
  let retorno = '';
  let clase = 'class_' + makeId(30);

  text = text.trim();

  switch (type) {
    case 'success':
      icon = '<i class="ml-1 far fs-22 fa-check-circle"></i>';
      text = '<span class="fw-500">ÉXITO</span>: ' + text;
      break;
    case 'danger':
    case 'error':
      icon = '<i class="ml-1 far fs-22 fa-times-circle"></i>';
      text = '<span class="fw-500">ERROR</span>: Ocurrió un error desconocido.';
      type = 'danger';
      break;
    case 'info':
      icon = '<i class="ml-1 far fs-22 fa-solid fa-triangle-exclamation"></i>';
      text = '<span class="fw-500">NOTA</span>: ' + text;
      break;
    case 'warning':
      icon = '<i class="ml-1 far fs-22 fa-solid fa-circle-info"></i>';
      text = '<span class="fw-500">ALERTA</span>: ' + text;
      break;
  }

  retorno = `<div class="alert __respuesta_mesaje_${type} ${clase} alert-dismissible fade show d-flex align-items-center" role="alert">
                <div class="alert-icon-aside bg-${type}">
                ${icon}
                </div>
                <div class="alert-icon-content">
                ${text}
                </div>
                <button type="button" class="btn-close border border-dark p-1 mt-2" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
          `;

  setTimeout(() => {
    $('.' + clase).remove();
  }, time);

  return retorno;
}

function msgFlash(classapend = '', text = '', type = '', time = 3000) {
  classapend = classapend.trim();
  $('.' + classapend).append(msgAlert(type, text, time));
}

function makeId(length) {
  var result = '';
  var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
  var charactersLength = characters.length;

  for (var i = 0; i < length; i++) {
    result += characters.charAt(Math.floor(Math.random() * charactersLength));
  }

  let date = new Date();
  result = result + date.getFullYear() + '' + date.getMonth() + '' + date.getDay() + '' + date.getDate() +
    '' + date.getHours() + '' + date.getMinutes() + '' + date.getSeconds() + '' + date.getMilliseconds();

  return result;
}

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})