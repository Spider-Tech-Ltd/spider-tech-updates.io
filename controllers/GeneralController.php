<?php
class GeneralController extends BaseController {
    public function about() {
        $model = new GeneralModel($this->db);
        $data = [
            'about' => $model->getAboutInfo(),
            'mission' => $model->getMission(),
            'vision' => $model->getVision(),
            'values' => $model->getValues(),
            'contact' => $model->getContactDetails()
        ];
        $this->render("general/about", $data);
    }

    public function contact() {
        $model = new GeneralModel($this->db);
        $data = [
            'contact' => $model->getContactDetails()
        ];
        $this->render("general/contact", $data);
    }

    public function faq() {
        $model = new GeneralModel($this->db);
        $data = [
            'faqs' => $model->getFaqs(),
            'contact' => $model->getContactDetails()
        ];
        $this->render("general/faq", $data);
    }

    public function blog() {
        $model = new GeneralModel($this->db);
        $data = [
            'contact' => $model->getContactDetails()
        ];
        $this->render("general/blog", $data);
    }

    public function healthz() {
        header('Content-Type: application/json');
        $dbStatus = ($this->db !== null);
        if (!$dbStatus) {
            http_response_code(503);
            echo json_encode(['status' => 'degraded', 'database' => false, 'timestamp' => time()]);
            exit;
        }
        echo json_encode(['status' => 'healthy', 'database' => true, 'timestamp' => time()]);
        exit;
    }
}
?>