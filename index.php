<?php
require_once "config/config.php";
require_once "config/database.php";
require_once "utils/Router.php";

$router = new Router();

// Define mapping
$routes = [
    'home' => ['HomeController', 'index'],
    '' => ['HomeController', 'index'],
    'events' => ['EventController', 'index'],
    'events/upcoming' => ['EventController', 'upcoming'],
    'events/past' => ['EventController', 'past'],
    'events/detail' => ['EventController', 'detail'],
    'trainings' => ['TrainingController', 'index'],
    'trainings/detail' => ['TrainingController', 'detail'],
    'services' => ['ServiceController', 'index'],
    'services/detail' => ['ServiceController', 'detail'],
    'projects' => ['ProjectController', 'index'],
    'projects/detail' => ['ProjectController', 'detail'],
    'forum' => ['ForumController', 'index'],
    'about' => ['GeneralController', 'about'],
    'contact' => ['GeneralController', 'contact'],
    'faq' => ['GeneralController', 'faq'],
    'blog' => ['GeneralController', 'blog']
];

foreach ($routes as $path => $route) {
    $router->addRoute($path, $route[0], $route[1]);
}

$router->handleRequest();
?>