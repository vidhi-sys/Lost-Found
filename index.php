<?php
include 'config.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['itemName'])) {
    $item_type = $_POST['itemType'];
    $item_name = $_POST['itemName'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    $contact_info = $_POST['contactInfo'] ?? '';
    
    try {
        $conn = getDBConnection();
        $sql = "INSERT INTO items (item_type, item_name, location, description, contact_info) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$item_type, $item_name, $location, $description, $contact_info]);
        
        $success = "Item reported successfully!";
    } catch(PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}

// Get all items
try {
    $conn = getDBConnection();
    $items = $conn->query("SELECT * FROM items WHERE status = 'active' ORDER BY reported_at DESC")->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $error = "Error loading items: " . $e->getMessage();
    $items = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIT Bhopal Lost & Found</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        :root { --primary: #8B0000; --primary-light: #A52A2A; --secondary: #FFD700; --dark: #333; --success: #28a745; --danger: #dc3545; }
        body { background-color: #f5f5f5; color: var(--dark); line-height: 1.6; }
        .container { width: 90%; max-width: 1200px; margin: 0 auto; padding: 20px; }
        header { background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white; padding: 1.5rem 0; text-align: center; margin-bottom: 2rem; }
        .card { background: white; border-radius: 8px; padding: 2rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-bottom: 2rem; }
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 600; }
        .form-control { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; }
        .radio-group { display: flex; gap: 20px; margin-top: 5px; }
        .radio-option { display: flex; align-items: center; gap: 5px; }
        textarea.form-control { min-height: 100px; resize: vertical; }
        .btn { background: var(--primary); color: white; padding: 12px 25px; border: none; border-radius: 5px; cursor: pointer; font-weight: 600; }
        .btn:hover { background: var(--primary-light); }
        .items-container { display: grid; gap: 1.5rem; }
        .item-card { background: white; border-radius: 8px; padding: 1.5rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-left: 4px solid var(--primary); }
        .item-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; }
        .item-type { padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; }
        .type-lost { background: #ffe6e6; color: var(--danger); }
        .type-found { background: #e6ffe6; color: var(--success); }
        .alert { padding: 12px 20px; border-radius: 4px; margin-bottom: 20px; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header>
        <div class="container">
            <div style="display: flex; align-items: center; justify-content: center; gap: 10px;">
                <i class="fas fa-search-location" style="font-size: 2rem;"></i>
                <h1 style="font-size: 1.8rem;">VIT <span style="color: var(--secondary);">Bhopal</span> Lost & Found</h1>
            </div>
        </div>
    </header>

    <div class="container">
        <?php if (isset($success)): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> <?php echo $success; ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <h2 style="margin-bottom: 1.5rem; padding-bottom: 10px; border-bottom: 2px solid var(--primary); color: var(--primary);">Report Lost or Found Item</h2>
            <form method="POST">
                <div class="form-group">
                    <label>Item Type</label>
                    <div class="radio-group">
                        <div class="radio-option">
                            <input type="radio" id="lost" name="itemType" value="lost" checked>
                            <label for="lost">I Lost Something</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" id="found" name="itemType" value="found">
                            <label for="found">I Found Something</label>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="itemName">Item Name *</label>
                    <input type="text" id="itemName" name="itemName" class="form-control" placeholder="e.g., Water Bottle, Notebook, Phone" required>
                </div>
                
                <div class="form-group">
                    <label for="location">Location *</label>
                    <input type="text" id="location" name="location" class="form-control" placeholder="e.g., AB1 Block, Cafeteria, Library" required>
                </div>
                
                <div class="form-group">
                    <label for="description">Description *</label>
                    <textarea id="description" name="description" class="form-control" placeholder="Provide detailed description of the item including color, brand, distinctive features, etc." required></textarea>
                </div>

                <div class="form-group">
                    <label for="contactInfo">Contact Information</label>
                    <input type="text" id="contactInfo" name="contactInfo" class="form-control" placeholder="Email or phone number (optional)">
                </div>
                
                <button type="submit" class="btn">Submit Report</button>
            </form>
        </div>

        <div class="card">
            <h2 style="margin-bottom: 1.5rem; padding-bottom: 10px; border-bottom: 2px solid var(--primary); color: var(--primary);">Recent Lost & Found Items</h2>
            <div class="items-container">
                <?php if (count($items) > 0): ?>
                    <?php foreach ($items as $item): ?>
                        <div class="item-card">
                            <div class="item-header">
                                <h3><?php echo htmlspecialchars($item['item_name']); ?></h3>
                                <span class="item-type <?php echo $item['item_type'] == 'lost' ? 'type-lost' : 'type-found'; ?>">
                                    <?php echo $item['item_type'] == 'lost' ? 'Lost' : 'Found'; ?>
                                </span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 5px; margin-bottom: 0.5rem; color: #6c757d;">
                                <i class="fas fa-map-marker-alt"></i>
                                <span><?php echo htmlspecialchars($item['location']); ?></span>
                            </div>
                            <div style="margin-bottom: 1rem;">
                                <p><?php echo htmlspecialchars($item['description']); ?></p>
                            </div>
                            <div style="display: flex; justify-content: space-between; color: #6c757d; font-size: 0.9rem; border-top: 1px solid #eee; padding-top: 1rem;">
                                <span>Reported on: <?php echo date('Y-m-d h:i A', strtotime($item['reported_at'])); ?></span>
                                <span>Contact: <?php echo $item['contact_info'] ? htmlspecialchars($item['contact_info']) : 'Not provided'; ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No items found. Be the first to report a lost or found item!</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>