<?php
ob_start();
include('pages/blog/index.php');
$output = ob_get_clean();
if (strpos($output, 'site-footer') !== false) {
    echo "Footer is present in HTML output\n";
} else {
    echo "Footer is MISSING in HTML output\n";
    echo "Last 500 chars of output:\n";
    echo substr($output, -500);
}
?>
