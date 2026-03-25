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
?>