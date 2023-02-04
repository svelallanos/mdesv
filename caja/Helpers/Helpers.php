<?php

function base_url()
{
  return BASE_URL;
}

function media()
{
  return BASE_URL . "Assets";
}

function getPathFotoPerfil()
{
  return PATH_FOTOPERFIL;
}

function getPathFotoAutor()
{
  return PATH_FOTOAUTOR;
}

function getPathFotoLibro()
{
  return PATH_FOTOLIBRO;
}

function headerAdmin($data = "")
{
  $view_header = "Views/Template/header_admin.php";
  require_once($view_header);
}
function footerAdmin($data = "")
{
  $view_footer = "Views/Template/footer_admin.php";
  require_once($view_footer);
}

function getModal(string $nameModal, $data)
{
  $view_modal = "Views/Template/Modals/{$nameModal}.php";
  require_once($view_modal);
}

function runPageNofound()
{
  $notFound = new Errors();
  $notFound->notFound();
  die;
}

function verificarPermiso(array $data, int $id)
{
  if (isset($data['permisosUser'][$id])) {
    return true;
  } else {
    return false;
  }
}

function json($var = false)
{
  echo json_encode($var, JSON_UNESCAPED_UNICODE);
  die;
}

function location($var = '', bool $caja = true)
{
  if ($caja) {
    header('Location: ' . base_url() . $var);
  }
  // else {
  //     header('Location: ' . url_sanlucas() . $var);
  // }

  die;
}

function getExtension(string $name)
{
  $name = explode('.', $name);
  $count = count($name);

  if ($count > 1) {
    return $name[$count - 1];
  } else {
    return false;
  }
}

function getExtFotos()
{
  $ext_type = array('gif', 'jpg', 'jpe', 'jpeg', 'png');
  return $ext_type;
}

function getVerion()
{
  return VER_MEDIA;
}

function deleteEspacios(string $cadena = '')
{
  $outputString = preg_replace('/\s+/', '', $cadena);
  return $outputString;
}
// Recortar texto
function recortar_cadena($texto, $limite = 100)
{
  $texto = trim($texto);
  $texto = strip_tags($texto);
  $tamano = strlen($texto);
  $resultado = '';
  if ($tamano <= $limite) {
    return $texto;
  } else {
    $texto = substr($texto, 0, $limite);
    $palabras = explode(' ', $texto);
    $resultado = implode(' ', $palabras);
    $resultado .= '...';
  }
  return $resultado;
}

function convertMayuscular(string $string)
{
  $string = mb_strtoupper($string);
  $string = str_replace('á', 'Á', $string);
  $string = str_replace('é', 'É', $string);
  $string = str_replace('í', 'Í', $string);
  $string = str_replace('ó', 'Ó', $string);
  $string = str_replace('ú', 'Ú', $string);
  $string = str_replace('ñ', 'Ñ', $string);
  return $string;
}

function convertMinusculas(string $string)
{
  $string = strtolower($string);
  $string = str_replace('Á', 'á', $string);
  $string = str_replace('É', 'é', $string);
  $string = str_replace('Í', 'í', $string);
  $string = str_replace('Ó', 'ó', $string);
  $string = str_replace('Ú', 'ú', $string);
  $string = str_replace('Ñ', 'ñ', $string);
  return $string;
}

function convertCapital(string $string)
{
  $string = trim(convertMinusculas($string));

  $auxValor = explode(' ', $string);
  $string = '';

  foreach ($auxValor as $llave => $valor) {

    $valor = trim($valor);
    if ($valor != '') {
      $valor[0] = convertMayuscular($valor[0]);
      $string .= $valor . ' ';
    }
  }
  $string = trim($string);

  return $string;
}

