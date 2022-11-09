<?php
require_once './libs/Router.php';
require_once './app/controllers/clothes-api.controller.php';

// crea el router
$router = new Router();

// defina la tabla de ruteo
$router->addRoute('clothes', 'GET', 'clothesApiController', 'getClothes');
$router->addRoute('clothes/:ID', 'GET', 'clothesApiController', 'getCloth');
$router->addRoute('clothes/:ID', 'DELETE', 'clothesApiController', 'deleteClothes');
$router->addRoute('clothes', 'POST', 'clothesApiController', 'insertClothes'); 




// ejecuta la ruta (sea cual sea)
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);