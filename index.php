<?php
session_start();
require_once "config/config.php";
require_once "config/database.php";
require_once "utils/Router.php";
require_once "utils/CSRF.php";
require_once "utils/Utils.php";

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
    'trainings/register' => ['TrainingController', 'register'],
    'trainings/submit' => ['TrainingController', 'submit'],
    'services' => ['ServiceController', 'index'],
    'services/detail' => ['ServiceController', 'detail'],
    'projects' => ['ProjectController', 'index'],
    'projects/detail' => ['ProjectController', 'detail'],
    'forum' => ['ForumController', 'index'],
    'forum/feed' => ['ForumController', 'feed'],
    'forum/new-topic' => ['ForumController', 'newTopic'],
    'forum/discussion' => ['ForumController', 'discussion'],
    'forum/profile' => ['ForumController', 'profile'],
    'forum/updateProfile' => ['ForumController', 'updateProfile'],
    'forum/sign-in' => ['AuthController', 'signIn'],
    'forum/sign-up' => ['AuthController', 'signUp'],
    'forum/logout' => ['AuthController', 'logout'],
    'forum/verify' => ['VerificationController', 'verify'],
    'forum/terms' => ['TermsController', 'index'],
    'forum/terms/accept' => ['TermsController', 'accept'],
    'forum/feed/like' => ['FeedController', 'like'],
    'forum/feed/reply' => ['FeedController', 'reply'],
    'forum/feed/store' => ['FeedController', 'store'],
    'forum/feed/fetch' => ['FeedController', 'fetch'],
    'forum/feed/upload' => ['FeedController', 'uploadImage'],
    'forum/feed/like-reply' => ['FeedController', 'likeReply'],
    'about' => ['GeneralController', 'about'],
    'contact' => ['GeneralController', 'contact'],
    'faq' => ['GeneralController', 'faq'],
    'blog' => ['BlogController', 'index'],
    'blog/{slug}' => ['BlogController', 'detail'],
    // Password reset routes
    'forum/forgot-password' => ['PasswordResetController', 'forgotPassword'],
    'forum/verify-reset-code' => ['PasswordResetController', 'verifyResetCode'],
    'forum/reset-password' => ['PasswordResetController', 'resetPassword'],
];

foreach ($routes as $path => $route) {
    $router->addRoute($path, $route[0], $route[1]);
}

$router->handleRequest();
