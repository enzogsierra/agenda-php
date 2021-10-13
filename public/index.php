<?php
require_once __DIR__ . "/../include.php";

use MVC\Router;
use Controllers\PublicController;

$router = new Router();
$router->get("/", [PublicController::class, "index"]);
$router->post("/crear", [PublicController::class, "crear"]);
$router->post("/editar", [PublicController::class, "editar"]);
$router->post("/eliminar", [PublicController::class, "eliminar"]);

$router->checkRoutes();