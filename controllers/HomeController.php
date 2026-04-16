<?php
require_once "controllers/BaseController.php";
require_once "models/HomeModel.php";

class HomeController extends BaseController {
    public function index() {
        $model = new HomeModel($this->db);
        $data = [
            'contact' => $model->getContactDetails(),
            'banners' => $model->getBanners(),
            'about' => $model->getAboutInfo(),
            'services' => $model->getServices(),
            'projects' => $model->getProjects(),
            'upcoming_events' => $model->getUpcomingEvents(),
            'latest_events' => $model->getLatestEvents(),
            'testimonials' => $model->getTestimonials(),
            'stats' => $model->getStats()
        ];

        $this->render("home/index", $data);
    }
}
?>
