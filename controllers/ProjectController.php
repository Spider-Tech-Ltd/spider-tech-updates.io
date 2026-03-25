<?php
class ProjectController extends BaseController {
    public function index() {
        $projectModel = new ProjectModel($this->db);
        $homeModel = new HomeModel($this->db);
        $data = [
            'projects' => $projectModel->getAllProjects(),
            'contact' => $homeModel->getContactDetails()
        ];
        $this->render("projects/index", $data);
    }

    public function detail() {
        $id = $_GET['id'] ?? null;
        $projectModel = new ProjectModel($this->db);
        $homeModel = new HomeModel($this->db);
        $data = [
            'project' => $projectModel->getProjectById($id),
            'contact' => $homeModel->getContactDetails()
        ];
        $this->render("projects/detail", $data);
    }
}
?>