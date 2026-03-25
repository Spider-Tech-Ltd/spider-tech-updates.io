<?php
class ServiceController extends BaseController {
    public function index() {
        $serviceModel = new ServiceModel($this->db);
        $homeModel = new HomeModel($this->db);
        $data = [
            'services' => $serviceModel->getAllServices(),
            'contact' => $homeModel->getContactDetails()
        ];
        $this->render("services/index", $data);
    }

    public function detail() {
        $id = $_GET['id'] ?? null;
        $serviceModel = new ServiceModel($this->db);
        $homeModel = new HomeModel($this->db);
        $data = [
            'service' => $serviceModel->getServiceById($id),
            'contact' => $homeModel->getContactDetails()
        ];
        $this->render("services/detail", $data);
    }
}
?>