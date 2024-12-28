
<?php 
include '../config/database.php';
include '../includes/header.php'; 
?>
        <!-- # intro
        ================================================== -->
        <section id="intro" class="s-intro">

            <div class="s-intro__bg"></div>

            <div class="row s-intro__content">
                <div class="column xl-12">

                    <div class="s-intro__pretitle">Selamat Datang</div>
                    <h1 class="s-intro__title">Maillard</h1>

                    <p class="s-intro__desc lead">
                    "Dari dapur kami ke meja Anda, Maillard menyajikan hidangan 
                    berkualitas tinggi dengan cita rasa yang memikat."
                    </p>

                </div>                
            </div> <!-- s-intro__content -->     
            
            <div class="s-intro__scroll-down">
                <a href="#about" class="smoothscroll">
                    <span class="scroll-text u-screen-reader-text">Scroll Down</span>
                    <div class="scroll-icon">
                        <svg clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m5.214 14.522s4.505 4.502 6.259 6.255c.146.147.338.22.53.22s.384-.073.53-.22c1.754-1.752 6.249-6.244 6.249-6.244.144-.144.216-.334.217-.523 0-.193-.074-.386-.221-.534-.293-.293-.766-.294-1.057-.004l-4.968 4.968v-14.692c0-.414-.336-.75-.75-.75s-.75.336-.75.75v14.692l-4.979-4.978c-.289-.289-.761-.287-1.054.006-.148.148-.222.341-.221.534 0 .189.071.377.215.52z" fill-rule="nonzero"/></svg>
                    </div>
                </a>
            </div> <!-- s-intro__scroll-down -->

        </section> <!-- end s-intro -->


        <!-- # about
        ================================================== -->
        <section id="about" class="s-about">

            <div class="row s-about__content">
                <div class="column xl-12 s-about__content-grid grid-block">    
                    
                    <div class="s-about__content-header section-header">
                        <h2 class="text-display-title with-line">Our Story</h2>                        
                        <div class="s-about__content-header-inner">
                            <p class="text-desc">
                            Maillard lahir dari kecintaan mendalam terhadap cita rasa yang 
                            dihasilkan oleh reaksi Maillard, sebuah proses kuliner yang mentransformasi 
                            bahan-bahan sederhana menjadi hidangan dengan aroma dan rasa yang kompleks. 
                            Kami berdedikasi untuk menyajikan pengalaman bersantap yang tak terlupakan, 
                            di mana setiap hidangan dimasak dengan presisi untuk menghasilkan rasa yang optimal.
                            </p>
                            
                            <div class="s-about__content-media">
                                <img class="s-about__media-big" 
                                    src="../assets/images/home-about-img.jpg" 
                                    srcset="../assets/images/home-about-img.jpg 1x, images/home-about-img@2x.jpg 2x" alt="">
                                <img class="s-about__media-small" 
                                    src="../assets/images/home-about-img-small.jpg" 
                                    srcset="../assets/images/home-about-img-small.jpg 1x, home-about-img-small@2x.jpg 2x" alt="">
                            </div>
                        </div>
                    </div> <!-- end s-about__content-header -->      
                    
                    <div class="s-about__content-main">

                        <p class="attention-getter">
                        Maillard adalah restoran yang terletak di jantung kota, 
                        menawarkan pengalaman kuliner yang unik dan menggugah selera. 
                        Restoran ini didirikan oleh seorang chef berbakat yang terinspirasi oleh teknik memasak Maillard, 
                        sebuah proses pencoklatan yang menghasilkan rasa dan aroma yang luar biasa.
                        </p>                        
                        <p class="attention-getter">
                        Maillard menyajikan menu yang beragam, 
                        mulai dari hidangan pembuka yang lezat hingga hidangan utama yang menggugah selera. 
                        Setiap hidangan disiapkan dengan bahan-bahan segar dan berkualitas tinggi, 
                        dan dibumbui dengan rempah-rempah yang dipilih dengan hati-hati. 
                        Restoran ini juga menawarkan berbagai macam minuman, 
                        termasuk anggur, koktail, dan bir.  
                        </p>
                        <p class="attention-getter">
                        Suasana di Maillard hangat dan ramah, 
                        dengan dekorasi yang elegan dan nyaman. 
                        Restoran ini adalah tempat yang sempurna untuk bersantap bersama keluarga dan teman, 
                        atau untuk merayakan acara khusus.
                        </p>                                            

                    </div> <!-- end s-about-content-main -->  

                </div> <!-- end s-about__content-grid -->
            </div> <!--end s-about__content -->            
            
        </section> <!-- end s-about -->   



        <!-- # testimonials
        ================================================== -->
        <section id="testimonials" class="s-testimonials">

            <div class="row s-testimonials__content">
                <div class="column xl-12">

                    <?php
                        $sql = "SELECT name, image_path, city, review FROM reviews ORDER BY created_at DESC";
                        $result = $conn->query($sql);
                    ?>
                    <h3 class="s-testimonials__title text-center">Riview Dari Client Kami</h3>

                    <div class="swiper-container s-testimonials__slider">    
                        <div class="swiper-wrapper">
                            <?php if ($result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <div class="s-testimonials__slide swiper-slide">
                                        <div class="s-testimonials__author">
                                            <img src="<?php echo htmlspecialchars($row['image_path']); ?>" alt="Author image" class="s-testimonials__avatar">
                                            <cite class="s-testimonials__cite">
                                                <?php echo htmlspecialchars($row['name']); ?>
                                                <span><?php echo htmlspecialchars($row['city']); ?></span>
                                            </cite>
                                        </div>
                                        <p>
                                            <?php echo htmlspecialchars($row['review']); ?>
                                        </p>
                                    </div> <!-- end s-testimonials__slide -->
                                <?php endwhile; ?>
                            <?php else: ?>
                                <div class="s-testimonials__slide swiper-slide">
                                    <p class="text-center">Belum ada ulasan dari pengunjung.</p>
                                </div>
                            <?php endif; ?>
                        </div> <!-- end swiper-wrapper -->

                        <div class="swiper-pagination"></div>
                    </div> <!-- end s-testimonials__slider -->
                </div> <!-- end column -->
            </div> <!-- end s-testimonials__content -->

        </section> <!-- end s-testimonials --> 


<?php include '../includes/footer.php'; ?>




