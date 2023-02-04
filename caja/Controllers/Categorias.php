<?php

class Categorias extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    public function categorias()
    {
        parent::verificarLogin(true);

        $data['page_id'] = 34;
        $data['page_tag'] = "MDESV - Sistema Caja";
        $data['page_title'] = ":. Categorias - Sistema Caja";
        $data['page_name'] = "MDESV Sistema Caja";
        // $data['page_css'] = "inicio/inicio";
        $data['page_function_js'] = "categorias/function_categorias";

        $this->views->getView($this, "categorias", $data);
    }

    public function selectsCategorias()
    {
        parent::verificarLogin(true);

        $dataCategorias = $this->model->dataAllCategorias();
        foreach ($dataCategorias as $key => $value) {
            if ($value['categoria_estado'] == 1) {
                $dataCategorias[$key]['categoria_estadoD'] = '<span class="badge bg-success fw-bold">Activo</span>';
            } else {
                $dataCategorias[$key]['categoria_estadoD'] = '<span class="badge bg-danger fw-bold">Inactivo</span>';
            }

            $dataCategorias[$key]['numero'] = $key + 1;
            $dataCategorias[$key]['options'] = '
            <button 
            data-id="' . $value['categoria_id'] . '" 
            data-codigo="' . $value['categoria_cod'] . '" 
            data-descripcion="' . $value['categoria_descripcion'] . '" 
            data-estado="' . $value['categoria_estado'] . '" 
            title="Editar categorias" 
            type="button" 
            class="btn btn-info btn-sm btn_editarCategorias">
            <i class="feather-edit"></i>
            </button>';
        }
        json($dataCategorias);
    }

    public function updateCategorias()
    {
        parent::verificarLogin(true);

        $response = [
            'status' => false,
            'message' => 'Error al momento de actualizar el registro.',
            'isValue' => 'error'
        ];

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['__edit_id']) || intval($_POST['__edit_id']) == 0) {
            json($response);
        }

        if (!isset($_POST['__edit_codigo']) || empty($_POST['__edit_codigo'])) {

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
        $strCodigo = strClean($_POST['__edit_codigo']);
        $strDescripcion = strClean($_POST['__edit_descripcion']);
        $strEstado = intval(strClean($_POST['__edit_estado']));

        // Verificamos que exista esta categoria en la DB
        $dataCategoria = $this->model->dataCategoria($strId);
        if (!$dataCategoria) {
            json($response);
        }

        // Verificamos que no exista otro categoria con este mismo codigo
        $dataCategoriaByCod = $this->model->dataCategoriaByCod($strCodigo);
        if ($dataCategoriaByCod && $dataCategoriaByCod['categoria_cod'] !== $strCodigo) {
            $response['message'] = "Ya se encuentra registrado este código, ingrese nuevamente.";
            $response['isValue'] = "warning";
            json($response);
        }

        // Verificamos la descripcion de la categoria
        $dataCategoriaByDesc = $this->model->dataCategoriaByDesc($strDescripcion);
        if ($dataCategoriaByDesc && $dataCategoriaByDesc['categoria_descripcion'] !== $strDescripcion) {
            $response['message'] = "Ya se encuentra registrado esta descripcion de la categoría, ingrese nuevamente.";
            $response['isValue'] = "warning";
            json($response);
        }

        // Actualizamos en la base de datos la categoria
        $updateData = $this->model->updateCatogoria($strId, $strCodigo, $strDescripcion, $strEstado);
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

    public function saveCategorias() {
        parent::verificarLogin(true);

        $response = [
            'status' => false,
            'message' => 'Error al momento de registrar los datos.',
            'isValue' => 'error'
        ];

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            json($response);
        }

        if (!isset($_POST['__add_codigo']) || empty($_POST['__add_codigo'])) {

            $response['message'] = "Código de la categoría ingresado es inválido, ingrese nuevamente.";
            $response['isValue'] = "warning";

            json($response);
        }

        if (!isset($_POST['__add_descripcion']) || empty($_POST['__add_descripcion'])) {

            $response['message'] = "Descripción de la categoría ingresado es inválido, ingrese nuevamente.";
            $response['isValue'] = "warning";

            json($response);
        }

        $strCodigo = strClean($_POST['__add_codigo']);
        $strDescripcion = strClean($_POST['__add_descripcion']);

        // Verificamos que no exista otro categoria con este mismo codigo
        $dataCategoriaByCod = $this->model->dataCategoriaByCod($strCodigo);
        if ($dataCategoriaByCod) {
            $response['message'] = "Ya se encuentra registrado este código, ingrese nuevamente.";
            $response['isValue'] = "warning";
            json($response);
        }

        // Verificamos la descripcion de la categoria
        $dataCategoriaByDesc = $this->model->dataCategoriaByDesc($strDescripcion);
        if ($dataCategoriaByDesc) {
            $response['message'] = "Ya se encuentra registrado esta descripcion de la categoría, ingrese nuevamente.";
            $response['isValue'] = "warning";
            json($response);
        }

        // Insertamos los nuevos datos en la tabla categoria
        $saveData = $this->model->saveCatogoria($strCodigo, $strDescripcion);
        if (!$saveData) {
            json($response);
        }

        $response = [
            'status' => true,
            'message' => 'Categoría : ' . strtoupper($strDescripcion) . ' registrado correctamente',
            'isValue' => 'success'
        ];

        json($response);
    }
}
