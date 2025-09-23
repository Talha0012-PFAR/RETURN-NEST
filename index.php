<?php
// index.php (PDO-based)
// Make sure includes/config.php defines $pdo

require_once __DIR__ . '/includes/config.php';   // creates $pdo
$page_title = 'Home';
include __DIR__ . '/includes/header.php';         // ensure file exists

// Safe queries using PDO
try {
    // recent lost
    $stmt = $pdo->query("SELECT * FROM lost_items WHERE status = 'approved' ORDER BY created_at DESC LIMIT 6");
    $recent_lost = $stmt->fetchAll();

    // recent found
    $stmt = $pdo->query("SELECT * FROM found_items WHERE status = 'approved' ORDER BY created_at DESC LIMIT 6");
    $recent_found = $stmt->fetchAll();

    // statistics
    $total_lost = (int) $pdo->query("SELECT COUNT(*) FROM lost_items WHERE status = 'approved'")->fetchColumn();
    $total_found = (int) $pdo->query("SELECT COUNT(*) FROM found_items WHERE status = 'approved'")->fetchColumn();
    $total_matches = (int) $pdo->query("SELECT COUNT(*) FROM matches WHERE status = 'confirmed'")->fetchColumn();
} catch (PDOException $e) {
    // handle DB errors gracefully
    // you can log $e->getMessage() to a file instead of echoing in production
    echo '<div class="alert alert-danger">Database error: ' . htmlspecialchars($e->getMessage()) . '</div>';
    $recent_lost = $recent_found = [];
    $total_lost = $total_found = $total_matches = 0;
}
?>

<!-- Hero Section -->
<div class="hero-section bg-primary text-white py-5 mb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="display-4 fw-bold mb-3">
                    <i class="fas fa-search-location"></i> Lost & Found
                </h1>
                <p class="lead mb-4">Find your lost items or help others find theirs. Our community-driven platform connects lost items with their rightful owners.</p>
                <div class="d-flex gap-3">
                    <a href="modules/lost/add.php" class="btn btn-light btn-lg">
                        <i class="fas fa-plus"></i> Report Lost Item
                    </a>
                    <a href="modules/found/add.php" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-hand-holding-heart"></i> Report Found Item
                    </a>
                </div>
            </div>
            <div class="col-md-6 text-center">
                <i class="fas fa-search-location" style="font-size: 8rem; opacity: 0.3;"></i>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Section -->
<div class="container mb-5">
    <div class="row text-center">
        <div class="col-md-4 mb-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                    <h3 class="card-title"><?= $total_lost ?></h3>
                    <p class="card-text">Lost Items</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <i class="fas fa-hand-holding-heart fa-3x mb-3"></i>
                    <h3 class="card-title"><?= $total_found ?></h3>
                    <p class="card-text">Found Items</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <i class="fas fa-check-circle fa-3x mb-3"></i>
                    <h3 class="card-title"><?= $total_matches ?></h3>
                    <p class="card-text">Successful Matches</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Items -->
<div class="container">
    <div class="row">
        <!-- Recent Lost Items -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><i class="fas fa-exclamation-triangle"></i> Recent Lost Items</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($recent_lost)): ?>
                        <p class="text-muted">No lost items found.</p>
                    <?php else: ?>
                        <?php foreach ($recent_lost as $item): ?>
                            <div class="card mb-2 border">
                                <div class="card-body">
                                    <h6 class="card-title"><?= htmlspecialchars($item['item_name']) ?></h6>
                                    <p class="small text-muted mb-1">
                                        <i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($item['location']) ?>,
                                        <i class="fas fa-calendar"></i> <?= date('M d, Y', strtotime($item['date_lost'])) ?>
                                    </p>
                                    <a href="modules/lost/view.php?id=<?= (int)$item['id'] ?>" class="btn btn-sm btn-outline-danger">View Details</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <div class="text-center mt-3">
                            <a href="modules/lost/list.php" class="btn btn-danger">View All Lost Items</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Recent Found Items -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-hand-holding-heart"></i> Recent Found Items</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($recent_found)): ?>
                        <p class="text-muted">No found items found.</p>
                    <?php else: ?>
                        <?php foreach ($recent_found as $item): ?>
                            <div class="card mb-2 border">
                                <div class="card-body">
                                    <h6 class="card-title"><?= htmlspecialchars($item['item_name']) ?></h6>
                                    <p class="small text-muted mb-1">
                                        <i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($item['location']) ?>,
                                        <i class="fas fa-calendar"></i> <?= date('M d, Y', strtotime($item['date_found'])) ?>
                                    </p>
                                    <a href="modules/found/view.php?id=<?= (int)$item['id'] ?>" class="btn btn-sm btn-outline-success">View Details</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <div class="text-center mt-3">
                            <a href="modules/found/list.php" class="btn btn-success">View All Found Items</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- How It Works -->
<div class="container mt-5">
    <div class="row text-center">
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <i class="fas fa-plus-circle fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">1. Report</h5>
                    <p class="card-text">Report a lost item or a found item with details and photos.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <i class="fas fa-search fa-3x text-warning mb-3"></i>
                    <h5 class="card-title">2. Search</h5>
                    <p class="card-text">Browse through listings to find matches.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <i class="fas fa-handshake fa-3x text-success mb-3"></i>
                    <h5 class="card-title">3. Connect</h5>
                    <p class="card-text">Contact the owner or finder to arrange the return.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
