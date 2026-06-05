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
    'forum/suspended' => ['AuthController', 'suspended'],
    'forum/request-review' => ['AuthController', 'requestReview'],
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

    // Admin Routes
    'admin/login' => ['AdminController', 'login'],
    'admin/logout' => ['AdminController', 'logout'],
    'admin/dashboard' => ['AdminController', 'dashboard'],
    'admin/services' => ['AdminController', 'services'],
    'admin/projects' => ['AdminController', 'projects'],
    'admin/events' => ['AdminController', 'events'],
    'admin/trainings' => ['AdminController', 'trainings'],
    'admin/blog' => ['AdminController', 'blog'],
    'admin/members' => ['AdminController', 'members'],
    'admin/applications' => ['AdminController', 'applications'],
    'admin/faq' => ['AdminController', 'faq'],
    'admin/testimonials' => ['AdminController', 'testimonials'],
    'admin/banners' => ['AdminController', 'banners'],
    'admin/settings' => ['AdminController', 'settings'],
    'admin/settings/update-profile' => ['AdminController', 'updateProfile'],
    'admin/settings/update-social' => ['AdminController', 'updateSocialLinks'],
    'admin/delete' => ['AdminController', 'deleteRecord'],
    'admin/store' => ['AdminController', 'storeRecord'],
    'admin/members/details/{id}' => ['AdminController', 'memberDetails'],
    'admin/members/toggle-status' => ['AdminController', 'toggleMemberStatus'],
    'admin/notifications' => ['AdminController', 'getNotifications'],
    'admin/notifications/mark-read' => ['AdminController', 'markNotificationRead'],

    // Module Specific Form Routes
    'admin/services/add' => ['AdminController', 'addService'],
    'admin/services/edit/{id}' => ['AdminController', 'editService'],
    'admin/projects/add' => ['AdminController', 'addProject'],
    'admin/projects/edit/{id}' => ['AdminController', 'editProject'],
    'admin/events/add' => ['AdminController', 'addEvent'],
    'admin/events/edit/{id}' => ['AdminController', 'editEvent'],
    'admin/trainings/add' => ['AdminController', 'addTraining'],
    'admin/trainings/edit/{id}' => ['AdminController', 'editTraining'],
    'admin/blog/add' => ['AdminController', 'addBlog'],
    'admin/blog/edit/{id}' => ['AdminController', 'editBlog'],
    'admin/banners/add' => ['AdminController', 'addBanner'],
    'admin/banners/edit/{id}' => ['AdminController', 'editBanner'],
    'admin/faq/add' => ['AdminController', 'addFAQ'],
    'admin/faq/edit/{id}' => ['AdminController', 'editFAQ'],
    'admin/testimonials/add' => ['AdminController', 'addTestimonial'],
    'admin/testimonials/edit/{id}' => ['AdminController', 'editTestimonial'],
];

foreach ($routes as $path => $route) {
    $router->addRoute($path, $route[0], $route[1]);
}

$router->handleRequest();