function validarPassword(string $string)
{
  $string = trim($string);
  $minusculas = 'qwertyuiopasdfghjklzxcvbnmñáéíóú';
  $mayusculas = 'QWERTYUIOPASDFGHJKLZXCVBNMÑÁÉÍÓÚ';
  $simbolos = '*-+.#$&%=_';
  $numeros = '0123456789';
  $numMin = 32;
  $numMay = 32;
  $numSim = strlen($simbolos);
  $numNum = 10;

  $countString = strlen($string);
  $validaForPass = array(false, false);
  $arrayReturn = array(false, 'La contraseña no puede ser vacia.');

  if ($countString == 0) {
    return $arrayReturn;
  }

  if ($countString < 5) {
    return array(false, 'Las contraseñas deben de tener al menos 5 caracteres.');;
  }

  $letraValido = false;
  for ($i = 0; $i < $countString; $i++) {
    $letraValido = false;
    for ($index = 0; $index < $numMin; $index++) {
      if ($string[$i] == $minusculas[$index]) {
        $letraValido = true;
        $validaForPass[0] = true;
        break;
      }
    }

    if (!$letraValido) {
      for ($index = 0; $index < $numMay; $index++) {
        if ($string[$i] == $mayusculas[$index]) {
          $letraValido = true;
          $validaForPass[0] = true;
          break;
        }
      }
    }

    if (!$letraValido) {
      for ($index = 0; $index < $numSim; $index++) {
        if ($string[$i] == $simbolos[$index]) {
          $letraValido = true;
          break;
        }
      }
    }

    if (!$letraValido) {
      for ($index = 0; $index < $numNum; $index++) {
        if ($string[$i] == $numeros[$index]) {
          $letraValido = true;
          $validaForPass[1] = true;
          break;
        }
      }
    }

    if (!$letraValido) {
      break;
    }
  }

  if ($letraValido && $validaForPass[0] == false && $validaForPass[1] == false) {
    $arrayReturn = array(false, 'La contraseña debe tener al menos una letra y un número.');
  } elseif ($letraValido && $validaForPass[0] == true && $validaForPass[1] == false) {
    $arrayReturn = array(false, 'La contraseña debe tener al menos un número.');
  } elseif ($letraValido && $validaForPass[0] == false && $validaForPass[1] == true) {
    $arrayReturn = array(false, 'La contraseña debe tener al menos una letra.');
  } elseif (!$letraValido) {
    $arrayReturn = array(false, 'La contraseña solo puede estar formada por letras mayúsculas, minúsculas, números y los siguientes símbolos ( * - + . # $ & % = _ ).');
  } elseif ($letraValido && $validaForPass[0] == true && $validaForPass[1] == true) {
    $arrayReturn = array(true, 'Contraseña valida.');
  }

  return $arrayReturn;
}

function strClean($strCadena)
{
  $string = preg_replace(['/\s+/', '/^\s|\s$/'], [' ', ''], $strCadena);
  $string = trim($string); //Elimina espacios en blanco al inicio y al final
  $string = stripslashes($string); //Elimina las \ invertidas 
  $string = str_ireplace("<script>", "", $string);
  $string = str_ireplace("</script>", "", $string);
  $string = str_ireplace("<script src>", "", $string);
  $string = str_ireplace("<script type=>", "", $string);
  $string = str_ireplace("SELECT * FROM ", "", $string);
  $string = str_ireplace("DELETE FROM", "", $string);
  $string = str_ireplace("INSERT INTO", "", $string);
  $string = str_ireplace("SELECT COUNT(*) FROM", "", $string);
  $string = str_ireplace("SELECT ", "", $string);
  $string = str_ireplace("DROP TABLE", "", $string);
  $string = str_ireplace("OR '1' = '1", "", $string);
  $string = str_ireplace('OR "1" = "1"', "", $string);
  $string = str_ireplace('OR ´1´ = ´1´', "", $string);
  $string = str_ireplace("is NULL; --", "", $string);
  $string = str_ireplace("is NULL; --", "", $string);
  $string = str_ireplace("LIKE '", "", $string);
  $string = str_ireplace('LIKE "', "", $string);
  $string = str_ireplace("LIKE ´", "", $string);
  $string = str_ireplace("OR 'a' = 'a", "", $string);
  $string = str_ireplace('OR "a" = "1"', "", $string);
  $string = str_ireplace("OR ´a´ = ´a", "", $string);
  $string = str_ireplace("OR ´a´ = ´a´", "", $string);
  $string = str_ireplace("--", "", $string);
  $string = str_ireplace("^", "", $string);
  $string = str_ireplace("[", "", $string);
  $string = str_ireplace("]", "", $string);
  $string = str_ireplace("==", "", $string);
  $string = str_ireplace("<", "", $string);
  $string = str_ireplace(">", "", $string);

  return $string;
}

function quitarTildes(string $string)
{
  $string = str_replace('á', 'a', $string);
  $string = str_replace('é', 'e', $string);
  $string = str_replace('í', 'i', $string);
  $string = str_replace('ó', 'o', $string);
  $string = str_replace('ú', 'u', $string);
  $string = str_replace('Á', 'A', $string);
  $string = str_replace('É', 'E', $string);
  $string = str_replace('Í', 'I', $string);
  $string = str_replace('Ó', 'O', $string);
  $string = str_replace('Ú', 'U', $string);
  return $string;
}
