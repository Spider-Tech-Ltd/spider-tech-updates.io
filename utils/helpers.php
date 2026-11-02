<?php
function cleanHTML($htmlValue)
{
  $allowedTags = '<h1><h2><h3><h4><h5><h6><p><br><ul><ol><li><strong><b><em><i><u><a>';
  $clean = strip_tags($htmlValue, $allowedTags);
  $clean = preg_replace('/\s+/', ' ', $clean);
  $clean = trim($clean);
  $clean = preg_replace_callback('#<a\s+([^>]+)>#i', function ($matches) {
    $attrs = $matches[1];
    $href = '';
    if (preg_match('/href\s*=\s*"([^"]+)"/i', $attrs, $h)) {
      $href = trim($h[1]);
    } elseif (preg_match('/href\s*=\s*\'([^\']+)\'/i', $attrs, $h)) {
      $href = trim($h[1]);
    }
    if ($href && !preg_match('/^(javascript:)/i', $href)) {
      return '<a href="' . htmlspecialchars($href) . '" rel="noopener noreferrer" target="_blank">';
    }
    return '<a>';
  }, $clean);
  return $clean;
}

/**
 * Robustly resolves image paths for both new and legacy assets.
 * Handles absolute URLs, root-relative paths, and legacy filenames.
 */
function resolvePath($path, $fallback = 'images/placeholder-banner.jpg') {
    $path = trim((string)($path ?? ''));
    if (empty($path)) return BASE_URL . '/' . ltrim($fallback, '/');

    // 1. Full URL check
    if (filter_var($path, FILTER_VALIDATE_URL) || strpos($path, 'http') === 0) return $path;

    // 2. Normalize markers
    $normalized = str_replace('\\', '/', $path);

    // 3. Handle Absolute OS Paths (e.g. C:/xampp/htdocs/...)
    // Extract part after ROOT_PATH if it exists within it
    $rootPathNormalized = str_replace('\\', '/', ROOT_PATH);
    if (stripos($normalized, $rootPathNormalized) !== false) {
        $normalized = substr($normalized, strlen($rootPathNormalized));
    }

    // 4. Strip leading relative markers (../, ./) and slashes
    $cleanPath = preg_replace('#^([\./]+|/)+#', '', $normalized);

    // 5. Check if it already starts with common folders - If so, trust it
    if (preg_match('#^(images/|img/|uploads/|assets/)#i', $cleanPath)) {
        return BASE_URL . '/' . $cleanPath;
    }

    // 6. Filename-only fallback search (Legacy/Lost Assets)
    $filename = basename($normalized);
    $searchDirs = ['images/pictures/', 'images/events/', 'images/blog/', 'images/banners/', 'img/', 'uploads/', 'assets/img/'];
    foreach ($searchDirs as $dir) {
        $dirPath = ROOT_PATH . '/' . ltrim($dir, '/');

        // Exact match
        if (file_exists($dirPath . $filename)) {
            return BASE_URL . '/' . ltrim($dir, '/') . $filename;
        }

        // Truncation fallback: if name is 64 chars (common VARCHAR limit), search for prefix
        if (strlen($filename) >= 60) {
            $prefix = substr($filename, 0, 50);
            $matches = glob($dirPath . $prefix . "*");
            if ($matches && count($matches) > 0) {
                return BASE_URL . '/' . ltrim($dir, '/') . basename($matches[0]);
            }
        }
    }

    // 7. Final fallback: Prepend BASE_URL to the cleaned path
    return (!empty($cleanPath)) ? BASE_URL . '/' . $cleanPath : BASE_URL . '/' . ltrim($fallback, '/');
}

/**
 * Extracts YouTube Video ID and returns an embed URL with autoplay enabled.
 */
function getYouTubeEmbedUrl($url) {
    $video_id = '';
    if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
        $video_id = $match[1];
    }
    // Autoplay requires mute=1 to work in most browsers without user interaction
    // controls=1 (default) ensures the seek bar and pause/play buttons are visible
    return $video_id ? "https://www.youtube.com/embed/{$video_id}?autoplay=1&mute=1&loop=1&playlist={$video_id}&rel=0&controls=1" : $url;
}

/**
 * Normalizes Instagram URLs to embed format.
 */
function getInstagramEmbedUrl($url) {
    // Strip query parameters
    $clean_url = strtok($url, '?');
    $clean_url = rtrim($clean_url, '/');

    // Ensure it's an embed URL
    if (strpos($clean_url, '/embed') === false) {
        $clean_url .= '/embed/';
    }
    return $clean_url;
}

/**
 * Normalizes Facebook URLs to embed format.
 */
function getFacebookEmbedUrl($url) {
    $clean_url = strtok($url, '?');

    // Determine if it's a video or a post
    $is_video = (strpos($url, '/videos/') !== false || strpos($url, '/watch/') !== false || strpos($url, 'fb.watch') !== false);
    $plugin = $is_video ? 'video.php' : 'post.php';
    // Use 1/0 for boolean params in Facebook plugins
    $params = $is_video ? "&autoplay=1&mute=1&show_captions=0" : "";

    return "https://www.facebook.com/plugins/{$plugin}?href=" . urlencode($url) . "&show_text=false&width=500" . $params;
}
/**
 * Formats an amount in kobo into a Nigerian Naira string with the ₦ symbol.
 * Uses whole naira without decimals (e.g. ₦50,000) unless kobo is non-zero
 * or $forceDecimals is explicitly true.
 *
 * @param int|float|numeric-string $amountKobo Amount in kobo
 * @param bool $forceDecimals Whether to always show two decimal places
 * @return string Formatted string, e.g. "₦50,000" or "₦50,000.50"
 */
