<?php
session_start();
include '../config/database.php';
include 'header.php';

// Fetch all categories for the dropdown
$categories = $conn->query("SELECT * FROM categories ORDER BY name ASC");

// Handle adding a new menu item
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name'])) {
    $name = htmlspecialchars($_POST['name']);
    $price = (float)$_POST['price'];
    $description = htmlspecialchars($_POST['description']);
    $category_id = (int)$_POST['category_id'];

    if ($category_id > 0) {
        $stmt = $conn->prepare("INSERT INTO menu (name, price, description, category_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sdsi", $name, $price, $description, $category_id);
        $stmt->execute();
        header("Location: manage_menu.php");
        exit;
    } else {
        $error = "Please select a valid category.";
    }
}

// Handle deleting a menu item
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    $conn->query("DELETE FROM menu WHERE id = $delete_id");
    header("Location: manage_menu.php");
    exit;
}

// Handle searching for menu items
$search = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';

// Query to fetch menu items with search filter
$query = "
    SELECT menu.*, categories.name AS category_name 
    FROM menu 
    JOIN categories ON menu.category_id = categories.id 
    WHERE menu.name LIKE ?
    ORDER BY menu.created_at DESC
";
$stmt = $conn->prepare($query);
$search_param = "%$search%";
$stmt->bind_param("s", $search_param);
$stmt->execute();
$menu_items = $stmt->get_result();
?>
<h2>Manage Menu</h2>

<!-- Display Error Messages -->
<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<!-- Search Form -->
<form method="GET" action="" class="mb-4">
    <div class="row">
        <div class="col-md-6">
            <input type="text" class="form-control" name="search" placeholder="Search menu by name..." value="<?= $search ?>">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
        <div class="col-md-2">
            <a href="manage_menu.php" class="btn btn-secondary">Clear</a>
        </div>
        <div class="col-md-2">
            <!-- Button to trigger modal -->
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addMenuModal">
                Add Menu
            </button>
        </div>
    </div>
</form>

<!-- Add Menu Modal -->
<div class="modal fade" id="addMenuModal" tabindex="-1" aria-labelledby="addMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMenuModalLabel">Add New Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-control" id="category_id" name="category_id" required>
                            <option value="">-- Select Category --</option>
                            <?php while ($category = $categories->fetch_assoc()): ?>
                                <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Menu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Menu List Table -->
<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Description</th>
            <th>Category</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($menu_items->num_rows > 0): ?>
            <?php while ($row = $menu_items->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['price'] ?></td>
                    <td><?= $row['description'] ?></td>
                    <td><?= $row['category_name'] ?></td>
                    <td>
                        <a href="edit_menu.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="?delete_id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" class="text-center">No menu items found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include 'footer.php'; ?>
