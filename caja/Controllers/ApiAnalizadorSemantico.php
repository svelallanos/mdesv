<?php

class ApiAnalizadorSemantico extends Controllers
{
    public function __construct($session = true)
    {
        if ($session) {
            parent::__construct();
        }
    }

    public function OracionesEntidades(string $texto = '')
    {

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://holstein.fdi.ucm.es/nlp-api/analisis?oraciones&entidades",
            CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode(array('texto' => $texto)),
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $data = json_decode($response);

        return $data;
    }

    public function sintagmaMorfologico(string $texto = '')
    {

        $curl = curl_init();
        
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://holstein.fdi.ucm.es/nlp-api/analisis?sintagmas=&morfologico=",
            CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode(array('texto' => $texto)),
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $data = json_decode($response);

        return $data;
    }

    public function sinonimos(string $palabra = '')
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://holstein.fdi.ucm.es/nlp-api/analisis/' . $palabra . '?sinonimos=',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $data = json_decode($response);
        return $data;
    }
}
