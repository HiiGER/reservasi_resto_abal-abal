<?php
include '../config/database.php';
include '../includes/header.php'; // Bootstrap header

// Query untuk mendapatkan kategori
$categories_query = "SELECT * FROM categories ORDER BY name ASC";
$categories_result = $conn->query($categories_query);

// Cek apakah ada filter kategori yang diterapkan
$filter_category = isset($_GET['category_id']) ? (int)$_GET['category_id'] : null;

// Query untuk mendapatkan menu berdasarkan kategori (jika ada filter)
$sql = "
    SELECT categories.id AS category_id, categories.name AS category_name, 
           menu.name AS menu_name, menu.price, menu.description 
    FROM categories 
    LEFT JOIN menu ON categories.id = menu.category_id 
";
if ($filter_category) {
    $sql .= "WHERE categories.id = $filter_category ";
}
$sql .= "ORDER BY categories.name, menu.name";

$result = $conn->query($sql);

// Organisasi data dalam array
$menu_by_category = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $menu_by_category[$row['category_name']][] = $row;
    }
}
?>

<!-- # main content ================================================== -->
<article class="s-content">

    <!-- ## pageheader -->
    <section class="s-pageheader pageheader" style="background-image:url(../assets/images/pageheader/pageheader-menu-bg-3000.jpg)">
        <div class="row">
            <div class="column xl-12 s-pageheader__content">
                <h1 class="page-title">                        
                    Jelajahi Menu Kami
                </h1>                    
            </div>
        </div>
    </section>

    <!-- ## pagecontent -->
    <section class="s-pagecontent pagecontent">

        <div class="row width-narrower pageintro text-center">
            <div class="column xl-12">
                <p class="lead">
                Berikut adalah pilihan hidangan yang kami kurasi dengan 
                bahan-bahan terbaik dan teknik memasak yang presisi.
                </p>
            </div>                       
        </div> <!-- end pageintro -->   

        <!-- Filter Form -->
        <div class="row width-narrower mb-4">
            <div class="column xl-12">
                <form method="GET" action="" class="d-flex justify-content-center align-items-center">
                    <label for="category_id" class="form-label me-2">Filter Kategori:</label>
                    <select id="category_id" name="category_id" class="form-select w-auto me-2">
                        <option value="">-- Semua Kategori --</option>
                        <?php while ($category = $categories_result->fetch_assoc()): ?>
                            <option value="<?= $category['id'] ?>" <?= $filter_category == $category['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($category['name']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </form>
            </div>
        </div>

        <!-- Menu List -->
        <div class="row width-narrower content-block">
            <div class="column xl-12">
                <div class="menu-block">
                    <div class="menu-block__group">
                        <?php if (!empty($menu_by_category)): ?>
                            <?php foreach ($menu_by_category as $category_name => $menus): ?>
                                <h2 class="h6 menu-block__cat-name"><?= htmlspecialchars($category_name) ?></h2>

                                <ul class="menu-list">
                                    <?php foreach ($menus as $menu): ?> 
                                    <li class="menu-list__item">
                                        <div class="menu-list__item-desc">                                           
                                            <h4><?= htmlspecialchars($menu['menu_name']) ?></h4>
                                            <p>
                                                <?= htmlspecialchars($menu['description']) ?>
                                            </p>
                                        </div>
                                        <div class="menu-list__item-price">
                                            <span>Rp</span>
                                            <?= number_format($menu['price'], 0, ',', '.') ?>
                                        </div>
                                    </li>
                                    <?php endforeach; ?>
                                </ul> <!-- end menu-list -->
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-center">Tidak ada menu yang ditemukan.</p>
                        <?php endif; ?>
                    </div> <!-- end menu-block__group -->
                </div> <!-- end menu-block -->
            </div>
        </div> <!-- end content-menu -->

    </section> <!-- pagecontent --> 

</article> <!-- end main content -->

<?php include '../includes/footer.php'; // Bootstrap footer ?>
