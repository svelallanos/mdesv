<?php

class Comprobantes extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    public function comprobantes()
    {
        parent::verificarLogin(true);
        parent::verificarPermiso(6, true);

        $data['page_id'] = 6;
        $data['page_tag'] = "MDESV - Sistema Caja";
        $data['page_title'] = ":. Comprobantes - Sistema Caja";
        $data['page_name'] = "MDESV Sistema Caja";
        // $data['page_css'] = "inicio/inicio";
        $data['page_function_js'] = "comprobantes/function_comprobantes";

        $this->views->getView($this, "comprobantes", $data);
    }
    public function listComprobantes()
    {
        parent::verificarLogin(true);
        parent::verificarPermiso(6, true);
        $data = $this->model->listComprobantes();

        foreach ($data as $key => $value) {
            $data[$key]['options'] = '<button  data-id="' . $value['comprobantes_id'] . '" 
            data-serie="' . $value['comprobantes_serie'] . '" 
            data-descripcion="' . $value['comprobantes_descripcion'] . '" 
            data-estado="' . $value['comprobantes_estado'] . '" 
            title="Editar comprobante" 
            type="button"         class="btn btn-warning btn-sm btn_editarComprobantes"  ><i class="fa-regular fa-pen-to-square"></i></button>&nbsp;
            <button  data-id="' . $value['comprobantes_id'] . '" 
            data-serie="' . $value['comprobantes_serie'] . '" 
            data-descripcion="' . $value['comprobantes_descripcion'] . '" 
            data-estado="' . $value['comprobantes_estado'] . '" 
            title="Eliminar comprobante" 
            type="button"  class="btn_deleteCategorias btn btn-danger btn-sm"><i class="fa-solid fa-trash-can" ></i></button>';
            $data[$key]['comprobantes_estado'] = ($value['comprobantes_estado'] == 1 ? '<span class="badge bg-success">Activo</span>' : '<span class="badge bg-danger">Inactivo</span>');
            $data[$key]['numero'] = $key + 1;
        }
        json($data);
    }
    public function saveComprobantes()
    {
        parent::verificarLogin(true);
        parent::verificarPermiso(6, true);

        $response = [
            'status' => false,
            'message' => 'Error al momento de registrar los datos.',
            'isValue' => 'error'
        ];

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            json($response);
        }

        if (!isset($_POST['__add_serie']) || empty($_POST['__add_serie'])) {

            $response['message'] = "Código del numero de serie ingresado es inválido, ingrese nuevamente.";
            $response['isValue'] = "warning";

            json($response);
        }

        if (!isset($_POST['__add_descripcion']) || empty($_POST['__add_descripcion'])) {

            $response['message'] = "Descripción del comprobante ingresado es inválido, ingrese nuevamente.";
            $response['isValue'] = "warning";

            json($response);
        }

        $strSerie = strClean($_POST['__add_serie']);
        $strDescripcion = strClean($_POST['__add_descripcion']);

        // Verificamos que no exista otro categoria con este mismo codigo
        $dataCategoriaByCod = $this->model->dataComprobanteBySerie($strSerie);
        if ($dataCategoriaByCod) {
            $response['message'] = "Ya se encuentra registrado este numero de SERIE, ingrese nuevamente.";
            $response['isValue'] = "warning";
            json($response);
        }

        // Verificamos la descripcion de la categoria
        $dataCategoriaByDesc = $this->model->dataComprobanteByDescripcion($strDescripcion);
        if ($dataCategoriaByDesc) {
            $response['message'] = "Ya se encuentra registrado esta descripcion del comprobante, ingrese nuevamente.";
            $response['isValue'] = "warning";
            json($response);
        }

        // Insertamos los nuevos datos en la tabla categoria
        $saveData = $this->model->saveComprobante($strSerie, $strDescripcion);
        if (!$saveData) {
            json($response);
        }

        $response = [
            'status' => true,
            'message' => 'Comprobante : ' . strtoupper($strDescripcion) . ' registrado correctamente',
            'isValue' => 'success'
        ];

        json($response);
    }
    public function updateComprobantes()
    {
        parent::verificarLogin(true);
        parent::verificarPermiso(6, true);

        $response = [
            'status' => false,
            'message' => 'Error al momento de actualizar el registro.',
            'isValue' => 'error'
        ];

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['__edit_id']) || intval($_POST['__edit_id']) == 0) {
            json($response);
        }

        if (!isset($_POST['__edit_serie']) || empty($_POST['__edit_serie'])) {

            $response['message'] = "Código de la categoría ingresado es inválido, ingrese nuevamente.";
            $response['isValue'] = "warning";

            json($response);
        }

        if (!isset($_POST['__edit_descripcion']) || empty($_POST['__edit_descripcion'])) {

            $response['message'] = "Descripción de la categoría ingresado es inválido, ingrese nuevamente.";
            $response['isValue'] = "warning";

            json($response);
        }

        if (!isset($_POST['__edit_estado']) || !is_numeric($_POST['__edit_estado']) || (intval($_POST['__edit_estado']) !== 1 && intval($_POST['__edit_estado']) !== 0)) {

            $response['message'] = "Estado de la categoría seleccionado es inválido, seleccione nuevamente.";
            $response['isValue'] = "warning";

            json($response);
        }

        $strId = intval(strClean($_POST['__edit_id']));
        $strSerie = strClean($_POST['__edit_serie']);
        $strDescripcion = strClean($_POST['__edit_descripcion']);
        $strEstado = intval(strClean($_POST['__edit_estado']));

        // Verificamos que exista esta categoria en la DB
        $dataCategoria = $this->model->dataComprobante($strId);
        if (!$dataCategoria) {
            json($response);
        }

        // Verificamos que no exista otro categoria con este mismo codigo
        $dataComprobantesBySerie = $this->model->dataComprobanteBySerie($strSerie);
        if ($dataComprobantesBySerie && $dataComprobantesBySerie['comprobantes_serie'] !== $strSerie) {
            $response['message'] = "Ya se encuentra registrado este numero de serie, ingrese nuevamente.";
            $response['isValue'] = "warning";
            json($response);
        }

        // Verificamos la descripcion de la categoria
        $dataComprobanteByDescripcion = $this->model->dataComprobanteByDescripcion($strDescripcion);
        if ($dataComprobanteByDescripcion && $dataComprobanteByDescripcion['comprobantes_descripcion'] !== $strDescripcion) {
            $response['message'] = "Ya se encuentra registrado esta descripcion para este comrpobante, ingrese nuevamente.";
            $response['isValue'] = "warning";
            json($response);
        }

        // Actualizamos en la base de datos la categoria
        $updateData = $this->model->updateComprobante($strId, $strSerie, $strDescripcion, $strEstado);
        if (!$updateData) {
            json($response);
        }

        $response = [
            'status' => true,
            'message' => 'Registro : ' . strtoupper($strDescripcion) . ' actualizado correctamente',
            'isValue' => 'success'
        ];

        json($response);
    }
    public function deleteComprobantes()
    {
        parent::verificarLogin(true);
        parent::verificarPermiso(6, true);

        $response = [
            'status' => false,
            'message' => 'Error al momento de eliminar el registro.',
            'isValue' => 'error'
        ];

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['comprobanes_id']) || intval($_POST['comprobanes_id']) == 0) {
            json($response);
        }

        if (!isset($_POST['comprobanes_id']) || empty($_POST['comprobanes_id'])) {

            $response['message'] = "Id del comprobante ingresado es inválido, intentelo nuevamente.";
            $response['isValue'] = "warning";

            json($response);
        }

        $strId = intval(strClean($_POST['comprobanes_id']));

        // Verificamos que exista esta categoria en la DB
        $dataCategoria = $this->model->dataComprobante($strId);
        if (!$dataCategoria) {
            json($response);
        }

        //Eliminamos el registro de la base de datos
        $deleteComprobante = $this->model->deleteComprobante($strId);
        if (!$deleteComprobante) {
            json($response);
        }

        $response = [
            'status' => true,
            'message' => 'Registro Eliminado correctamente',
            'isValue' => 'success'
        ];

        json($response);
    }
}
