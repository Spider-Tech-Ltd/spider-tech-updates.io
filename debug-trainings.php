<?php
require('includes/connect.php');

echo "<h2>Database Debug - Trainings Data</h2>";

// Check all trainings
$select = $conn->prepare("SELECT * FROM trainings_tb");
$select->execute();
$trainings = $select->fetchAll(PDO::FETCH_ASSOC);

echo "<h3>Total Records: " . count($trainings) . "</h3>";

foreach ($trainings as $training) {
    echo "<div style='border: 1px solid #ccc; padding: 15px; margin: 10px 0;'>";
    echo "<p><strong>ID:</strong> " . htmlspecialchars($training['id']) . "</p>";
    echo "<p><strong>Name:</strong> " . htmlspecialchars($training['training_name']) . "</p>";
    echo "<p><strong>Image URL:</strong> " . htmlspecialchars($training['training_image'] ?? 'NOT SET') . "</p>";
    echo "<p><strong>Description Length:</strong> " . strlen($training['training_description'] ?? '') . " characters</p>";
    echo "<p><strong>Image Accessible:</strong> ";
    
    // Check if image URL is accessible
    if (isset($training['training_image']) && !empty($training['training_image'])) {
        $headers = @get_headers($training['training_image'], 1);
        if ($headers && strpos($headers[0], '200') !== false) {
            echo "✓ Yes (HTTP 200)";
        } else {
            echo "✗ No (Not accessible)";
        }
    } else {
        echo "✗ No image URL";
    }
    echo "</p>";
    echo "<p><strong>Test Link:</strong> <a href='program-detail.php?id=" . $training['id'] . "'>View Detail Page</a></p>";
    echo "</div>";
}

echo "<hr>";
echo "<p><a href='trainings.php'>Back to Trainings Page</a></p>";
?>
