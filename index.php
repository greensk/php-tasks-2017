<?php
$key = substr($_SERVER['REQUEST_URI'], 1);
$key = str_replace('..', '', $key);
$key = str_replace('.json', '', $key);

$filename = "${key}/data.php";


if (!file_exists($filename)) {
  die('File not found');
}
require($filename);
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');

$data = array_map(
  function ($record) use ($key) {
    if (isset($record['mainPhoto']['url'])) {
      $record['mainPhoto']['url'] = "/${key}/" . $record['mainPhoto']['url'];
    }
    return $record;
  },  
  $data
);

echo json_encode($data, JSON_UNESCAPED_UNICODE);
