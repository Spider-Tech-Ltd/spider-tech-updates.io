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
    $path = trim($path ?? '');
    if (empty($path)) return BASE_URL . '/' . $fallback;

    // 1. Return as is if already a full URL
    if (preg_match('#^https?://#i', $path)) return $path;

    // 2. Robust normalization: strip any number of leading ../ or ./ or /
    $cleanPath = preg_replace('#^([\./]+|/)+#', '', $path);

    // 3. High-confidence check: Does the cleaned path point to a real file?
    if (file_exists(ROOT_PATH . '/' . $cleanPath)) {
        return BASE_URL . '/' . $cleanPath;
    }

    // 4. Legacy Search: If just a filename, look in common media folders
    $filename = basename($path);
    $searchDirs = ['images/pictures/', 'images/events/', 'images/blog/', 'img/'];
    foreach ($searchDirs as $dir) {
        if (file_exists(ROOT_PATH . '/' . $dir . $filename)) {
            return BASE_URL . '/' . $dir . $filename;
        }
    }

    // 5. Asset Folder Fallback: If it starts with a known folder, trust it even if file_exists fails (permissions etc)
    if (preg_match('#^(images/|img/|uploads/)#i', $cleanPath)) {
        return BASE_URL . '/' . $cleanPath;
    }

    // 6. Final safety: return as root-relative path if nothing else worked
    return BASE_URL . '/' . $cleanPath;
}
?>