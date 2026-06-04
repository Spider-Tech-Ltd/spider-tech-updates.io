<?php
class ProjectController extends BaseController
{
    public function index()
    {
        // FIXED: Using ProjectModel instead of HomeModel for separation of concerns
        $projectModel = new ProjectModel($this->db);
        $homeModel = new HomeModel($this->db);
,
        $data = [
            'projects' => $projectModel->getAllProjects(), // Explicitly calls getAllProjects
            'contact' => $homeModel->getContactDetails()
        ];
        $this->render("projects/index", $data);
    }

    public function detail()
    {
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
