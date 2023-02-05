<?php
class Generica extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    public function generica()
    {
        parent::verificarLogin(true);
        parent::verificarPermiso(8, true);

        $data['page_id'] = 8;
        $data['page_tag'] = "MDESV - Sistema Caja";
        $data['page_title'] = ":. Generica - Sistema Caja";
        $data['page_name'] = "MDESV Sistema Caja";
        $data['page_function_js'] = "Generica/functions_generica";

        $this->views->getView($this, "generica", $data);
    }


    public function selectsGenerica()
    {
        parent::verificarLogin(true);
        parent::verificarPermiso(8, true);

        $dataCategorias = $this->model->dataAllCategorias();
        $auxDataCategorias = array();
        foreach ($dataCategorias as $key => $value) {
            $auxDataCategorias[$value['categoria_id']] = $value['categoria_descripcion'];
        }

        $dataGenerica = $this->model->dataAllGenerica();
        foreach ($dataGenerica as $key => $value) {
            $dataGenerica[$key]['numero'] = $key + 1;
            if(isset($auxDataCategorias[$value['categoria_id']])){
                $dataGenerica[$key]['categoria_descripcion'] = $auxDataCategorias[$value['categoria_id']];
            }else{
                $dataGenerica[$key]['categoria_descripcion'] ='Sin categoria';
            }

            // Agregar botones
            $dataGenerica[$key]['options'] = '<button 
            class="btn btn-info btn-sm">
            <i class="feather-edit"></i>
            </button>
            <button 
            class="btn btn-danger btn-sm ml-2">
            <i class="feather-trash-2"></i>
            </button>';

            if($value['generica_estado'] == 1)
            {
                $dataGenerica[$key]['generica_estado'] = '<span class="badge bg-success">Activo</span>';
            }else{
                $dataGenerica[$key]['generica_estado'] = '<span class="badge bg-danger">Inactivo</span>';
            }
            
        }

        json($dataGenerica);
    }
}
