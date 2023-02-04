<?php

class ApiRest extends Controllers
{
  public function __construct($session = true)
  {
    if ($session) {
      parent::__construct();
    }
  }

  public function apiDni(string $dni = '')
  {
    $return = array(
      'status' => false,
      'msg' => 'Error al momento de consultar los datos del DNI.',
      'value' => 'error',
      'data' => null
    );

    // $curl = curl_init();
    // curl_setopt_array($curl, array(
    //   CURLOPT_URL => 'https://apiperu.dev/api/dni/' . $dni . '?api_token=06b35b126ec469bf606d0d9eaff4d6b597d220425efba2b673680abf6d137865',
    //   CURLOPT_RETURNTRANSFER => true,
    //   CURLOPT_CUSTOMREQUEST => "GET",
    //   CURLOPT_SSL_VERIFYPEER => false
    // ));
    // $response = curl_exec($curl);
    // $err = curl_error($curl);
    // curl_close($curl);

    // $persona = json_decode($response);+
    // json($persona);

    // Iniciar llamada a API *****************   1   ******************
    $curl = curl_init();

    // Buscar dni
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.apis.net.pe/v1/dni?numero=' . $dni,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 2,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'Referer: https://apis.net.pe/consulta-dni-api',
        'Authorization: Bearer apis-token-1.aTSI1U7KEuT-6bbbCguH-4Y8TI6KS73N'
      ),
    ));

    $response = curl_exec($curl);
    // Datos listos para usar
    $persona = json_decode($response);

    if (isset($persona->error)) {
      $return['msg'] = 'Error, el número de DNI es inválido.';
      $return['value'] = 'warning';

      return $return;
    }

    $auxConsultaDatos = array();

    if (!is_null($persona)) {
      $auxConsultaDatos['nombres'] = $persona->nombres;
      $auxConsultaDatos['apellido_paterno'] = $persona->apellidoPaterno;
      $auxConsultaDatos['apellido_materno'] = $persona->apellidoMaterno;
      $auxConsultaDatos['nombre_completo'] = ucwords(strtolower($persona->nombres)) . ', ' . strtoupper($persona->apellidoPaterno) . ' ' . strtoupper($persona->apellidoMaterno);
      $auxConsultaDatos['dni'] = $persona->numeroDocumento;

      $return['status'] = true;
      $return['msg'] = 'Lista de datos';
      $return['value'] = 'success';
      $return['data'] = $auxConsultaDatos;

      return $return;
    }

    // Iniciar el segundo llamado a API *****************   2   ******************

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.apis.net.pe/v1/dni?numero=' . $dni,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    $persona = json_decode($response, true);

    if (isset($persona['error'])) {
      $return['msg'] = 'Error, el número de DNI es inválido.';
      $return['value'] = 'warning';
      return $return;
    }

    $auxConsultaDatos = array();

    if (!is_null($persona)) {
      $auxConsultaDatos['nombres'] = $persona['nombres'];
      $auxConsultaDatos['apellido_paterno'] = $persona['apellidoPaterno'];
      $auxConsultaDatos['apellido_materno'] = $persona['apellidoMaterno'];
      $auxConsultaDatos['nombre_completo'] = ucwords(strtolower($persona['nombres'])) . ', ' . strtoupper($persona['apellidoPaterno']) . ' ' . strtoupper($persona['apellidoMaterno']);
      $auxConsultaDatos['dni'] = $persona['numeroDocumento'];

      $return['status'] = true;
      $return['msg'] = 'Lista de datos';
      $return['value'] = 'success';
      $return['data'] = $auxConsultaDatos;

      return $return;
    }

    // Iniciar el tercer llamado a API *****************   3   ******************

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://dniruc.apisperu.com/api/v1/dni/' . $dni . '?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6Imluc3RpdHV0b3Nhbmx1Y2FzMDdAZ21haWwuY29tIn0.niJAVTb58022JPOz8qQuTxwgZtHX0Pn7NrYY5LGI9Ms',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer WVGLGZ3zf6PclcJ3yqF4OgqF6ROnN3ZGT1GJct1o'
      ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    $persona = json_decode($response, true);

    if (is_null($persona)) {
      $return['msg'] = 'Error, el número de DNI es inválido.';
      $return['value'] = 'warning';
      return $return;
    }

    $auxConsultaDatos = array();

    if (isset($persona['dni'])) {
      $auxConsultaDatos['nombres'] = $persona['nombres'];
      $auxConsultaDatos['apellido_paterno'] = $persona['apellidoPaterno'];
      $auxConsultaDatos['apellido_materno'] = $persona['apellidoMaterno'];
      $auxConsultaDatos['nombre_completo'] = ucwords(strtolower($persona['nombres'])) . ', ' . strtoupper($persona['apellidoPaterno']) . ' ' . strtoupper($persona['apellidoMaterno']);
      $auxConsultaDatos['dni'] = $persona['dni'];

      $return['status'] = true;
      $return['msg'] = 'Lista de datos';
      $return['value'] = 'success';
      $return['data'] = $auxConsultaDatos;
    }

    return $return;
  }

  public function apiDniJson(string $dni = '')
  {
    json($this->apiDni($dni));
  }

  public function apiRuc(string $ruc = '')
  {
    $arrayReturn = array('status' => false, 'data' => null);

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.apis.net.pe/v1/ruc?numero=' . $ruc,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    $response = json_decode($response, true);

    if ($response != "Too Many Requests") {
      if (isset($response['numeroDocumento'])) {
        $arrayReturn['status'] = true;
        $arrayReturn['data']['ruc'] = $response['numeroDocumento'];
        $arrayReturn['data']['nombre'] = $response['nombre'];
        $arrayReturn['data']['direccion'] = $response['direccion'] . ' ' . $response['departamento'] . ' ' . $response['provincia'] . ' ' . $response['distrito'];
        $arrayReturn['data']['direccion_nocomplete'] = ($response['direccion'] == '-') ? '' : $response['direccion'];
        $arrayReturn['data']['distrito'] = $response['distrito'];
        $arrayReturn['data']['provincia'] = $response['provincia'];
        $arrayReturn['data']['departamento'] = $response['departamento'];
        $arrayReturn['data']['ubigeo'] = ($response['ubigeo'] == '-') ? '' : $response['ubigeo'];
        $arrayReturn['data']['estado'] = $response['estado'];
        $arrayReturn['data']['condicion'] = $response['condicion'];

        $arrayReturn['data']['direccion'] = trim($arrayReturn['data']['direccion']);
        $arrayReturn['data']['direccion'] = ($arrayReturn['data']['direccion'] == '-') ? '' : $arrayReturn['data']['direccion'];
      }

      return $arrayReturn;
    } else {
      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://dniruc.apisperu.com/api/v1/ruc/' . $ruc . '?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6Imluc3RpdHV0b3Nhbmx1Y2FzMDdAZ21haWwuY29tIn0.niJAVTb58022JPOz8qQuTxwgZtHX0Pn7NrYY5LGI9Ms',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
          'Authorization: Bearer WVGLGZ3zf6PclcJ3yqF4OgqF6ROnN3ZGT1GJct1o'
        ),
      ));

      $response = curl_exec($curl);
      curl_close($curl);
      $response = json_decode($response, true);

      if (isset($response['ruc'])) {
        $arrayReturn['status'] = true;
        $arrayReturn['data']['ruc'] = $response['ruc'];
        $arrayReturn['data']['nombre'] = $response['razonSocial'];
        $arrayReturn['data']['direccion'] = (is_null($response['direccion'])) ? '' : $response['direccion'];
        $arrayReturn['data']['direccion_nocomplete'] = '';
        $arrayReturn['data']['distrito'] = (is_null($response['distrito'])) ? '' : $response['distrito'];
        $arrayReturn['data']['provincia'] = (is_null($response['provincia'])) ? '' : $response['provincia'];
        $arrayReturn['data']['departamento'] = (is_null($response['departamento'])) ? '' : $response['departamento'];
        $arrayReturn['data']['ubigeo'] = (is_null($response['ubigeo'])) ? '' : $response['ubigeo'];
        $arrayReturn['data']['estado'] = $response['estado'];
        $arrayReturn['data']['condicion'] = $response['condicion'];
      }

      return $arrayReturn;
    }
  }

  public function apiRucJson(string $ruc = '')
  { 
    json($this->apiRuc($ruc));
  }
}
