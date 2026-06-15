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

    // 3. Strip leading relative markers (../, ./) and slashes
    $cleanPath = preg_replace('#^([\./]+|/)+#', '', $normalized);

    // 4. Check if it already starts with common folders - If so, trust it
    if (preg_match('#^(images/|img/|uploads/)#i', $cleanPath)) {
        return BASE_URL . '/' . $cleanPath;
    }

    // 5. Filename-only fallback search (Legacy)
    $filename = basename($normalized);
    $searchDirs = ['images/pictures/', 'images/events/', 'images/blog/', 'img/', 'uploads/'];
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

    // 6. Final fallback: Prepend BASE_URL to the cleaned path
    return (!empty($cleanPath)) ? BASE_URL . '/' . $cleanPath : BASE_URL . '/' . ltrim($fallback, '/');
}

/**
 * Extracts YouTube Video ID and returns an embed URL.
 */
function getYouTubeEmbedUrl($url) {
    $video_id = '';
    if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
        $video_id = $match[1];
    }
    return $video_id ? 'https://www.youtube.com/embed/' . $video_id : $url;
}
?>