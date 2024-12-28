<?php
session_start();
include '../config/database.php';
include 'header.php';

// Handle delete operation
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    $conn->query("DELETE FROM customers WHERE id = $delete_id");
    header("Location: reservations_list.php");
    exit;
}

// Handle search
$search_query = '';
if (isset($_GET['search'])) {
    $search_query = $conn->real_escape_string($_GET['search']);
    $reservations = $conn->query("SELECT * FROM customers WHERE reservation_code LIKE '%$search_query%' ORDER BY created_at DESC");
} else {
    $reservations = $conn->query("SELECT * FROM customers ORDER BY created_at DESC");
}
?>

<h2>Reservations</h2>

<!-- Search Form -->
<form method="GET" action="reservations_list.php" class="mb-3">
    <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder="Search by Reservation Code" value="<?= htmlspecialchars($search_query) ?>">
        <button type="submit" class="btn btn-primary">Search</button>
    </div>
</form>

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>No Reservasi</th>
            <th>Name</th>
            <th>Table</th>
            <th>Date</th>
            <th>Time</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($reservations->num_rows > 0): ?>
            <?php while ($row = $reservations->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['reservation_code'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['table_number'] ?></td>
                    <td><?= $row['reservation_date'] ?></td>
                    <td><?= $row['reservation_time'] ?></td>
                    <td>
                        <a href="edit_reservation.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>

                        <a href="?delete_id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">Delete</a>
                        
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" class="text-center">No reservations found</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include 'footer.php'; ?>
