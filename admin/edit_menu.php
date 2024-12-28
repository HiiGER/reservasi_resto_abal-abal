<?php
session_start();
include '../config/database.php';
include 'header.php';

// Get the menu item to edit
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: manage_menu.php");
    exit;
}
$menu_id = (int)$_GET['id'];
$menu_item = $conn->query("SELECT * FROM menu WHERE id = $menu_id")->fetch_assoc();

if (!$menu_item) {
    echo "<div class='alert alert-danger'>Menu item not found!</div>";
    exit;
}

// Fetch all categories for the dropdown
$categories = $conn->query("SELECT * FROM categories ORDER BY name ASC");

// Handle form submission for editing
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $price = (float)$_POST['price'];
    $description = htmlspecialchars($_POST['description']);
    $category_id = (int)$_POST['category_id'];

    if ($category_id > 0) {
        $stmt = $conn->prepare("UPDATE menu SET name = ?, price = ?, description = ?, category_id = ? WHERE id = ?");
        $stmt->bind_param("sdsii", $name, $price, $description, $category_id, $menu_id);
        $stmt->execute();
        header("Location: manage_menu.php");
        exit;
    } else {
        $error = "Please select a valid category.";
    }
}
?>
<h2>Edit Menu</h2>

<!-- Display Error Messages -->
<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<!-- Edit Menu Form -->
<form method="POST" action="" class="mb-4">
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($menu_item['name']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="number" class="form-control" id="price" name="price" step="0.01" value="<?= $menu_item['price'] ?>" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description" required><?= htmlspecialchars($menu_item['description']) ?></textarea>
    </div>
    <div class="mb-3">
        <label for="category_id" class="form-label">Category</label>
        <select class="form-control" id="category_id" name="category_id" required>
            <option value="">-- Select Category --</option>
            <?php while ($category = $categories->fetch_assoc()): ?>
                <option value="<?= $category['id'] ?>" <?= $category['id'] == $menu_item['category_id'] ? 'selected' : '' ?>>
                    <?= $category['name'] ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Update Menu</button>
    <a href="manage_menu.php" class="btn btn-secondary">Cancel</a>
</form>

<?php include 'footer.php'; ?>
