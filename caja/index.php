<?php
define('WHERE_I_AM', 'BIBLIOTECA');

require_once("Config/Config.php");
require_once("Helpers/fileRequired.php");
require_once("Helpers/Helpers.php");

$url = !empty($_GET['url']) ? $_GET['url'] : 'inicio';
$arrUrl = explode("/", $url);

$controller = $arrUrl[0];
$methop = $arrUrl[0];
$params = "";

if (!empty($arrUrl[1])) {
  if ($arrUrl[1] != "") {
    $methop = $arrUrl[1];
  }
}

if (isset($arrUrl[2])) {
  if ($arrUrl[2] != "") {
    for ($i = 2; $i < count($arrUrl); $i++) {
      $params .= $arrUrl[$i] . ',';
    }
    $params = trim($params, ",");
  }
}

require_once("Libraries/Core/Autoload.php");
require_once("Libraries/Core/Load.php");