<?php

class BlogController extends BaseController {

    public function index() {
        $blogModel = new BlogModel($this->db);
        $categories = $blogModel->getCategories();

        $category_filter = $_GET['category'] ?? 'all';
        $blogs = $blogModel->getAllBlogs($category_filter);

        if ($this->isAjax()) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'blogs' => $blogs
            ]);
            return;
        }

        $this->render('blog/index', [
            'title' => 'Spider Tech | Insights & Research Hub',
            'categories' => $categories,
            'blogs' => $blogs,
            'current_category' => $category_filter
        ]);
    }

    public function detail($slug) {
        $blogModel = new BlogModel($this->db);
        $blog = $blogModel->getBlogBySlug($slug);

        if (!$blog) {
            if ($this->isAjax()) {
                http_response_code(404);
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Article not found']);
                return;
            }
            $this->redirect('blog');
        }

        $related_blogs = $blogModel->getRelatedBlogs($blog['category_id'], $blog['id'], 2);

        if ($this->isAjax()) {
            // Return content partial for SPA-like transition
            $this->render('blog/detail_partial', [
                'blog' => $blog,
                'related_blogs' => $related_blogs
            ], false); // No layout
            return;
        }

        $this->render('blog/detail', [
            'title' => 'Spider Tech | ' . $blog['title'],
            'blog' => $blog,
            'related_blogs' => $related_blogs
        ]);
    }
}
