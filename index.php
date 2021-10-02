<?php

require __DIR__ . '/vendor/autoload.php';
$app = new Slim\App;
$container = $app->getContainer();

$container['view'] = function($container) {
    $view = new \Slim\Views\Twig(__DIR__. '/views', [
        'cache' => false
    ]);

    //Instantiate and add Slim spesific extension
    $router = $container->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));

    return $view;
};

require_once __DIR__.'/routes.php';


$json_string = file_get_contents("./views/assets/js/config.json");
$config = json_decode($json_string);

echo $twig->render('home.twig', ['config' => $config] );


$app->get('/hosting/{slug}/{user}', function($request, $response, $params){
    return 'Halo ' .$params['user'] . ' selamat datang di ' .$params['slug'];
});

$app->run();
?>