<?php
include '../config/database.php';
session_start();

$error = $success = "";
$reservation = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reservation_code = htmlspecialchars($_POST['reservation_code']);
    
    // Cek apakah kode reservasi ada
    $stmt = $conn->prepare("SELECT * FROM customers WHERE reservation_code = ?");
    $stmt->bind_param("s", $reservation_code);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $reservation = $result->fetch_assoc();
    } else {
        $error = "Kode reservasi tidak ditemukan!";
    }
}

// Update reservasi
if (isset($_POST['update'])) {
    $new_date = $_POST['new_date'];
    $new_time = $_POST['new_time'];
    
    $stmt = $conn->prepare("UPDATE customers SET reservation_date = ?, reservation_time = ? WHERE reservation_code = ?");
    $stmt->bind_param("sss", $new_date, $new_time, $reservation['reservation_code']);
    
    if ($stmt->execute()) {
        $success = "";
        // Refresh reservation data
        $stmt = $conn->prepare("SELECT * FROM customers WHERE reservation_code = ?");
        $stmt->bind_param("s", $reservation['reservation_code']);
        $stmt->execute();
        $result = $stmt->get_result();
        $reservation = $result->fetch_assoc();
    } else {
        $error = "Gagal memperbarui reservasi.";
    }
}

// Hapus reservasi
if (isset($_POST['delete'])) {
    $stmt = $conn->prepare("DELETE FROM customers WHERE reservation_code = ?");
    $stmt->bind_param("s", $reservation['reservation_code']);
    
    if ($stmt->execute()) {
        $success = "Reservasi berhasil dihapus!";
        $reservation = null; // Clear reservation data after delete
    } else {
        $error = "Gagal menghapus reservasi.";
    }
}

include '../includes/header.php';
?>

    <section class="s-pageheader pageheader" style="background-image:url(../assets/images/pageheader/reservate.jpg)">
        <div class="row">
            <div class="column xl-12 s-pageheader__content">
                <h1 class="page-title"> 
                    Cek Status Reservasi
                </h1>                    
            </div>
        </div>
    </section>

    <section class="s-pagecontent pagecontent">
        <div class="row width-narrower content-block">
            <div class="column xl-12">
                <form method="POST" action="" class="reservation-form">
                    <fieldset class="row">
                        <div class="column xl-6 tab-12-group">
                            <label for="reservation_code">Kode Reservasi:</label>
                            <input type="text" name="reservation_code" class="u-fullwidth" required>
                        </div>

                        <div class="rform__bottom column xl-12">
                            <div class="row">
                                <div class="column xl-6 tab-12">
                                    <button type="submit" class="btn btn--primary btn-wide btn--large u-fullwidth">Cek</button>
                                </div>
                            </div>
                        </div>

                    </fieldset>
                </form>
            </div>
        </div>

        <?php if ($reservation): ?>

    <!-- Detail -->
        <div class="row width-narrower content-block">
            <div class="column xl-12">
                <h3>Detail Reservasi</h3>
                <form class="reservation-form">
                    <fieldset class="row">
                        <div class="column xl-6 tab-12-group">
                            <label for="reservation_code">Nama : <?php echo htmlspecialchars($reservation['name']); ?></label>
                            <br>
                        </div>

                        <div class="column xl-6 tab-12-group">
                            <label for="reservation_code">Email : <?php echo htmlspecialchars($reservation['email']); ?></label>
                            <br>
                        </div>

                        <div class="column xl-6 tab-12-group">
                            <label for="reservation_code">Telepon : <?php echo htmlspecialchars($reservation['phone']); ?></label>
                            <br>
                        </div>
                        
                        <div class="column xl-6 tab-12-group">
                            <label for="reservation_code">Meja : <?php echo $reservation['table_number']; ?></label>
                            <br>
                        </div>

                        <div class="column xl-6 tab-12-group">
                            <label for="reservation_code">Tanggal Reservasi: <?php echo $reservation['reservation_date']; ?></label>
                            <br>
                        </div>

                        <div class="column xl-6 tab-12-group">
                            <label for="reservation_code">Waktu Reservasi: <?php echo $reservation['reservation_time']; ?></label>
                            <br>
                        </div>
                        
                    </fieldset>
                </form>
            </div>
        </div>

        <div class="row width-narrower content-block">
            <div class="column xl-12">
                <h4>Perbarui Reservasi</h4>
                <form method="POST" action="" class="reservation-form">
                    <fieldset class="row">

                        <input type="hidden" name="reservation_code" value="<?php echo $reservation['reservation_code']; ?>">
                        <div class="column xl-6 tab-12-group">
                            <label for="new_date">Tanggal Baru:</label>
                            <input type="date" name="new_date" class="u-fullwidth" value="<?php echo $reservation['reservation_date']; ?>" required>
                        </div>

                        <div class="column xl-6 tab-12-group">
                            <label for="new_time">Waktu Baru:</label>
                            <input type="time" name="new_time" class="u-fullwidth" value="<?php echo $reservation['reservation_time']; ?>" required>
                        </div>

                        <div class="rform__bottom column xl-12">
                            <div class="row">
                                <div class="column xl-6 tab-12">
                                    <button type="submit" name="update" class="btn btn--primary btn-wide btn--large u-fullwidth">Perbarui Reservasi</button>
                                </div>
                            </div>
                        </div>

                    </fieldset>
                </form>

                <!-- HAPUS -->
                <h4>Hapus Reservasi</h4>
                <form method="POST" action="" class="reservation-form">
                    <input type="hidden" name="reservation_code" value="<?php echo $reservation['reservation_code']; ?>">
                    <div class="row">
                        <div class="column xl-6 tab-12">
                            <button type="submit" name="delete" class="btn btn--danger btn-wide btn--large u-fullwidth" onclick="return confirm('Anda yakin ingin menghapus reservasi ini?');">Hapus Reservasi</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

<?php endif; ?>

<?php if ($success): ?>
    <p class="text-success"><?php echo $success; ?></p>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>
