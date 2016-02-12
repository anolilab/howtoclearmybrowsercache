<?php

$app->get('/', 'App\\Http\\Controllers\\HomeController::render');
$app->get('impressum', 'App\\Http\\Controllers\\ImpressumController::render');
