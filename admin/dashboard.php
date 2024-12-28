<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['employee'])) {
    header("Location: login.php");
    exit;
}

$page_title = 'Dashboard';
include 'header.php';

$total_reservations = $conn->query("SELECT COUNT(*) AS total FROM customers")->fetch_assoc()['total'];
$total_menu = $conn->query("SELECT COUNT(*) AS total FROM menu")->fetch_assoc()['total'];
?>

<h2 class="text-center">Welcome, <?= $_SESSION['employee'] ?></h2>
<div class="row my-4">
    <div class="col-md-6">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Total Reservations</h5>
                <p class="card-text fs-4"><?= $total_reservations ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Total Menu Items</h5>
                <p class="card-text fs-4"><?= $total_menu ?></p>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
