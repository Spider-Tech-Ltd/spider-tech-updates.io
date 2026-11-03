<?php

class HealthController {
    /**
     * Public Health Check Endpoint
     * Returns HTTP 200 with JSON status when healthy, or HTTP 503 if database check fails.
     */
    public function check(): void {
        header('Content-Type: application/json; charset=utf-8');

        $status = [
            'status'    => 'ok',
            'timestamp' => date('c'),
            'php'       => PHP_VERSION,
            'database'  => 'unknown',
        ];

        try {
            $db = (new Database())->getConnection();
            if ($db instanceof PDO) {
                $stmt = $db->query('SELECT 1');
                if ($stmt !== false) {
                    $status['database'] = 'connected';
                } else {
                    $status['database'] = 'query_failed';
                }
            } else {
                $status['database'] = 'connection_failed';
            }
        } catch (\Throwable $e) {
            $status['status'] = 'error';
            $status['database'] = 'exception';
            $status['error'] = $e->getMessage();
            http_response_code(503);
            echo json_encode($status, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            return;
        }

        if ($status['database'] !== 'connected') {
            $status['status'] = 'degraded';
            http_response_code(503);
        } else {
            http_response_code(200);
        }

        echo json_encode($status, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}
