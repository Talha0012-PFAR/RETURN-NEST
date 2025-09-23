<?php
require_once '../../includes/config.php';

$page_title = 'Found Items';
include '../../includes/header.php';

$pdo = getDBConnection();

// Search functionality
$search = isset($_GET['search']) ? sanitize($_GET['search']) : '';

$where_conditions = ["status = 'approved'"];
$params = [];

if ($search) {
    $where_conditions[] = "(item_name LIKE ? OR description LIKE ? OR location LIKE ?)";
    $search_param = "%$search%";
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
}

$where_clause = implode(' AND ', $where_conditions);

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 12;
$offset = ($page - 1) * $per_page;

$count_stmt = $pdo->prepare("SELECT COUNT(*) FROM found_items WHERE $where_clause");
$count_stmt->execute($params);
$total_items = $count_stmt->fetchColumn();
$total_pages = ceil($total_items / $per_page);

// Get items
$stmt = $pdo->prepare("SELECT fi.*, u.name as user_name FROM found_items fi 
                      JOIN users u ON fi.user_id = u.id 
                      WHERE $where_clause 
                      ORDER BY fi.created_at DESC 
                      LIMIT ? OFFSET ?");
$params[] = $per_page;
$params[] = $offset;
$stmt->execute($params);
$items = $stmt->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-hand-holding-heart text-success"></i> Found Items</h2>
    <?php if (isLoggedIn()): ?>
        <a href="add.php" class="btn btn-success">
            <i class="fas fa-plus"></i> Report Found Item
        </a>
    <?php endif; ?>
</div>

<!-- Search -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="" class="row g-3">
            <div class="col-md-8">
                <input type="text" class="form-control" name="search" placeholder="Search items..." value="<?php echo htmlspecialchars($search); ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search"></i> Search
                </button>
            </div>
            <div class="col-md-2">
                <a href="list.php" class="btn btn-secondary w-100">
                    <i class="fas fa-times"></i> Clear
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Results Count -->
<div class="mb-3">
    <p class="text-muted">Showing <?php echo $total_items; ?> found item<?php echo $total_items != 1 ? 's' : ''; ?></p>
</div>

<!-- Items Grid -->
<?php if (empty($items)): ?>
    <div class="text-center py-5">
        <i class="fas fa-search fa-3x text-muted mb-3"></i>
        <h4 class="text-muted">No found items found</h4>
        <p class="text-muted">Try adjusting your search criteria or check back later.</p>
    </div>
<?php else: ?>
    <div class="row">
        <?php foreach ($items as $item): ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <?php if ($item['image']): ?>
                        <img src="../../uploads/<?php echo htmlspecialchars($item['image']); ?>" class="card-img-top" alt="Item Image" style="height: 200px; object-fit: cover;">
                    <?php else: ?>
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="fas fa-image fa-3x text-muted"></i>
                        </div>
                    <?php endif; ?>
                    
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($item['item_name']); ?></h5>
                        
                        <?php if ($item['description']): ?>
                            <p class="card-text"><?php echo htmlspecialchars(substr($item['description'], 0, 100)) . (strlen($item['description']) > 100 ? '...' : ''); ?></p>
                        <?php endif; ?>
                        
                        <div class="small text-muted mb-3">
                            <div><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($item['location']); ?></div>
                            <div><i class="fas fa-calendar"></i> <?php echo date('M d, Y', strtotime($item['date_found'])); ?></div>
                            <div><i class="fas fa-user"></i> <?php echo htmlspecialchars($item['user_name']); ?></div>
                        </div>
                        
                        <a href="view.php?id=<?php echo $item['id']; ?>" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-eye"></i> View Details
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
    <!-- Pagination -->
    <?php if ($total_pages > 1): ?>
        <nav aria-label="Found items pagination">
            <ul class="pagination justify-content-center">
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>">Previous</a>
                    </li>
                <?php endif; ?>
                
                <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
                    <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                
                <?php if ($page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>">Next</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    <?php endif; ?>
<?php endif; ?>

<?php include '../../includes/footer.php'; ?>
