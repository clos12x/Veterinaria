<?php

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Routing\Router;
use Illuminate\Routing\RouteCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Route as RouteFacade;

echo "🔍 Probando carga de middleware 'cliente' desde Laravel...<br><br>";

try {
    $router = new Router(new Dispatcher());

    $router->middleware(['cliente'])->get('/cliente/dashboard', function () {
        return 'Ruta cliente cargada correctamente ✅';
    });

    $request = Request::create('/cliente/dashboard', 'GET');
    $response = $router->dispatch($request);

    echo $response->getContent();
} catch (Throwable $e) {
    echo "❌ Error capturado: <br><pre>" . $e . "</pre>";
}
