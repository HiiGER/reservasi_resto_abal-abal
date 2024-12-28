<?php
include '../config/database.php';

// Fungsi untuk menghasilkan kode reservasi unik
function generateReservationCode($conn) {
    do {
        // Generate angka acak 6 digit
        $randomCode = mt_rand(100000, 999999);

        // Cek apakah kode sudah ada di database
        $stmt = $conn->prepare("SELECT COUNT(*) FROM customers WHERE reservation_code = ?");
        $stmt->bind_param("s", $randomCode);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        // Jika tidak ada kode yang sama, keluar dari loop
    } while ($count > 0);

    return $randomCode;
}

$error = $success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitasi dan validasi input
    $name = htmlspecialchars(trim($_POST['name']));  
    $email = htmlspecialchars(trim($_POST['email']));  
    $phone = preg_replace('/[^0-9+]/', '', $_POST['phone']);

    if (!preg_match("/^[a-zA-Z\s]*$/", $name)) {
        $error = "Nama hanya boleh mengandung huruf dan spasi.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email tidak valid.";
    } elseif (!preg_match("/^[0-9+]*$/", $phone)) {
        $error = "Nomor telepon hanya boleh mengandung angka dan simbol '+' (jika ada).";
    } else {
        $table_number = (int)$_POST['table_number'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $captcha = $_POST['captcha'];
        
        // Validasi CAPTCHA
        session_start();
        if ($captcha != $_SESSION['captcha']) {
            $error = "Captcha tidak valid.";
        } elseif (!empty($name) && !empty($email) && !empty($phone)) {
            // Generate kode reservasi unik
            $reservation_code = generateReservationCode($conn);
            $stmt = $conn->prepare("INSERT INTO customers (name, email, phone, reservation_code, table_number, reservation_date, reservation_time) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssisss", $name, $email, $phone, $reservation_code, $table_number, $date, $time);
            if ($stmt->execute()) {
                $success = "Reservation successful! Your code is $reservation_code.";
                header("Location: ../reports/cetak.php?name=$name&email=$email&phone=$phone&reservation_code=$reservation_code&table_number=$table_number&date=$date&time=$time");
            } else {
                $error = "Failed to reserve table.";
            }
        } else {
            $error = "All fields are required.";
        }
    }
}

include '../includes/header.php'; // Bootstrap header
?>
<!-- Main Content -->
<article class="s-content">
    <!-- ## pageheader -->
    <section class="s-pageheader pageheader" style="background-image:url(../assets/images/pageheader/pageheader-reservations-bg-3000.jpg)">
        <div class="row">
            <div class="column xl-12 s-pageheader__content">
                <h1 class="page-title">
                    Reservations
                </h1>
            </div>
        </div>
    </section>

            <!-- Error and Success Messages -->
        <div class="mt-3">
            <?php if (!empty($error)): ?>
                <div><?= $error ?></div>
            <?php endif; ?>
            <?php if (!empty($success)): ?>
                <div><?= $success ?></div>
            <?php endif; ?>
        </div>
    <!-- ## pagecontent -->
    <section class="s-pagecontent pagecontent">
        <div class="row width-narrower content-block">
            <div class="column xl-12">
                <form name="rform" id="rform" class="reservation-form" method="POST" action="" autocomplete="off">
                    <fieldset class="row">
                        <div class="column xl-6 tab-12">
                            <label for="name">Name:</label>
                            <input type="text" id="name" name="name" class="u-fullwidth" placeholder="ex: Angger" required>
                        </div>
                        <div class="column xl-6 tab-12">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" class="u-fullwidth" placeholder="angger@gmail.com" required>
                        </div>
                        <div class="column xl-6 tab-12">
                            <label for="phone">Phone:</label>
                            <input type="text" id="phone" name="phone" class="u-fullwidth" placeholder="ex: 08516.." required>
                        </div>
                        <div class="column xl-6 tab-12">
                            <label for="table_number">Table Number:</label>
                            <input type="number" id="table_number" name="table_number" class="u-fullwidth" required>
                        </div>
                        <div class="column xl-6 tab-12">
                            <label for="date">Date:</label>
                            <input type="date" id="date" name="date" class="u-fullwidth" required>
                        </div>
                        <div class="column xl-6 tab-12">
                            <label for="time">Time:</label>
                            <input type="time" id="time" name="time" class="u-fullwidth" required>
                        </div>
                        <div class="column xl-6 tab-12">
                            <label for="captcha">
                                <br>
                                Enter Captcha: <br>
                                <img src="captcha.php" alt="Captcha">
                            </label>
                            <input type="text" id="captcha" name="captcha" class="u-fullwidth" required>
                        </div>

                        <div class="rform__bottom column xl-12">
                            <div class="row">
                                <div class="column xl-6 tab-12">
                                    <input name="submit" id="submit" class="btn btn--primary btn-wide btn--large u-fullwidth" value="Submit Reservation" type="submit">
                                </div>
                            </div>
                        </div>

                    </fieldset>
                </form>

            </div>
        </div> <!-- end content-block -->

    </section>
</article>

<?php include '../includes/footer.php'; ?>
