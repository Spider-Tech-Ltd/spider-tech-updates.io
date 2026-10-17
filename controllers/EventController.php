<?php
class EventController extends BaseController {
    public function index() {
        $model = new EventModel($this->db);
        $data = [
            'ongoing_events' => $model->getOngoingEvents(),
            'upcoming_events' => $model->getUpcomingEvents(),
            'past_events' => $model->getPastEvents(),
            'contact' => $model->getContactDetails()
        ];
        $this->render("events/list", $data);
    }

    public function ongoing() {
        $this->redirect('events');
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
        $event = $model->getEventById($id);

        // Build Open Graph meta data for social sharing
        $ogTitle       = $event ? htmlspecialchars(stripslashes($event['event_title'] ?? 'Spider Tech Event')) : 'Event Not Found';
        $ogDescription = $event ? htmlspecialchars(mb_strimwidth(strip_tags(stripslashes($event['event_content'] ?? '')), 0, 160, '…')) : '';
        $ogImage       = $event ? resolvePath($event['event_img'] ?? '') : '';
        $ogUrl         = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        $data = [
            'event'       => $event,
            'event_media' => $model->getEventMedia($id),
            'contact'     => $model->getContactDetails(),
            'og_title'    => $ogTitle,
            'og_description' => $ogDescription,
            'og_image'    => $ogImage,
            'og_url'      => $ogUrl,
        ];
        $this->render("events/detail", $data);
    }
}
?>