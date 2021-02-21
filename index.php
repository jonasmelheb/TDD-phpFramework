<?php

use Twitter\Controller\HelloController;
use Twitter\Http\Response;

require_once __DIR__ . '/vendor/autoload.php';


$controller = new HelloController;

$response = $controller->hello();

$response->send();
