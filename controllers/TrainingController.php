<?php
class TrainingController extends BaseController {
    public function index() {
        $model = new TrainingModel($this->db);
        $data = [
            'trainings' => $model->getAllTrainings(),
            'contact' => $model->getContactDetails()
        ];
        $this->render("trainings/index", $data);
    }

    public function detail() {
        $id = $_GET['id'] ?? null;
        $model = new TrainingModel($this->db);
        $data = [
            'training' => $model->getTrainingById($id),
            'contact' => $model->getContactDetails()
        ];
        $this->render("trainings/detail", $data);
    }
}
?>