<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Allow from any origin
if(isset($_SERVER["HTTP_ORIGIN"]))
{
    // You can decide if the origin in $_SERVER['HTTP_ORIGIN'] is something you want to allow, or as we do here, just allow all
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
}
else
{
    //No HTTP_ORIGIN set, so we allow any. You can disallow if needed here
    header("Access-Control-Allow-Origin: *");
}

header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 600");    // cache for 10 minutes

if($_SERVER["REQUEST_METHOD"] == "OPTIONS")
{
    if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_METHOD"]))
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT"); //Make sure you remove those you do not want to support

    if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_HEADERS"]))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    //Just exit with 200 OK with the above headers for OPTIONS method
    exit(0);
}
//Autoload
$loader = require 'vendor/autoload.php';

//Instanciando objeto
$app = new \Slim\Slim(array(
    'templates.path' => 'templates'
));

//Listando todas
$app->get('/receitas/', function() use ($app){
	(new \controllers\Receita($app))->lista();
});

//get receita
$app->get('/receita/:id', function($id) use ($app){
	(new \controllers\Receita($app))->get($id);
});

//get receita por id ingredientes
$app->get('/receita/ingredientes/:id+', function($ids) use ($app){
    (new \controllers\Receita($app))->getReceitaIngrediente($ids);
});

//get categorias
$app->get('/categorias/', function() use ($app){
    (new \controllers\Categoria($app))->lista();
});

//get ingredientes por categoria
$app->get('/ingredientes/categoria/:id', function($id) use ($app){
    (new \controllers\Categoria($app))->get($id);
});

//get todos ingredientes
$app->get('/ingredientes/', function() use ($app){
    (new \controllers\Ingrediente($app))->lista();
});

//get ingrediente
$app->get('/ingrediente/:id', function($id) use ($app){
    (new \controllers\Ingrediente($app))->get($id);
});



//Rodando aplicação
$app->run();
