<?php
require_once "config/config.php";
require_once "config/database.php";
require_once "utils/Utils.php";

$database = new Database();
$db = $database->getConnection();

if (!$db) {
    die("Connection failed\n");
}

// Categories
$categories = [
    ['name' => 'Security', 'slug' => 'security', 'icon_name' => 'security'],
    ['name' => 'Engineering', 'slug' => 'engineering', 'icon_name' => 'engineering'],
    ['name' => 'AI & Data', 'slug' => 'ai-data', 'icon_name' => 'analytics'],
    ['name' => 'Energy', 'slug' => 'energy', 'icon_name' => 'bolt'],
    ['name' => 'Robotics', 'slug' => 'robotics', 'icon_name' => 'precision_manufacturing']
];

$catStmt = $db->prepare("INSERT IGNORE INTO blog_categories (uuid, name, slug, icon_name) VALUES (?, ?, ?, ?)");
foreach ($categories as $cat) {
    $catStmt->execute([Utils::generateUUID(), $cat['name'], $cat['slug'], $cat['icon_name']]);
}

// Get category IDs
$catIds = $db->query("SELECT id, slug FROM blog_categories")->fetchAll(PDO::FETCH_KEY_PAIR);
$catMap = array_flip($catIds);

// Blogs
$blogs = [
    [
        'category_id' => $catMap['security'],
        'title' => 'Quantum-Resistant Encryption Protocols',
        'slug' => 'quantum-resistant-encryption-protocols',
        'summary' => 'An analysis of post-quantum cryptographic standards and their integration into existing industrial infrastructure.',
        'content' => '<div class="abstract">An analysis of post-quantum cryptographic standards and their integration into existing industrial infrastructure.</div><h2>The Post-Quantum Threat</h2><p>As quantum computing evolves from a theoretical construct into a scalable reality, traditional asymmetric encryption modules—specifically those based on integer factorization like RSA—face an existential threat. Our research indicates that a sufficiently large quantum processor could decrypt legacy data streams in a fraction of the time required by classical supercomputers.</p><div class="callout"><h5><span class="material-symbols-outlined">analytics</span> Key Findings</h5><p>By 2028, over 65% of existing industrial IoT control loops will be susceptible to intercepted \'harvest-now, decrypt-later\' attacks unless post-quantum cryptographic (PQC) wrapping is implemented at the edge.</p></div><h2>Cryptographic Resilience</h2><p>Spider Tech\'s implementation strategy focuses on Lattice-based cryptography. Unlike classical schemes, lattice-based algorithms provide security by relying on the hardness of high-dimensional geometric problems, which remain computationally infeasible for both classical and early-stage quantum hardware.</p><img src="https://images.unsplash.com/photo-1558494949-ef0109124b24?q=80&w=2031&auto=format&fit=crop" class="article-img" alt="Server Hardware"><p>Our integration phase involves a hybrid approach where current RSA/ECC modules are layered with PQC signatures. This ensures backward compatibility while providing futuristic security assurance for multi-decade industrial deployments.</p><h2>Future Horizons</h2><p>The transition to a quantum-proof state is not merely a software update; it is an architectural overhaul. At Spider Tech, we are pioneering the \'Quantum-Ready\' certification for industrial hardware, ensuring that our clients\' global logistics and energy grids remain resilient against the next generation of computational warfare.</p>',
        'image_path' => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?q=80&w=2070&auto=format&fit=crop'
    ],
    [
        'category_id' => $catMap['engineering'],
        'title' => 'Industrial Edge Computing Paradigms',
        'slug' => 'industrial-edge-computing-paradigms',
        'summary' => 'Reducing latency in manufacturing plants through decentralized processing units and real-time data orchestration.',
        'content' => '<p>Reducing latency in manufacturing plants through decentralized processing units and real-time data orchestration.</p>',
        'image_path' => 'https://images.unsplash.com/photo-1558494949-ef0109124b24?q=80&w=2031&auto=format&fit=crop'
    ],
    [
        'category_id' => $catMap['ai-data'],
        'title' => 'Predictive Supply Chain 4.0',
        'slug' => 'predictive-supply-chain-40',
        'summary' => 'Utilizing neural networks to forecast global logistics disruptions and optimize multi-modal freight routes.',
        'content' => '<p>Utilizing neural networks to forecast global logistics disruptions and optimize multi-modal freight routes.</p>',
        'image_path' => 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?q=80&w=2070&auto=format&fit=crop'
    ],
    [
        'category_id' => $catMap['energy'],
        'title' => 'Automated Grid Resilience Systems',
        'slug' => 'automated-grid-resilience-systems',
        'summary' => 'Self-healing microgrid technologies for high-density urban environments and industrial complexes.',
        'content' => '<p>Self-healing microgrid technologies for high-density urban environments and industrial complexes.</p>',
        'image_path' => 'https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?q=80&w=2070&auto=format&fit=crop'
    ],
    [
        'category_id' => $catMap['ai-data'],
        'title' => 'Neural Network Optimization',
        'slug' => 'neural-network-optimization',
        'summary' => 'Techniques for pruning and quantizing large language models for deployment on resource-constrained hardware.',
        'content' => '<p>Techniques for pruning and quantizing large language models for deployment on resource-constrained hardware.</p>',
        'image_path' => 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?q=80&w=2070&auto=format&fit=crop'
    ]
];

$blogStmt = $db->prepare("INSERT IGNORE INTO blogs (uuid, category_id, title, slug, summary, content, image_path) VALUES (?, ?, ?, ?, ?, ?, ?)");
foreach ($blogs as $blog) {
    $blogStmt->execute([
        Utils::generateUUID(),
        $blog['category_id'],
        $blog['title'],
        $blog['slug'],
        $blog['summary'],
        $blog['content'],
        $blog['image_path']
    ]);
}

echo "Seeding complete.\n";
