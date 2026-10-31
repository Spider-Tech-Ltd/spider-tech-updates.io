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
                $_SESSION['admin_profile_pic'] = $admin['profile_pic'] ?? null;
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
        
        $page = $this->getPage();
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 6;
        if ($limit < 1 || $limit > 100) $limit = 6;
        
        $sort = $_GET['sort'] ?? 'id_desc';
        $orderBy = match ($sort) {
            'id_asc' => 'id ASC',
            'name_asc' => 'service_name ASC',
            'name_desc' => 'service_name DESC',
            'order_asc' => 'sort_order ASC, id ASC',
            'order_desc' => 'sort_order DESC, id DESC',
            default => 'id DESC'
        };
        
        $filters = [];
        if (isset($_GET['status']) && $_GET['status'] !== 'all' && $_GET['status'] !== '') {
            $filters['show_on_home'] = (int)$_GET['status'];
        }

        $search = trim($_GET['q'] ?? '');
        $searchColumns = ['service_name', 'service_description', 'service_detail'];

        $result = $adminModel->getPaginated('services_tb', $page, $limit, $orderBy, $filters, $search, $searchColumns);
        $allServices = $adminModel->getAll('services_tb');

        $this->renderAdmin('services', [
            'services' => $result['data'],
            'pagination' => $result,
            'all_services' => $allServices,
            'current_limit' => $limit,
            'current_sort' => $sort,
            'current_status' => $_GET['status'] ?? 'all',
            'search_query' => $search
        ]);
    }

    public function projects() {
        $adminModel = new AdminModel();
        
        $page = $this->getPage();
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 6;
        if ($limit < 1 || $limit > 100) $limit = 6;
        
        $sort = $_GET['sort'] ?? 'id_desc';
        $orderBy = match ($sort) {
            'id_asc' => 'p.project_id ASC',
            'name_asc' => 'p.project_name ASC',
            'name_desc' => 'p.project_name DESC',
            'year_desc' => 'p.project_year DESC, p.project_id DESC',
            'year_asc' => 'p.project_year ASC, p.project_id ASC',
            default => 'p.project_id DESC'
        };
        
        $serviceFilter = $_GET['service'] ?? 'all';
        $search = trim($_GET['q'] ?? '');
        
        $result = $adminModel->getPaginatedProjects($page, $limit, $orderBy, $serviceFilter, $search);
        $allProjects = $adminModel->getAll('projects_tb');
        $services = $adminModel->getAll('services_tb', 'service_name ASC');
        
        $this->renderAdmin('projects', [
            'projects' => $result['data'],
            'pagination' => $result,
            'all_projects' => $allProjects,
            'services' => $services,
            'current_limit' => $limit,
            'current_sort' => $sort,
            'current_service' => $serviceFilter,
            'search_query' => $search
        ]);
    }

    public function events() {
        $adminModel = new AdminModel();

        $page = $this->getPage();
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 6;
        if ($limit < 1 || $limit > 100) $limit = 6;

        $sort = $_GET['sort'] ?? 'date_desc';
        $orderBy = match ($sort) {
            'date_asc' => 'event_date ASC',
            'title_asc' => 'event_title ASC',
            'title_desc' => 'event_title DESC',
            'id_desc' => 'event_id DESC',
            default => 'event_date DESC'
        };

        $statusFilter = $_GET['status'] ?? 'all';
        $search = trim($_GET['q'] ?? '');

        $result = $adminModel->getPaginatedEvents($page, $limit, $orderBy, $statusFilter, $search);
        $stats = $adminModel->getEventStats();

        $this->renderAdmin('events', [
            'events' => $result['data'],
            'pagination' => $result,
            'stats' => $stats,
            'current_limit' => $limit,
            'current_sort' => $sort,
            'current_status' => $statusFilter,
            'search_query' => $search
        ]);
    }

    public function trainings() {
        $adminModel = new AdminModel();

        $page = $this->getPage();
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 6;
        if ($limit < 1 || $limit > 100) $limit = 6;

        $sort = $_GET['sort'] ?? 'order_asc';
        $orderBy = match ($sort) {
            'order_asc' => 't.sort_order ASC, t.id DESC',
            'name_asc' => 't.training_name ASC',
            'name_desc' => 't.training_name DESC',
            'apps_desc' => 'total_applications DESC',
            'id_desc' => 't.id DESC',
            default => 't.sort_order ASC, t.id DESC'
        };

        $statusFilter = $_GET['status'] ?? 'all';
        $search = trim($_GET['q'] ?? '');

        $result = $adminModel->getPaginatedTrainings($page, $limit, $orderBy, $statusFilter, $search);
        $stats = $adminModel->getTrainingStats();

        $this->renderAdmin('trainings', [
            'trainings' => $result['data'],
            'pagination' => $result,
            'stats' => $stats,
            'current_limit' => $limit,
            'current_sort' => $sort,
            'current_status' => $statusFilter,
            'search_query' => $search
        ]);
    }

    public function toggleTraining() {
        if (!$this->isAjax() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(403);
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);
        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid training program ID.']);
            exit;
        }

        $adminModel = new AdminModel();
        $res = $adminModel->toggleTrainingRegistration($id);

        echo json_encode([
            'status' => $res ? 'success' : 'error',
            'message' => $res ? 'Training program registration status updated.' : 'Failed to toggle status.'
        ]);
        exit;
    }

    public function blog() {
        $adminModel = new AdminModel();
        
        $page = $this->getPage();
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 6;
        if ($limit < 1 || $limit > 100) $limit = 6;
        
        $sort = $_GET['sort'] ?? 'date_desc';
        $orderBy = match ($sort) {
            'date_asc' => 'b.created_at ASC',
            'title_asc' => 'b.title ASC',
            'title_desc' => 'b.title DESC',
            'status_pub' => 'b.status ASC, b.created_at DESC',
            'status_draft' => 'b.status DESC, b.created_at DESC',
            default => 'b.created_at DESC'
        };
        
        $categoryFilter = $_GET['category'] ?? 'all';
        $statusFilter = $_GET['status'] ?? 'all';
        $search = trim($_GET['q'] ?? '');
        
        $result = $adminModel->getPaginatedBlogs($page, $limit, $orderBy, $categoryFilter, $statusFilter, $search);
        $totalBlogsCount = $adminModel->getTotalBlogsCount();
        $categories = $adminModel->getAll('blog_categories', 'name ASC');
        
        $this->renderAdmin('blog', [
            'blogs' => $result['data'],
            'pagination' => $result,
            'total_blogs_count' => $totalBlogsCount,
            'categories' => $categories,
            'current_limit' => $limit,
            'current_sort' => $sort,
            'current_category' => $categoryFilter,
            'current_status' => $statusFilter,
            'search_query' => $search
        ]);
    }

    public function members() {
        $adminModel = new AdminModel();
        
        $page = $this->getPage();
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
        if ($limit < 1 || $limit > 100) $limit = 10;

        $sort = $_GET['sort'] ?? 'id_desc';
        $orderBy = match ($sort) {
            'date_asc' => 'created_at ASC',
            'name_asc' => 'name ASC',
            'name_desc' => 'name DESC',
            default => 'created_at DESC'
        };

        $statusFilter = $_GET['status'] ?? 'all';
        $filters = [];

        if ($statusFilter === 'verified') {
            $filters['is_verified'] = 1;
        } elseif ($statusFilter === 'pending') {
            $filters['is_verified'] = 0;
        } elseif ($statusFilter === 'suspended') {
            $filters['status'] = 'Suspended';
        }

        $search = trim($_GET['q'] ?? '');
        $searchColumns = ['name', 'username', 'email'];

        $result = $adminModel->getPaginated('members', $page, $limit, $orderBy, $filters, $search, $searchColumns);
        $reviews = $adminModel->getSuspensionReviews();
        $stats = $adminModel->getMemberStats();

        $this->renderAdmin('members', [
            'members' => $result['data'],
            'pagination' => $result,
            'reviews' => $reviews,
            'stats' => $stats,
            'current_limit' => $limit,
            'current_sort' => $sort,
            'current_status' => $statusFilter,
            'search_query' => $search
        ]);
    }

    public function banners() {
        $adminModel = new AdminModel();
        $result = $adminModel->getPaginated('banners_tb', $this->getPage(), 6, 'banner_id DESC');
        $this->renderAdmin('banners', ['banners' => $result['data'], 'pagination' => $result]);
    }

    public function faq() {
        $adminModel = new AdminModel();
        
        $page = $this->getPage();
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
        if ($limit < 1 || $limit > 100) $limit = 10;

        $sort = $_GET['sort'] ?? 'id_desc';
        $orderBy = match ($sort) {
            'id_asc' => 'faq_id ASC',
            'question_asc' => 'faq_question ASC',
            'question_desc' => 'faq_question DESC',
            default => 'faq_id DESC'
        };

        $search = trim($_GET['q'] ?? '');
        $searchColumns = ['faq_question', 'faq_answer'];

        $result = $adminModel->getPaginated('faq_tb', $page, $limit, $orderBy, [], $search, $searchColumns);
        $stats = $adminModel->getFaqStats();

        $this->renderAdmin('faq', [
            'faqs' => $result['data'],
            'pagination' => $result,
            'stats' => $stats,
            'current_limit' => $limit,
            'current_sort' => $sort,
            'search_query' => $search
        ]);
    }

    public function partners() {
        $adminModel = new AdminModel();

        $status = $_GET['status'] ?? 'all';
        $search = trim($_GET['q'] ?? '');
        $sort = $_GET['sort'] ?? 'order_asc';

        $partners = $adminModel->getAllPartners($status, $search, $sort);
        $stats = $adminModel->getPartnerStats();

        $this->renderAdmin('partners', [
            'partners' => $partners,
            'stats' => $stats,
            'current_status' => $status,
            'search_query' => $search,
            'current_sort' => $sort
        ]);
    }

    public function savePartner() {
        header('Content-Type: application/json');
        if (!$this->isAjax() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(403);
            echo json_encode(['status' => 'error', 'message' => 'Forbidden access.']);
            exit;
        }

        $id = !empty($_POST['id']) ? (int)$_POST['id'] : null;
        $_POST['action_mode'] = $id ? 'update' : 'store';
        $_POST['type'] = 'partner';

        if (empty(trim($_POST['name'] ?? ''))) {
            echo json_encode(['status' => 'error', 'message' => 'Partner name is required.']);
            exit;
        }

        if (!$id && (!isset($_FILES['logo']) || $_FILES['logo']['error'] !== UPLOAD_ERR_OK)) {
            echo json_encode(['status' => 'error', 'message' => 'Partner logo is required for new entries.']);
            exit;
        }

        try {
            $adminModel = new AdminModel();
            $success = $adminModel->storeRecord('partner', $_POST);

            if ($success) {
                echo json_encode([
                    'status' => 'success',
                    'message' => $id ? 'Partner updated successfully.' : 'Partner added successfully.'
                ]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to save partner record.']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Server Error: ' . $e->getMessage()]);
        }
        exit;
    }

    public function togglePartner() {
        header('Content-Type: application/json');
        if (!$this->isAjax() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(403);
            echo json_encode(['status' => 'error', 'message' => 'Forbidden access.']);
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);
        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid partner ID.']);
            exit;
        }

        $adminModel = new AdminModel();
        $res = $adminModel->togglePartnerStatus($id);

        echo json_encode([
            'status' => $res ? 'success' : 'error',
            'message' => $res ? 'Partner visibility toggled successfully.' : 'Failed to toggle status.'
        ]);
        exit;
    }

    public function testimonials() {
        $adminModel = new AdminModel();

        $page = $this->getPage();
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
        if ($limit < 1 || $limit > 100) $limit = 10;

        $sort = $_GET['sort'] ?? 'id_desc';
        $orderBy = match ($sort) {
            'id_asc' => 'id ASC',
            'name_asc' => 'name ASC',
            'name_desc' => 'name DESC',
            'org_asc' => 'organization ASC',
            default => 'id DESC'
        };

        $search = trim($_GET['q'] ?? '');
        $searchColumns = ['name', 'organization', 'title', 'testimonial'];

        $result = $adminModel->getPaginated('testimonials_tb', $page, $limit, $orderBy, [], $search, $searchColumns);
        $stats = $adminModel->getTestimonialStats();

        $this->renderAdmin('testimonials', [
            'testimonials' => $result['data'],
            'pagination' => $result,
            'stats' => $stats,
            'current_limit' => $limit,
            'current_sort' => $sort,
            'search_query' => $search
        ]);
    }

    public function memberDetails($id) {
        if (!$this->isAjax()) { http_response_code(403); exit; }
        $adminModel = new AdminModel();
        $member = $adminModel->getById('members', 'id', $id);
        if ($member) {
            echo json_encode(['status' => 'success', 'data' => $member]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Member not found.']);
        }
        exit;
    }

    public function toggleMemberStatus() {
        if (!$this->isAjax() || $_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(403); exit; }
        $id = $_POST['id'] ?? null;
        if (!$id) { echo json_encode(['status' => 'error', 'message' => 'Missing member ID.']); exit; }
        $adminModel = new AdminModel();
        if ($adminModel->toggleMemberStatus($id)) {
            echo json_encode(['status' => 'success', 'message' => 'Member status updated successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update member status.']);
        }
        exit;
    }

    public function applications() {
        $adminModel = new AdminModel();
        require_once ROOT_PATH . '/models/CohortModel.php';
        $cohortModel = new CohortModel();

        $programId = $_GET['program'] ?? 'all';
        $cohortId = $_GET['cohort'] ?? 'all';
        $search = trim($_GET['search'] ?? '');
        $export = $_GET['export'] ?? '';

        // Handle CSV Export
        if ($export === 'csv') {
            $this->exportApplicationsCsv($programId, $cohortId, $search);
            return;
        }

        $page = $this->getPage();
        $result = $adminModel->getUnifiedApplications($programId, $page, 10, $cohortId, $search);
        $programs = $adminModel->getAllPrograms();
        $cohorts = $cohortModel->getAllCohortsForAdmin();
        $stats = $adminModel->getApplicationStats();

        $this->renderAdmin('applications', [
            'applications' => $result['data'],
            'pagination' => $result,
            'current_program' => $programId,
            'current_cohort' => $cohortId,
            'current_search' => $search,
            'programs' => $programs,
            'cohorts' => $cohorts,
            'stats' => $stats
        ]);
    }

    private function exportApplicationsCsv($programId, $cohortId, $search) {
        $adminModel = new AdminModel();
        $result = $adminModel->getUnifiedApplications($programId, 1, 0, $cohortId, $search);
        $rows = $result['data'] ?? [];

        $filename = 'program_applications_' . date('Y-m-d_His') . '.csv';

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $output = fopen('php://output', 'w');
        // UTF-8 BOM for Microsoft Excel compatibility
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

        fputcsv($output, [
            'App ID',
            'Full Name',
            'Email',
            'Phone',
            'Program',
            'Cohort',
            'Gender',
            'Age',
            'State',
            'LGA',
            'Business Name',
            'Business Sector',
            'Business Stage',
            'Applied Date'
        ]);

        foreach ($rows as $r) {
            $u = json_decode($r['user_data'], true) ?: [];
            $first = $u['first_name'] ?? $u['firstname'] ?? '';
            $middle = $u['middle_name'] ?? '';
            $last = $u['last_name'] ?? $u['lastname'] ?? '';
            $full = $u['full_name'] ?? $u['name'] ?? trim($first . ' ' . $middle . ' ' . $last);
            if (!$full) $full = trim($first . ' ' . $last);

            fputcsv($output, [
                $r['id'],
                $full,
                $u['email'] ?? $u['email_address'] ?? '',
                $u['phone'] ?? $u['phone_no'] ?? '',
                $r['program_name'] ?? '',
                $r['cohort_name'] ?? ($r['cohort_id'] ? 'Cohort ' . $r['cohort_id'] : 'General Intake'),
                $u['gender'] ?? '',
                $u['age'] ?? '',
                $u['state_of_origin'] ?? $u['state'] ?? '',
                $u['local_government'] ?? $u['lga'] ?? '',
                $u['business_name'] ?? '',
                $u['business_section'] ?? $u['business_type'] ?? '',
                $u['business_stage'] ?? '',
                $r['created_at']
            ]);
        }

        fclose($output);
        exit;
    }

    public function cohorts() {
        require_once ROOT_PATH . '/models/CohortModel.php';
        $adminModel = new AdminModel();
        $trainingId = $_GET['training_id'] ?? 'all';
        $status = $_GET['status'] ?? 'all';
        $search = trim($_GET['search'] ?? '');

        $cohorts = $adminModel->getAllCohorts($trainingId, $status, $search);
        $programs = $adminModel->getAllPrograms();
        $stats = $adminModel->getCohortStats();

        $this->renderAdmin('cohorts', [
            'cohorts' => $cohorts,
            'programs' => $programs,
            'stats' => $stats,
            'current_training' => $trainingId,
            'current_status' => $status,
            'current_search' => $search
        ]);
    }

    public function saveCohort() {
        if (!$this->isAjax() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(403);
            exit;
        }

        require_once ROOT_PATH . '/models/CohortModel.php';
        $cohortModel = new CohortModel();

        $id = !empty($_POST['id']) ? (int)$_POST['id'] : null;
        $trainingId = (int)($_POST['training_id'] ?? 0);
        $cohortNumber = (int)($_POST['cohort_number'] ?? 1);
        $cohortName = trim($_POST['cohort_name'] ?? '');
        $startDate = trim($_POST['start_date'] ?? '');
        $endDate = trim($_POST['end_date'] ?? '');
        $deadline = !empty($_POST['registration_deadline']) ? trim($_POST['registration_deadline']) : null;
        $capacity = (int)($_POST['capacity'] ?? 0);
        $status = $_POST['status'] ?? 'upcoming';
        $registrationOpen = !empty($_POST['registration_open']) ? 1 : 0;
        $showTopbarBanner = !empty($_POST['show_topbar_banner']) ? 1 : 0;
        $customAnnouncement = !empty($_POST['custom_announcement']) ? trim($_POST['custom_announcement']) : null;

        if (!$trainingId || empty($cohortName) || empty($startDate) || empty($endDate)) {
            echo json_encode(['status' => 'error', 'message' => 'Please fill in all required fields.']);
            exit;
        }

        $slug = !empty($_POST['slug']) ? trim($_POST['slug']) : strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $cohortName)));

        $data = [
            'training_id'           => $trainingId,
            'cohort_number'         => $cohortNumber,
            'cohort_name'           => $cohortName,
            'slug'                  => $slug,
            'start_date'            => $startDate,
            'end_date'              => $endDate,
            'registration_deadline' => $deadline,
            'capacity'              => $capacity,
            'status'                => $status,
            'registration_open'     => $registrationOpen,
            'show_topbar_banner'    => $showTopbarBanner,
            'custom_announcement'   => $customAnnouncement
        ];

        if ($id) {
            $success = $cohortModel->updateCohort($id, $data);
            $msg = $success ? 'Cohort updated successfully.' : 'Failed to update cohort.';
        } else {
            $newId = $cohortModel->createCohort($data);
            $success = (bool)$newId;
            $msg = $success ? 'Cohort created successfully.' : 'Failed to create cohort. Slug may already exist.';
        }

        echo json_encode([
            'status' => $success ? 'success' : 'error',
            'message' => $msg
        ]);
        exit;
    }

    public function toggleCohortBanner() {
        if (!$this->isAjax() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(403);
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);
        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid cohort ID.']);
            exit;
        }

        require_once ROOT_PATH . '/models/CohortModel.php';
        $cohortModel = new CohortModel();
        $res = $cohortModel->toggleTopbarBanner($id);

        echo json_encode([
            'status' => $res ? 'success' : 'error',
            'message' => $res ? 'Topbar announcement visibility updated.' : 'Failed to toggle banner status.'
        ]);
        exit;
    }

    public function toggleCohort() {
        if (!$this->isAjax() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(403);
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);
        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid cohort ID.']);
            exit;
        }

        require_once ROOT_PATH . '/models/CohortModel.php';
        $cohortModel = new CohortModel();
        $res = $cohortModel->toggleRegistration($id);

        echo json_encode([
            'status' => $res ? 'success' : 'error',
            'message' => $res ? 'Cohort registration status updated.' : 'Failed to toggle status.'
        ]);
        exit;
    }

    public function deleteCohort() {
        if (!$this->isAjax() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(403);
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);
        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid cohort ID.']);
            exit;
        }

        require_once ROOT_PATH . '/models/CohortModel.php';
        $cohortModel = new CohortModel();
        $res = $cohortModel->deleteCohort($id);

        if ($res) {
            echo json_encode(['status' => 'success', 'message' => 'Cohort deleted successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Cannot delete cohort with existing applicant registrations.']);
        }
        exit;
    }

    public function settings() {
        $adminModel = new AdminModel();
        $currentAdmin = $adminModel->getById('admin_tb', 'admin_id', $_SESSION['admin_id']);
        $socialLinks = $adminModel->getSocialLinks();
        $this->renderAdmin('settings', [
            'admins' => $adminModel->getAllAdmins(),
            'currentAdmin' => $currentAdmin,
            'socialLinks' => $socialLinks
        ]);
    }

    public function updateProfile() {
        header('Content-Type: application/json');
        if (!$this->isAjax() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(403); exit;
        }

        try {
            $adminModel = new AdminModel();
            if ($adminModel->updateAdminProfile($_SESSION['admin_id'], $_POST, $_FILES)) {
                echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to update profile.']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Server Error: ' . $e->getMessage()]);
        }
        exit;
    }

    public function updateSocialLinks() {
        header('Content-Type: application/json');
        if (!$this->isAjax() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(403); exit;
        }

        try {
            $adminModel = new AdminModel();
            if ($adminModel->updateSocialLinks($_POST['links'] ?? [])) {
                echo json_encode(['status' => 'success', 'message' => 'Social links updated successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to update social links.']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Server Error: ' . $e->getMessage()]);
        }
        exit;
    }

    public function createAdminAccount() {
        header('Content-Type: application/json');
        if (!$this->isAjax() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(403); exit;
        }

        try {
            $name = trim($_POST['admin_name'] ?? '');
            $password = $_POST['admin_password'] ?? '';
            $privilege = trim($_POST['privilege'] ?? 'Admin');

            if (empty($name)) {
                echo json_encode(['status' => 'error', 'message' => 'Administrator username/name is required.']);
                exit;
            }

            if (empty($password) || strlen($password) < 6) {
                echo json_encode(['status' => 'error', 'message' => 'Password must be at least 6 characters long.']);
                exit;
            }

            if (!in_array($privilege, ['Super Admin', 'Admin', 'Editor', 'Moderator'])) {
                $privilege = 'Admin';
            }

            $adminModel = new AdminModel();
            if ($adminModel->createAdmin($name, $password, $privilege)) {
                echo json_encode(['status' => 'success', 'message' => 'New administrator created successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to create administrator.']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        exit;
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
        $this->renderAdmin('forms/project_form', ['mode' => 'add', 'services' => $services, 'media' => []]);
    }
    public function editProject($id) {
        $adminModel = new AdminModel();
        $project = $adminModel->getById('projects_tb', 'project_id', $id);
        $services = $adminModel->getPaginated('services_tb', 1, 100)['data'];
        $media = $adminModel->getProjectMedia($id);
        $this->renderAdmin('forms/project_form', ['mode' => 'edit', 'item' => $project, 'services' => $services, 'media' => $media]);
    }

    public function addEvent() { $this->renderAdmin('forms/event_form', ['mode' => 'add', 'media' => []]); }
    public function editEvent($id) {
        $adminModel = new AdminModel();
        $event = $adminModel->getById('events', 'event_id', $id);
        $media = $adminModel->getEventMedia($id);
        $this->renderAdmin('forms/event_form', ['mode' => 'edit', 'item' => $event, 'media' => $media]);
    }

    public function deleteEventMedia() {
        header('Content-Type: application/json');
        if (!$this->isAjax() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(403); exit;
        }

        $id = $_POST['id'] ?? null;
        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'Missing media ID.']);
            exit;
        }

        try {
            $adminModel = new AdminModel();
            if ($adminModel->deleteEventMedia($id)) {
                echo json_encode(['status' => 'success', 'message' => 'Media deleted successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete media.']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Server Error: ' . $e->getMessage()]);
        }
        exit;
    }

    public function deleteProjectMedia() {
        header('Content-Type: application/json');
        if (!$this->isAjax() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(403); exit;
        }

        $id = $_POST['id'] ?? null;
        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'Missing media ID.']);
            exit;
        }

        try {
            $adminModel = new AdminModel();
            if ($adminModel->deleteProjectMedia($id)) {
                echo json_encode(['status' => 'success', 'message' => 'Media deleted successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete media.']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Server Error: ' . $e->getMessage()]);
        }
        exit;
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

    public function getNotifications() {
        if (!$this->isAdminLoggedIn()) { exit; }
        header('Content-Type: application/json');
        $filter = $_GET['filter'] ?? 'all';
        $adminModel = new AdminModel();
        $notifications = $adminModel->getNotifications($filter);
        $unreadCount = $adminModel->getUnreadNotificationCount();
        echo json_encode(['status' => 'success', 'data' => $notifications, 'unread_count' => $unreadCount]);
        exit;
    }

    public function markNotificationRead() {
        if (!$this->isAdminLoggedIn()) { exit; }
        header('Content-Type: application/json');
        $id = $_POST['id'] ?? 0;
        $adminModel = new AdminModel();
        if ($adminModel->markNotificationRead($id)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }

    public function storeRecord() {
        header('Content-Type: application/json');
        if (!$this->isAjax() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(403);
            echo json_encode(['status' => 'error', 'message' => 'Forbidden access.']);
            exit;
        }

        $type = $_POST['type'] ?? null;
        if (!$type) {
            echo json_encode(['status' => 'error', 'message' => 'Missing record type.']);
            exit;
        }

        try {
            $adminModel = new AdminModel();
            $success = $adminModel->storeRecord($type, $_POST);

            if ($success) {
                echo json_encode(['status' => 'success', 'message' => ucfirst($type) . ' saved successfully.']);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Failed to save ' . $type . ' record.',
                    'debug' => 'Model returned false. Check for duplicate keys or missing columns.'
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Server Error: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}
