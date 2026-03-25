<?php
require_once "config/config.php";
require_once "config/database.php";
require_once "utils/Router.php";

$router = new Router();

// Routes
$router->addRoute('home', 'HomeController', 'index');

// Events
$router->addRoute('events', 'EventController', 'index');
$router->addRoute('events/upcoming', 'EventController', 'upcoming');
$router->addRoute('events/past', 'EventController', 'past');
$router->addRoute('events/detail', 'EventController', 'detail');

// Trainings
$router->addRoute('trainings', 'TrainingController', 'index');
$router->addRoute('trainings/detail', 'TrainingController', 'detail');

// Services
$router->addRoute('services', 'ServiceController', 'index');
$router->addRoute('services/detail', 'ServiceController', 'detail');

// Projects
$router->addRoute('projects', 'ProjectController', 'index');
$router->addRoute('projects/detail', 'ProjectController', 'detail');

// Forum
$router->addRoute('forum', 'ForumController', 'index');

// General
$router->addRoute('about', 'GeneralController', 'about');
$router->addRoute('contact', 'GeneralController', 'contact');
$router->addRoute('faq', 'GeneralController', 'faq');
$router->addRoute('blog', 'GeneralController', 'blog');

$router->handleRequest();
?>