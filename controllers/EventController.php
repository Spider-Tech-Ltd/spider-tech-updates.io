<?php
class EventController extends BaseController {
    public function index() {
        $model = new EventModel($this->db);
        $data = [
            'upcoming_events' => $model->getUpcomingEvents(),
            'past_events' => $model->getPastEvents(),
            'contact' => $model->getContactDetails()
        ];
        $this->render("events/list", $data);
    }

    public function upcoming() {
        $this->redirect('events');
    }

    public function past() {
        $this->redirect('events');
    }

    public function detail($id = null) {
        $id = $id ?? $_GET['id'] ?? null;
        $model = new EventModel($this->db);
        $data = [
            'event' => $model->getEventById($id),
            'event_media' => $model->getEventMedia($id),
            'contact' => $model->getContactDetails()
        ];
        $this->render("events/detail", $data);
    }
}
?>