function format_naira($amountKobo, bool $forceDecimals = false): string
{
    $amountKobo = (int) round((float) $amountKobo);
    $naira = $amountKobo / 100;
    if ($forceDecimals || ($amountKobo % 100 !== 0)) {
        return '₦' . number_format($naira, 2);
    }
    return '₦' . number_format($naira);
}

/**
 * Resolves the dynamic status badge data for a training program and cohort.
 * Replaces hardcoded strings and brittle acronym logic.
 *
 * @param array $training Training record from database
 * @param array|null $cohort Active or upcoming cohort record, if any
 * @return array{cohort_name: string, status: string, badge_text: string, status_class: string, dot_class: string}
 */
function resolve_training_status_badge(array $training, ?array $cohort = null): array
{
    // 1. Resolve Cohort Name
    $cohortName = '';
    if (!empty($cohort['cohort_name'])) {
        $cohortName = trim($cohort['cohort_name']);
    } elseif (!empty($cohort['cohort_number'])) {
        $cohortName = 'Cohort ' . (int)$cohort['cohort_number'];
    }

    // 2. Resolve Status
    $status = 'Registration Open';
    $statusClass = 'open';
    $dotClass = 'cohort-pulse-dot';

    $trainingRegOpen = !empty($training['registration_available']);

    if (!$trainingRegOpen) {
        $status = 'Registration Closed';
        $statusClass = 'closed';
        $dotClass = 'cohort-dot-closed';
    } elseif ($cohort === null) {
        $status = 'Registration Open';
        $statusClass = 'open';
        $dotClass = 'cohort-pulse-dot';
    } else {
        $cohortStatus = strtolower(trim($cohort['status'] ?? ''));
        $startDate = !empty($cohort['start_date']) ? strtotime($cohort['start_date']) : null;
        $endDate = !empty($cohort['end_date']) ? strtotime($cohort['end_date']) : null;
        $deadline = !empty($cohort['registration_deadline']) ? strtotime($cohort['registration_deadline']) : null;
        $capacity = (int)($cohort['capacity'] ?? 0);
        $registrations = isset($cohort['total_registrations']) ? (int)$cohort['total_registrations'] : 0;
        $regOpen = !empty($cohort['registration_open']);
        $today = strtotime('today');
        $now = time();

        if ($cohortStatus === 'completed' || ($endDate !== null && $endDate < $today)) {
            $status = 'Completed';
            $statusClass = 'completed';
            $dotClass = 'cohort-dot-completed';
        } elseif ($startDate !== null && $startDate <= $today && ($endDate === null || $endDate >= $today) && (!$regOpen || ($deadline !== null && $deadline < $now))) {
            $status = 'Ongoing';
            $statusClass = 'ongoing';
            $dotClass = 'cohort-dot-ongoing';
        } elseif ($capacity > 0 && $registrations >= $capacity) {
            $status = 'Registration Closed';
            $statusClass = 'closed';
            $dotClass = 'cohort-dot-closed';
        } elseif ($deadline !== null && $deadline < $now) {
            $status = 'Registration Closed';
            $statusClass = 'closed';
            $dotClass = 'cohort-dot-closed';
        } elseif (!$regOpen) {
            if ($startDate !== null && $startDate > $today) {
                $status = 'Coming Soon';
                $statusClass = 'upcoming';
                $dotClass = 'cohort-dot-upcoming';
            } else {
                $status = 'Registration Closed';
                $statusClass = 'closed';
                $dotClass = 'cohort-dot-closed';
            }
        } else {
            $status = 'Registration Open';
            $statusClass = 'open';
            $dotClass = 'cohort-pulse-dot';
        }
    }

    // 3. Compose Badge Text: {Cohort Name} · {Status}
    if (!empty($cohortName)) {
        $badgeText = $cohortName . ' · ' . $status;
    } else {
        $badgeText = $status;
    }

    return [
        'cohort_name'  => $cohortName,
        'status'       => $status,
        'badge_text'   => $badgeText,
        'status_class' => $statusClass,
        'dot_class'    => $dotClass
    ];
}

/**
 * Resolves a dynamic, cleanly formatted CTA button label.
 * Avoids hardcoded strings while preventing button overflows on mobile.
 *
 * @param string $trainingName Training program title
 * @param string|null $cohortName Cohort name if available
 * @param int $maxLength Maximum character length before truncation
 * @return string Formatted label (e.g. "Enroll in we Digitize – Cohort 1")
 */
function resolve_enroll_button_label(string $trainingName, ?string $cohortName = null, int $maxLength = 38): string
{
    $title = trim(strip_tags($trainingName));
    if (empty($title)) {
        return 'Enroll Now';
    }

    $base = 'Enroll in ' . $title;
    if (!empty($cohortName)) {
        $candidate = $base . ' – ' . trim($cohortName);
        if (mb_strlen($candidate) <= $maxLength) {
            return $candidate;
        }
    }

    if (mb_strlen($base) > $maxLength) {
        return mb_substr($base, 0, $maxLength - 1) . '…';
    }

    return $base;
}
