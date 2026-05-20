<?php
class AdminController extends AdminBaseController {

    private function getPage() {
        return isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    }

    public function login() {
        if ($this->isAdminLoggedIn()) { $this->redirect('admin/dashboard'); }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $adminModel = new AdminModel();
            $admin = $adminModel->authenticate($username, $password);
            if ($admin) {
                $_SESSION['admin_id'] = $admin['admin_id'];
                $_SESSION['admin_name'] = $admin['admin_name'];
                $_SESSION['admin_privilege'] = $admin['privilege'];
                if ($this->isAjax()) { echo json_encode(['status' => 'success', 'redirect' => BASE_URL . '/admin/dashboard']); exit; }
                $this->redirect('admin/dashboard');
            } else {
                $error = "Invalid username or password.";
                if ($this->isAjax()) { echo json_encode(['status' => 'error', 'message' => $error]); exit; }
                $this->render('admin/login', ['error' => $error], false);
                return;
            }
        }
        $this->render('admin/login', [], false);
    }

    public function logout() {
        unset($_SESSION['admin_id'], $_SESSION['admin_name'], $_SESSION['admin_privilege']);
        $this->redirect('admin/login');
    }

    public function dashboard() {
        $adminModel = new AdminModel();
        $data = $adminModel->getDashboardData();
        $this->renderAdmin('dashboard', $data);
    }

    public function services() {
        $adminModel = new AdminModel();
        $result = $adminModel->getPaginated('services_tb', $this->getPage());
        $this->renderAdmin('services', ['services' => $result['data'], 'pagination' => $result]);
    }

    public function projects() {
        $adminModel = new AdminModel();
        $result = $adminModel->getPaginatedProjects($this->getPage());
        $this->renderAdmin('projects', ['projects' => $result['data'], 'pagination' => $result]);
    }

    public function events() {
        $adminModel = new AdminModel();
        $result = $adminModel->getPaginated('events', $this->getPage(), 6, 'event_date DESC');
        $this->renderAdmin('events', ['events' => $result['data'], 'pagination' => $result]);
    }

    public function trainings() {
        $adminModel = new AdminModel();
        $result = $adminModel->getPaginated('trainings_tb', $this->getPage());
        $this->renderAdmin('trainings', ['trainings' => $result['data'], 'pagination' => $result]);
    }

    public function blog() {
        $adminModel = new AdminModel();
        $result = $adminModel->getPaginated('blogs', $this->getPage(), 6, 'created_at DESC');
        $this->renderAdmin('blog', ['blogs' => $result['data'], 'pagination' => $result]);
    }

    public function members() {
        $adminModel = new AdminModel();
        $result = $adminModel->getPaginated('members', $this->getPage(), 6, 'created_at DESC');
        $this->renderAdmin('members', ['members' => $result['data'], 'pagination' => $result]);
    }

    public function banners() {
        $adminModel = new AdminModel();
        $result = $adminModel->getPaginated('banners_tb', $this->getPage(), 6, 'banner_id DESC');
        $this->renderAdmin('banners', ['banners' => $result['data'], 'pagination' => $result]);
    }

    public function faq() {
        $adminModel = new AdminModel();
        $result = $adminModel->getPaginated('faq_tb', $this->getPage(), 6, 'faq_id DESC');
        $this->renderAdmin('faq', ['faqs' => $result['data'], 'pagination' => $result]);
    }

    public function testimonials() {
        $adminModel = new AdminModel();
        $result = $adminModel->getPaginated('testimonials_tb', $this->getPage());
        $this->renderAdmin('testimonials', ['testimonials' => $result['data'], 'pagination' => $result]);
    }

    public function applications() {
        $adminModel = new AdminModel();
        $this->renderAdmin('applications', [
            'dse_apps' => $adminModel->getPaginated('dse_application', 1, 10, 'apply_date DESC')['data'],
            'bootcamp_apps' => $adminModel->getPaginated('bootcamp_application', 1, 10, 'apply_date DESC')['data']
        ]);
    }

    public function settings() {
        $adminModel = new AdminModel();
        $this->renderAdmin('settings', ['admins' => $adminModel->getAllAdmins()]);
    }

    // Module Add/Edit View Handlers
    public function addService() { $this->renderAdmin('forms/service_form', ['mode' => 'add']); }
    public function editService($id) {
        $adminModel = new AdminModel();
        $service = $adminModel->getById('services_tb', 'id', $id);
        $this->renderAdmin('forms/service_form', ['mode' => 'edit', 'item' => $service]);
    }

    public function addProject() {
        $adminModel = new AdminModel();
        $services = $adminModel->getPaginated('services_tb', 1, 100)['data'];
        $this->renderAdmin('forms/project_form', ['mode' => 'add', 'services' => $services]);
    }
    public function editProject($id) {
        $adminModel = new AdminModel();
        $project = $adminModel->getById('projects_tb', 'project_id', $id);
        $services = $adminModel->getPaginated('services_tb', 1, 100)['data'];
        $this->renderAdmin('forms/project_form', ['mode' => 'edit', 'item' => $project, 'services' => $services]);
    }

    public function addEvent() { $this->renderAdmin('forms/event_form', ['mode' => 'add']); }
    public function editEvent($id) {
        $adminModel = new AdminModel();
        $event = $adminModel->getById('events', 'event_id', $id);
        $this->renderAdmin('forms/event_form', ['mode' => 'edit', 'item' => $event]);
    }

    public function addTraining() { $this->renderAdmin('forms/training_form', ['mode' => 'add']); }
    public function editTraining($id) {
        $adminModel = new AdminModel();
        $training = $adminModel->getById('trainings_tb', 'id', $id);
        $this->renderAdmin('forms/training_form', ['mode' => 'edit', 'item' => $training]);
    }

    public function addBlog() {
        $categories = $this->db->query("SELECT * FROM blog_categories")->fetchAll(PDO::FETCH_ASSOC);
        $this->renderAdmin('forms/blog_form', ['mode' => 'add', 'categories' => $categories]);
    }
    public function editBlog($id) {
        $adminModel = new AdminModel();
        $blog = $adminModel->getById('blogs', 'uuid', $id);
        $categories = $this->db->query("SELECT * FROM blog_categories")->fetchAll(PDO::FETCH_ASSOC);
        $this->renderAdmin('forms/blog_form', ['mode' => 'edit', 'item' => $blog, 'categories' => $categories]);
    }

    public function addBanner() { $this->renderAdmin('forms/banner_form', ['mode' => 'add']); }
    public function editBanner($id) {
        $adminModel = new AdminModel();
        $banner = $adminModel->getById('banners_tb', 'banner_id', $id);
        $this->renderAdmin('forms/banner_form', ['mode' => 'edit', 'item' => $banner]);
    }

    public function addFAQ() { $this->renderAdmin('forms/faq_form', ['mode' => 'add']); }
    public function editFAQ($id) {
        $adminModel = new AdminModel();
        $faq = $adminModel->getById('faq_tb', 'faq_id', $id);
        $this->renderAdmin('forms/faq_form', ['mode' => 'edit', 'item' => $faq]);
    }

    public function addTestimonial() { $this->renderAdmin('forms/testimonial_form', ['mode' => 'add']); }
    public function editTestimonial($id) {
        $adminModel = new AdminModel();
        $testimonial = $adminModel->getById('testimonials_tb', 'id', $id);
        $this->renderAdmin('forms/testimonial_form', ['mode' => 'edit', 'item' => $testimonial]);
    }

    public function deleteRecord() {
        if (!$this->isAjax() || $_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(403); exit; }
        $id = $_POST['id'] ?? null; $type = $_POST['type'] ?? null;
        if (!$id || !$type) { echo json_encode(['status' => 'error', 'message' => 'Missing parameters.']); exit; }
        $adminModel = new AdminModel();
        if ($adminModel->deleteRecord($type, $id)) { echo json_encode(['status' => 'success', 'message' => ucfirst($type) . ' deleted successfully.']); }
        else { echo json_encode(['status' => 'error', 'message' => 'Failed to delete record.']); }
    }

    public function storeRecord() {
        if (!$this->isAjax() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(403);
            exit;
        }

        $type = $_POST['type'] ?? null;
        if (!$type) {
            echo json_encode(['status' => 'error', 'message' => 'Missing record type.']);
            exit;
        }

        $adminModel = new AdminModel();
        $success = $adminModel->storeRecord($type, $_POST);

        if ($success) {
            echo json_encode(['status' => 'success', 'message' => ucfirst($type) . ' saved successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to save record.']);
        }
    }
}
