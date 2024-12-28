<?php
session_start();
include '../config/database.php';
include 'header.php';

// Check if reservation ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Reservation ID is missing.";
    exit;
}

$reservation_id = (int)$_GET['id'];

// Fetch reservation data
$reservation_query = $conn->query("SELECT * FROM customers WHERE id = $reservation_id");
if ($reservation_query->num_rows === 0) {
    echo "Reservation not found.";
    exit;
}

$reservation = $reservation_query->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reservation_code = $conn->real_escape_string($_POST['reservation_code']);
    $name = $conn->real_escape_string($_POST['name']);
    $table_number = $conn->real_escape_string($_POST['table_number']);
    $reservation_date = $conn->real_escape_string($_POST['reservation_date']);
    $reservation_time = $conn->real_escape_string($_POST['reservation_time']);

    // Update query
    $update_query = "
        UPDATE customers 
        SET 
            reservation_code = '$reservation_code',
            name = '$name',
            table_number = '$table_number',
            reservation_date = '$reservation_date',
            reservation_time = '$reservation_time'
        WHERE id = $reservation_id
    ";

    if ($conn->query($update_query)) {
        header("Location: reservations_list.php");
        exit;
    } else {
        echo "Failed to update reservation: " . $conn->error;
    }
}
?>

<h2>Edit Reservation</h2>

<form method="POST" action="edit_reservation.php?id=<?= $reservation_id ?>">
    <div class="mb-3">
        <label for="reservation_code" class="form-label">Reservation Code</label>
        <input type="text" name="reservation_code" id="reservation_code" class="form-control" value="<?= htmlspecialchars($reservation['reservation_code']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($reservation['name']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="table_number" class="form-label">Table Number</label>
        <input type="number" name="table_number" id="table_number" class="form-control" value="<?= htmlspecialchars($reservation['table_number']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="reservation_date" class="form-label">Reservation Date</label>
        <input type="date" name="reservation_date" id="reservation_date" class="form-control" value="<?= htmlspecialchars($reservation['reservation_date']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="reservation_time" class="form-label">Reservation Time</label>
        <input type="time" name="reservation_time" id="reservation_time" class="form-control" value="<?= htmlspecialchars($reservation['reservation_time']) ?>" required>
    </div>
    <button type="submit" class="btn btn-success">Save Changes</button>
    <a href="reservations_list.php" class="btn btn-secondary">Cancel</a>
</form>

<?php include 'footer.php'; ?>
