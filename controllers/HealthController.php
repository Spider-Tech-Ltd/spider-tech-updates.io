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

        $db = null;
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
            echo json_encode($status, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            return;
        }

        // Diagnostic probe for debugging production schema differences
        if (isset($_GET['diag']) && $db instanceof PDO) {
            $diag = [];
            $checkTables = ['trainings_tb', 'training_cohorts', 'training_registrations', 'payment_transactions', 'partners_tb'];
            foreach ($checkTables as $table) {
                try {
                    $cnt = $db->query("SELECT COUNT(*) FROM `$table`")->fetchColumn();
                    $cols = $db->query("DESCRIBE `$table`")->fetchAll(PDO::FETCH_COLUMN);
                    $diag['tables'][$table] = [
                        'exists' => true,
                        'rows' => (int)$cnt,
                        'columns' => $cols
                    ];
                } catch (\Throwable $te) {
                    $diag['tables'][$table] = [
                        'exists' => false,
                        'error' => $te->getMessage()
                    ];
                }
            }

            try {
                require_once ROOT_PATH . '/models/TrainingModel.php';
                require_once ROOT_PATH . '/models/CohortModel.php';
                $tm = new TrainingModel($db);
                $trainings = $tm->getAllTrainings();
                $cm = new CohortModel($db);
                $firstCohort = null;
                if (!empty($trainings)) {
                    $firstCohort = $cm->getActiveCohort($trainings[0]['id']);
                }
                $diag['training_probe'] = [
                    'status' => 'ok',
                    'trainings_count' => count($trainings),
                    'first_active_cohort' => $firstCohort
                ];
            } catch (\Throwable $pe) {
                $diag['training_probe'] = [
                    'status' => 'error',
                    'message' => $pe->getMessage(),
                    'file' => basename($pe->getFile()),
                    'line' => $pe->getLine()
                ];
            }

            $status['diag'] = $diag;
        }

        http_response_code(200);
        echo json_encode($status, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}
