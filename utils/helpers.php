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
    if (empty($path)) return BASE_URL . '/' . $fallback;

    // 1. Return as is if already a full URL
    if (strpos($path, 'http') === 0) return $path;

    // 2. Normalize by removing leading './' or '../'
    $cleanPath = ltrim($path, './');

    // 3. If it starts with images/ or img/ or uploads/, assume it is correct
    if (preg_match('#^(images/|img/|uploads/)#i', $cleanPath)) {
        return BASE_URL . '/' . $cleanPath;
    }

    // 4. Legacy fallback: Check common directories if it is just a filename
    $searchDirs = ['images/pictures/', 'images/events/', 'images/blog/', 'img/'];
    foreach ($searchDirs as $dir) {
        if (file_exists(ROOT_PATH . '/' . $dir . $cleanPath)) {
            return BASE_URL . '/' . $dir . $cleanPath;
        }
    }

    // 5. Default to the clean path if no match found
    return BASE_URL . '/' . $cleanPath;
}
?>