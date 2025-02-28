<?php
if (!$_REQUEST['provider']) {
  http_response_code(400);
  die(json_encode([
    "message" => "The following required query string data is missing : provider",
    "code" => 400,
    "data" => null
  ]));
}

function fetch($url)
{
  if (empty($url))
    throw new Exception("The url must not be empty.", 400);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_NOBODY, 0);
  curl_setopt($ch, CURLOPT_TIMEOUT, 10);
  $resp = curl_exec($ch);
  curl_close($ch);
  return $resp;
}

try {
  $data = null;

  if ($_REQUEST['provider'] == "tmd") {
    $resp = fetch("https://earthquake.tmd.go.th/feed/rss_tmd.xml");
    $replacement = [
      'lat' => '/geo:lat/',
      'long' => '/geo:long/',
      'depth' => '/tmd:depth/',
      'magnitude' => '/tmd:magnitude/',
      'time' => '/tmd:time/'
    ];
    foreach ($replacement as $rpm => $pattern) {
      $resp = preg_replace($pattern, $rpm, $resp);
    }
    $data = simplexml_load_string($resp);
  } else if ($_REQUEST['provider'] == "usgs") {
    $resp = fetch("https://earthquake.usgs.gov/earthquakes/feed/v1.0/summary/all_day.geojson");
    $data = json_decode($resp);
  } else {
    $resp = fetch("https://geofon.gfz-potsdam.de/eqinfo/list.php?fmt=rss");
    $data = simplexml_load_string($resp);
  }

  echo json_encode([
    "message" => "OK",
    "data" => $data,
    "code" => 200
  ]);
} catch (Exception $e) {
  die(json_encode([
    "message" => $e->getMessage(),
    "code" => $e->getCode(),
    "data" => null
  ]));
}
