<?php
class EventController extends BaseController {
    public function index() {
        $model = new EventModel($this->db);
        $data = [
            'events' => $model->getAllEvents(),
            'contact' => $model->getContactDetails()
        ];
        $this->render("events/list", $data);
    }

    public function upcoming() {
        $model = new EventModel($this->db);
        $data = [
            'events' => $model->getUpcomingEvents(),
            'contact' => $model->getContactDetails(),
            'title' => 'Upcoming Events'
        ];
        $this->render("events/list", $data);
    }

    public function past() {
        $model = new EventModel($this->db);
        $data = [
            'events' => $model->getPastEvents(),
            'contact' => $model->getContactDetails(),
            'title' => 'Past Events'
        ];
        $this->render("events/list", $data);
    }

    public function detail() {
        $id = $_GET['id'] ?? null;
        $model = new EventModel($this->db);
        $data = [
            'event' => $model->getEventById($id),
            'contact' => $model->getContactDetails()
        ];
        $this->render("events/detail", $data);
    }
}
?>