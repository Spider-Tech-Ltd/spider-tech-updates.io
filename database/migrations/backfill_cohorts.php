<?php
/**
 * Migration & Backfill: Initialize Cohorts 1-3 and prepare Cohort 4 for Digital Skills for Entrepreneurs
 * Safe, idempotent, preserves all existing data.
 */
require_once dirname(__DIR__, 2) . '/config/config.php';
require_once dirname(__DIR__, 2) . '/config/database.php';

try {
    $db = (new Database())->getConnection();
    if (!$db) {
        throw new Exception("Database connection failed.");
    }

    $db->beginTransaction();
    echo "=== Cohort Backfill & Initialization ===\n";

    // Program 1: Digital Skills for Entrepreneurs
    $progStmt = $db->query("SELECT id, training_name FROM trainings_tb WHERE id = 1 LIMIT 1");
    $training = $progStmt->fetch(PDO::FETCH_ASSOC);
    if (!$training) {
        throw new Exception("Training ID 1 not found!");
    }
    echo "Found Target Training: ID {$training['id']} ({$training['training_name']})\n";

    $cohortDefs = [
        1 => [
            'name'       => 'Digital Skills for Entrepreneurs - Cohort 1',
            'slug'       => 'dse-cohort-1',
            'start_date' => '2024-07-01',
            'end_date'   => '2024-08-31',
            'open'       => 0,
            'status'     => 'completed',
            'capacity'   => 50,
            'deadline'   => '2024-06-30 23:59:59',
            'event_id'   => 10
        ],
        2 => [
            'name'       => 'Digital Skills for Entrepreneurs - Cohort 2',
            'slug'       => 'dse-cohort-2',
            'start_date' => '2024-09-01',
            'end_date'   => '2024-09-30',
            'open'       => 0,
            'status'     => 'completed',
            'capacity'   => 60,
            'deadline'   => '2024-08-31 23:59:59',
            'event_id'   => 11
        ],
        3 => [
            'name'       => 'Digital Skills for Entrepreneurs - Cohort 3',
            'slug'       => 'dse-cohort-3',
            'start_date' => '2024-10-14',
            'end_date'   => '2024-11-30',
            'open'       => 0,
            'status'     => 'completed',
            'capacity'   => 75,
            'deadline'   => '2024-10-13 23:59:59',
            'event_id'   => 12
        ],
        4 => [
            'name'       => 'Digital Skills for Entrepreneurs - Cohort 4',
            'slug'       => 'dse-cohort-4',
            'start_date' => '2026-11-16',
            'end_date'   => '2026-12-18',
            'open'       => 1, // Ready for registrations!
            'status'     => 'open',
            'capacity'   => 100,
            'deadline'   => '2026-11-15 23:59:59',
            'event_id'   => null
        ]
    ];

    $cohortIds = [];

    foreach ($cohortDefs as $cNum => $cData) {
        $check = $db->prepare("SELECT id FROM training_cohorts WHERE slug = ? LIMIT 1");
        $check->execute([$cData['slug']]);
        $existingId = $check->fetchColumn();

        if ($existingId) {
            $cohortIds[$cNum] = (int)$existingId;
            echo " - Cohort {$cNum} already exists (ID {$existingId}).\n";
        } else {
            $ins = $db->prepare("
                INSERT INTO training_cohorts (
                    training_id, cohort_number, cohort_name, slug, 
                    start_date, end_date, registration_open, registration_deadline, 
                    capacity, status
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $ins->execute([
                $training['id'],
                $cNum,
                $cData['name'],
                $cData['slug'],
                $cData['start_date'],
                $cData['end_date'],
                $cData['open'],
                $cData['deadline'],
                $cData['capacity'],
                $cData['status']
            ]);
            $newId = (int)$db->lastInsertId();
            $cohortIds[$cNum] = $newId;
            echo " - Created Cohort {$cNum} (ID {$newId}): {$cData['name']}\n";
        }

        // Link Event if specified
        if (!empty($cData['event_id'])) {
            $upEvent = $db->prepare("UPDATE events SET cohort_id = ? WHERE event_id = ? AND (cohort_id IS NULL OR cohort_id = 0)");
            $upEvent->execute([$cohortIds[$cNum], $cData['event_id']]);
            if ($upEvent->rowCount() > 0) {
                echo "   -> Linked Event ID {$cData['event_id']} to Cohort {$cNum}.\n";
            }
        }
    }

    // Backfill historical registrations in training_registrations for Program 1
    // Update existing row 1 (registered in March 2026 before cohort 4 existed) to Cohort 3
    if (isset($cohortIds[3])) {
        $upTr = $db->prepare("UPDATE training_registrations SET cohort_id = ? WHERE program_id = 1 AND cohort_id IS NULL");
        $upTr->execute([$cohortIds[3]]);
        if ($upTr->rowCount() > 0) {
            echo " - Updated {$upTr->rowCount()} existing Program 1 registration(s) to Cohort 3.\n";
        }
    }

    // Migrate historical records from bootcamp_application into training_registrations (Cohort 2)
    if (isset($cohortIds[2])) {
        $checkTable = $db->query("SHOW TABLES LIKE 'bootcamp_application'")->rowCount();
        if ($checkTable > 0) {
            $bApps = $db->query("SELECT * FROM bootcamp_application")->fetchAll(PDO::FETCH_ASSOC);
            $migratedCount = 0;
            foreach ($bApps as $ba) {
                // Check if already migrated
                $email = $ba['email'] ?? '';
                $chkMig = $db->prepare("
                    SELECT id FROM training_registrations 
                    WHERE program_id = 1 AND cohort_id = ? AND JSON_UNQUOTE(JSON_EXTRACT(user_data, '$.email')) = ?
                ");
                $chkMig->execute([$cohortIds[2], $email]);
                if (!$chkMig->fetchColumn()) {
                    $userData = json_encode([
                        'first_name'    => $ba['firstname'] ?? '',
                        'middle_name'   => $ba['middlename'] ?? '',
                        'last_name'     => $ba['lastname'] ?? '',
                        'email'         => $email,
                        'phone'         => $ba['phone_no'] ?? '',
                        'age'           => $ba['age'] ?? '',
                        'gender'        => $ba['gender'] ?? '',
                        'business_name' => $ba['business_name'] ?? '',
                        'reason'        => $ba['reason'] ?? ''
                    ]);
                    $insMig = $db->prepare("
                        INSERT INTO training_registrations (program_id, cohort_id, registration_type, user_data, created_at)
                        VALUES (1, ?, 'training', ?, ?)
                    ");
                    $insMig->execute([$cohortIds[2], $userData, $ba['apply_date'] ?? date('Y-m-d H:i:s')]);
                    $migratedCount++;
                }
            }
            if ($migratedCount > 0) {
                echo " - Migrated {$migratedCount} historical records from `bootcamp_application` into Cohort 2.\n";
            }
        }
    }

    // Migrate historical records from dse_application into training_registrations (Cohort 3)
    if (isset($cohortIds[3])) {
        $checkTable = $db->query("SHOW TABLES LIKE 'dse_application'")->rowCount();
        if ($checkTable > 0) {
            $dApps = $db->query("SELECT * FROM dse_application")->fetchAll(PDO::FETCH_ASSOC);
            $migratedDse = 0;
            foreach ($dApps as $da) {
                $email = $da['email'] ?? '';
                $chkMig = $db->prepare("
                    SELECT id FROM training_registrations 
                    WHERE program_id = 1 AND cohort_id = ? AND JSON_UNQUOTE(JSON_EXTRACT(user_data, '$.email')) = ?
                ");
                $chkMig->execute([$cohortIds[3], $email]);
                if (!$chkMig->fetchColumn()) {
                    $userData = json_encode([
                        'first_name'        => $da['firstname'] ?? '',
                        'middle_name'       => $da['middlename'] ?? '',
                        'last_name'         => $da['lastname'] ?? '',
                        'email'             => $email,
                        'phone'             => $da['phone_no'] ?? '',
                        'age'               => $da['age'] ?? '',
                        'gender'            => $da['gender'] ?? '',
                        'business_name'     => $da['business_name'] ?? '',
                        'business_section'  => $da['business_sector'] ?? '',
                        'years_of_experience' => $da['years'] ?? '',
                        'business_address'  => $da['business_location'] ?? ''
                    ]);
                    $insMig = $db->prepare("
                        INSERT INTO training_registrations (program_id, cohort_id, registration_type, user_data, created_at)
                        VALUES (1, ?, 'training', ?, ?)
                    ");
                    $insMig->execute([$cohortIds[3], $userData, $da['apply_date'] ?? date('Y-m-d H:i:s')]);
                    $migratedDse++;
                }
            }
            if ($migratedDse > 0) {
                echo " - Migrated {$migratedDse} historical records from `dse_application` into Cohort 3.\n";
            }
        }
    }

    $db->commit();
    echo "\nBackfill and initialization successfully committed!\n";

} catch (Exception $e) {
    if (isset($db) && $db->inTransaction()) {
        $db->rollBack();
    }
    echo "[ERROR] Backfill failed: " . $e->getMessage() . "\n";
    exit(1);
}
