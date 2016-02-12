<?php

/*
|--------------------------------------------------------------------------
| Turn On The Lights
|--------------------------------------------------------------------------
|
| We need to silex, so let's turn on the lights.
| This bootstraps the framework and gets it ready for use, then it
| will load up this application so that we can run it and send
| the responses back to the browser and delight these users.
|
*/
$app = new Silex\Application();

/*
|---------------------------------------------------------------
| DEFAULT INI SETTINGS
|---------------------------------------------------------------
|
| Hosts have a habbit of setting stupid settings for various
| things. These settings should help provide maximum compatibility
| for Brainwave
|
*/

// Let's hold Windows' hand and set a include_path in case it forgot
set_include_path(dirname(__FILE__));

// Some hosts (was it GoDaddy? complained without this
@ini_set('cgi.fix_pathinfo', 0);

mb_internal_encoding('UTF-8');

/*
|--------------------------------------------------------------------------
| Register all needed Service Provider
|--------------------------------------------------------------------------
|
| Here we will set tall service provider for silex.
|
*/
$app['debug'] = true;
$app->register(new App\Providers\Whoops\WhoopsServiceProvider());

$app->register(new Silex\Provider\TwigServiceProvider(), [
    'twig.path' => __DIR__.'/../app/Views',
]);

/*
|--------------------------------------------------------------------------
| Set The Routes
|--------------------------------------------------------------------------
|
| Here we will set the default routes for silex.
|
*/

require_once __DIR__ . '/../app/Http/routes.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can simply call the run method,
| which will execute the request and send the response back to
| the client's browser allowing them to enjoy the creative
| and wonderful applications we have created for them.
|
*/

return $app;
