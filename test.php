<?php
require 'vendor/autoload.php';

$client = new GuzzleHttp\Client();
$res = $client->request('REFRESH', 'http://localhost');
echo $res->getStatusCode();
