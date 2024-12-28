<?php
include '../config/database.php';
session_start();

$error = $success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $city = htmlspecialchars($_POST['city']);
    $review = htmlspecialchars($_POST['review']);
    $image = $_FILES['image'];

    // Validasi input
    if (empty($name) || empty($city) || empty($review) || empty($image['name'])) {
        $error = "Semua kolom wajib diisi!";
    } else {
        // Proses upload gambar
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($image["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ["jpg", "jpeg", "png", "gif"];

        // Validasi jenis file
        if (!in_array($imageFileType, $allowed_types)) {
            $error = "Hanya file JPG, JPEG, PNG, dan GIF yang diperbolehkan.";
        } elseif (move_uploaded_file($image["tmp_name"], $target_file)) {
            // Simpan data ke database
            $stmt = $conn->prepare("INSERT INTO reviews (name, image_path, city, review) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $target_file, $city, $review);

            if ($stmt->execute()) {
                $success = "Ulasan berhasil disimpan!";
            } else {
                $error = "Terjadi kesalahan saat menyimpan ulasan.";
            }
        } else {
            $error = "Gagal mengunggah gambar.";
        }
    }
    header("index.php");
}

include '../includes/header.php';
?>


<section class="s-pageheader pageheader" style="background-image:url(../assets/images/pageheader/testimonial.jpg)">
    <div class="row">
        <div class="column xl-12 s-pageheader__content">
            <h1 class="page-title"> 
            Berikan Ulasan Anda
            </h1>                    
        </div>
    </div>
</section>


<section class="s-pagecontent pagecontent">
    <div class="row width-narrower content-block">
        <form method="POST" action="" enctype="multipart/form-data" class="reservation-form">
            <fieldset class="row">
                <div class="column xl-6 tab-12">
                    <label for="name">Nama:</label>
                    <input type="text" name="name" class="u-fullwidth" placeholder="ex: Angger" required>
                </div>
                <div class="column xl-6 tab-12">
                    <label for="image">Gambar:</label>
                    <input type="file" name="image" class="u-fullwidth" required>
                </div>
                <div class="column xl-6 tab-12">
                    <label for="review">Ulasan:</label>
                    <textarea name="review" class="u-fullwidth" rows="5" required></textarea>
                </div>
                <div class="column xl-6 tab-12">
                    <label for="city">Asal Kota:</label>
                    <input type="text" name="city" class="u-fullwidth" placeholder="ex: Yogyakarta" required>
                </div>
                
                <div class="rform__bottom column xl-12">
                    <div class="row">
                        <div class="column xl-6 tab-12">
                            <button type="submit" class="btn btn--primary btn-wide btn--large u-fullwidth">Kirim Ulasan</button>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</section>

<?php include '../includes/footer.php'; ?>



