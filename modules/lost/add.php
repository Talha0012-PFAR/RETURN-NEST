<?php
require_once '../../includes/config.php';

// Check if user is logged in
if (!isLoggedIn()) {
    $_SESSION['message'] = 'Please login to report a lost item.';
    $_SESSION['message_type'] = 'warning';
    redirect('../auth/login.php');
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item_name   = sanitize($_POST['item_name']);
    $description = sanitize($_POST['description']);
    $category    = sanitize($_POST['category']);
    $location    = sanitize($_POST['location']);
    $date_lost   = $_POST['date_lost'];
    
    if (empty($item_name) || empty($location) || empty($date_lost)) {
        $error = 'Please fill in all required fields.';
    } else {
        global $pdo;
        
        $image_filename = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $image_filename = uploadImage($_FILES['image'], '../../uploads/');
            if (!$image_filename) {
                $error = 'Failed to upload image. Please try again.';
            }
        }
        
        if (!$error) {
            $stmt = $pdo->prepare("
                INSERT INTO lost_items 
                (user_id, item_name, description, category, location, date_lost, image, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, 'approved')
            ");
            
            if ($stmt->execute([
                $_SESSION['user_id'],
                $item_name,
                $description,
                $category,
                $location,
                $date_lost,
                $image_filename
            ])) {
                $success = 'Lost item reported successfully! It is now visible to everyone.';
            } else {
                $error = 'Failed to report lost item. Please try again.';
            }
        }
    }
}

$page_title = 'Report Lost Item';
include '../../includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-danger text-white">
                <h4 class="mb-0"><i class="fas fa-exclamation-triangle"></i> Report Lost Item</h4>
            </div>
            <div class="card-body">
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="item_name" class="form-label">Item Name *</label>
                                <input type="text" class="form-control" id="item_name" name="item_name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-select" id="category" name="category">
                                    <option value="">Select Category</option>
                                    <option value="Electronics">Electronics</option>
                                    <option value="Jewelry">Jewelry</option>
                                    <option value="Clothing">Clothing</option>
                                    <option value="Books">Books</option>
                                    <option value="Keys">Keys</option>
                                    <option value="Wallet">Wallet</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Describe your lost item..."></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="location" class="form-label">Location Lost *</label>
                                <input type="text" class="form-control" id="location" name="location" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="date_lost" class="form-label">Date Lost *</label>
                                <input type="date" class="form-control" id="date_lost" name="date_lost" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="image" class="form-label">Item Image (Optional)</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        <div class="form-text">Upload a photo of the item (max 5MB, JPG, PNG, GIF)</div>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="list.php" class="btn btn-secondary me-md-2">Cancel</a>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-plus"></i> Report Lost Item
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
