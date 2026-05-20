<?php
class AdminController extends AdminBaseController {

    public function login() {
        if ($this->isAdminLoggedIn()) {
            $this->redirect('admin/dashboard');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $adminModel = new AdminModel();
            $admin = $adminModel->authenticate($username, $password);

            if ($admin) {
                $_SESSION['admin_id'] = $admin['admin_id'];
                $_SESSION['admin_name'] = $admin['admin_name'];
                $_SESSION['admin_privilege'] = $admin['privilege'];

                if ($this->isAjax()) {
                    echo json_encode(['status' => 'success', 'redirect' => BASE_URL . '/admin/dashboard']);
                    exit;
                }
                $this->redirect('admin/dashboard');
            } else {
                $error = "Invalid username or password.";
                if ($this->isAjax()) {
                    echo json_encode(['status' => 'error', 'message' => $error]);
                    exit;
                }
                $this->render('admin/login', ['error' => $error], false);
                return;
            }
        }

        $this->render('admin/login', [], false);
    }

    public function logout() {
        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_name']);
        unset($_SESSION['admin_privilege']);
        $this->redirect('admin/login');
    }

    public function dashboard() {
        $adminModel = new AdminModel();
        $stats = $adminModel->getDashboardStats();
        $this->renderAdmin('dashboard', ['stats' => $stats]);
    }

    public function services() {
        $adminModel = new AdminModel();
        $services = $adminModel->getAllServices();
        $this->renderAdmin('services', ['services' => $services]);
    }

    public function projects() {
        $adminModel = new AdminModel();
        $projects = $adminModel->getAllProjects();
        $this->renderAdmin('projects', ['projects' => $projects]);
    }

    public function events() {
        $adminModel = new AdminModel();
        $events = $adminModel->getAllEvents();
        $this->renderAdmin('events', ['events' => $events]);
    }

    public function trainings() {
        $adminModel = new AdminModel();
        $trainings = $adminModel->getAllTrainings();
        $this->renderAdmin('trainings', ['trainings' => $trainings]);
    }

    public function blog() {
        $adminModel = new AdminModel();
        $blogs = $adminModel->getAllBlogs();
        $this->renderAdmin('blog', ['blogs' => $blogs]);
    }

    public function members() {
        $adminModel = new AdminModel();
        $members = $adminModel->getAllMembers();
        $this->renderAdmin('members', ['members' => $members]);
    }

    public function applications() {
        $adminModel = new AdminModel();
        $dse_apps = $adminModel->getDSEApplications();
        $bootcamp_apps = $adminModel->getBootcampApplications();
        $this->renderAdmin('applications', [
            'dse_apps' => $dse_apps,
            'bootcamp_apps' => $bootcamp_apps
        ]);
    }

    public function banners() {
        $adminModel = new AdminModel();
        $banners = $adminModel->getAllBanners();
        $this->renderAdmin('banners', ['banners' => $banners]);
    }

    public function faq() {
        $this->renderAdmin('faq');
    }

    public function testimonials() {
        $this->renderAdmin('testimonials');
    }

    public function settings() {
        $adminModel = new AdminModel();
        $admins = $adminModel->getAllAdmins();
        $this->renderAdmin('settings', ['admins' => $admins]);
    }
}
