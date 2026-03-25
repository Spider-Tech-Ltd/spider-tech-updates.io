<?php
class ForumController extends BaseController {
    public function index() {
        $model = new ForumModel($this->db);
        $data = [
            'categories' => $model->getCategories(),
            'feeds' => $model->getFeeds(),
            'contact' => $model->getContactDetails()
        ];
        $this->render("forum/index", $data);
    }
}
?>