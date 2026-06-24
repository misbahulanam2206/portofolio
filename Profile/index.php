<?php
// 1. DATA PORTOFOLIO (PHP)
$nama = "Misbahul Anam Sidiq";
$peran = "Web Developer & Designer";
$tentang_saya = "Halo! Saya Misbahul Anam Sidiq Seorang Mahasiswa STT Terpadu Nurul Fikri Jurusan Teknik Informatika dapat membuat aplikasi yang interaktif, bersih, dan mudah digunakan. Selamat datang di portofolio saya.";

// Array untuk menyimpan list proyek kamu
$proyek_list = [
    [
        "judul" => "Website E-Commerce UMKM ",
        "deskripsi" => "Membangun toko online lengkap dengan sistem keranjang belanja dan pembayaran otomatis.",
        "teknologi" => "HTML, CSS, PHP, MySQL",
        "gambar" => "img/rachma laundry.png"  
    ],
    [
        "judul" => "Aplikasi KIP KULIAH TRACKER",
        "deskripsi" => "Aplikasi berbasis web untuk membantu tim memantau Jalan Keuangan Kuliah  mereka secara real-time.",
        "teknologi" => "HTML, CSS, JavaScript, PHP",
        "gambar" => "img/kipk application.png"
    ],
    [
        "judul" => "Membuat Aplikasi KAI Commuter ",
        "deskripsi" => "Membuat desain halaman utama yang responsif dan modern untuk produk startup teknologi. 
        Apalagi di bidang Transportasi Umum seperti KRL Commuter Line Jabodetabek",
        "teknologi" => "HTML, Tailwind CSS",
        "gambar" => "img/KAIC.png"
    ]
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portofolio | <?php echo $nama; ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header class="hero">
        <div class="container hero-content">
            <span class="badge-welcome">Welcome to My Portofolio</span>
            <h1><?php echo $nama; ?></h1>
            <p class="tagline"><?php echo $peran; ?></p>
            <div class="hero-buttons">
                <a href="project.html" class="btn btn-primary">Lihat Proyek</a>
                <a href="about.html" class="btn btn-secondary">Tentang Saya</a>
            </div>
        </div>
    </header>

    <section id="about" class="about container">
        <h2>Tentang Saya</h2>
        <p><?php echo $tentang_saya; ?></p>
    </section>

    <section id="portofolio" class="portofolio container">
        <h2>Proyek Pilihan</h2>
        <div class="grid-proyek">
            
            <?php foreach ($proyek_list as $proyek) : ?>
                <div class="card-proyek">
                    <div class="card-img-wrapper">
                        <img src="<?php echo $proyek['gambar']; ?>" alt="<?php echo $proyek['judul']; ?>">
                    </div>
                    <div class="card-body">
                        <h3><?php echo $proyek['judul']; ?></h3>
                        <p><?php echo $proyek['deskripsi']; ?></p>
                        <div class="card-footer">
                            <span class="tech-badge"><i class="fa-solid fa-code-branch"></i> <?php echo $proyek['teknologi']; ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </section>

    <footer>
        <div class="container footer-content">
            <div class="social-links">
                <a href="https://github.com/" target="_blank"><i class="fa-brands fa-github"></i></a>
                <a href="https://www.linkedin.com/feed/" target="_blank"><i class="fa-brands fa-linkedin"></i></a>
                <a href="https://www.instagram.com/misbah.anam22/" target="_blank"><i class="fa-brands fa-instagram"></i></a>
            </div>
            <p>&copy; <?php echo date("Y"); ?> <span><?php echo $nama; ?></span>. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>