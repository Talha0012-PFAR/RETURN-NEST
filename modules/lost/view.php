<?php
require_once '../../includes/config.php';

$page_title = 'View Lost Item';
include '../../includes/header.php';

$pdo = getDBConnection();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$id) {
    $_SESSION['message'] = 'Invalid item ID.';
    $_SESSION['message_type'] = 'danger';
    redirect('list.php');
}

// Get item details
$stmt = $pdo->prepare("SELECT li.*, u.name as user_name, u.email as user_email FROM lost_items li 
                      JOIN users u ON li.user_id = u.id 
                      WHERE li.id = ? AND li.status = 'approved'");
$stmt->execute([$id]);
$item = $stmt->fetch();

if (!$item) {
    $_SESSION['message'] = 'Item not found or not approved.';
    $_SESSION['message_type'] = 'danger';
    redirect('list.php');
}

// Get similar found items for potential matches
$similar_found = $pdo->prepare("SELECT fi.*, u.name as user_name FROM found_items fi 
                               JOIN users u ON fi.user_id = u.id 
                               WHERE fi.status = 'approved' 
                               AND (fi.item_name LIKE ? OR fi.description LIKE ?) 
                               ORDER BY fi.created_at DESC LIMIT 5");
$search_term = "%{$item['item_name']}%";
$similar_found->execute([$search_term, $search_term]);
$similar_items = $similar_found->fetchAll();
?>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-danger text-white">
                <h4 class="mb-0"><i class="fas fa-exclamation-triangle"></i> Lost Item Details</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <?php if ($item['image']): ?>
                            <img src="../../uploads/<?php echo htmlspecialchars($item['image']); ?>" class="img-fluid rounded" alt="Item Image">
                        <?php else: ?>
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 300px;">
                                <i class="fas fa-image fa-4x text-muted"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <h3><?php echo htmlspecialchars($item['item_name']); ?></h3>
                        
                        <?php if ($item['category']): ?>
                            <span class="badge bg-secondary mb-3"><?php echo htmlspecialchars($item['category']); ?></span>
                        <?php endif; ?>
                        
                        <?php if ($item['description']): ?>
                            <p class="lead"><?php echo nl2br(htmlspecialchars($item['description'])); ?></p>
                        <?php endif; ?>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <strong><i class="fas fa-map-marker-alt text-danger"></i> Location Lost:</strong><br>
                                    <?php echo htmlspecialchars($item['location']); ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <strong><i class="fas fa-calendar text-danger"></i> Date Lost:</strong><br>
                                    <?php echo date('F d, Y', strtotime($item['date_lost'])); ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <strong><i class="fas fa-user text-danger"></i> Reported By:</strong><br>
                                    <?php echo htmlspecialchars($item['user_name']); ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <strong><i class="fas fa-clock text-danger"></i> Reported On:</strong><br>
                                    <?php echo date('F d, Y \a\t g:i A', strtotime($item['created_at'])); ?>
                                </div>
                            </div>
                        </div>
                        
                        <?php if (isLoggedIn() && $_SESSION['user_id'] != $item['user_id']): ?>
                            <div class="mt-4">
                                <a href="mailto:<?php echo htmlspecialchars($item['user_email']); ?>?subject=Regarding your lost item: <?php echo urlencode($item['item_name']); ?>" class="btn btn-primary">
                                    <i class="fas fa-envelope"></i> Contact Owner
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <!-- Similar Found Items -->
        <?php if (!empty($similar_items)): ?>
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-hand-holding-heart"></i> Similar Found Items</h5>
                </div>
                <div class="card-body">
                    <?php foreach ($similar_items as $found_item): ?>
                        <div class="card mb-3 border-success">
                            <div class="card-body">
                                <h6 class="card-title"><?php echo htmlspecialchars($found_item['item_name']); ?></h6>
                                <?php if ($found_item['description']): ?>
                                    <p class="card-text small"><?php echo htmlspecialchars(substr($found_item['description'], 0, 80)) . (strlen($found_item['description']) > 80 ? '...' : ''); ?></p>
                                <?php endif; ?>
                                <div class="small text-muted mb-2">
                                    <div><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($found_item['location']); ?></div>
                                    <div><i class="fas fa-calendar"></i> <?php echo date('M d, Y', strtotime($found_item['date_found'])); ?></div>
                                </div>
                                <a href="../found/view.php?id=<?php echo $found_item['id']; ?>" class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-eye"></i> View Details
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Quick Actions -->
        <div class="card shadow mt-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-tools"></i> Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="list.php" class="btn btn-outline-primary">
                        <i class="fas fa-list"></i> Back to Lost Items
                    </a>
                    <?php if (isLoggedIn()): ?>
                        <a href="../found/add.php" class="btn btn-outline-success">
                            <i class="fas fa-plus"></i> Report Found Item
                        </a>
                    <?php endif; ?>
                    <a href="../../index.php" class="btn btn-outline-secondary">
                        <i class="fas fa-home"></i> Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
