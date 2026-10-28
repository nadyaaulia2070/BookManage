<?php
require "includes/auth.php";
require "config/database.php";

$judul_halaman = t("dashboard");

$stmt = $pdo->query("SELECT COUNT(*) AS total_judul, COALESCE(SUM(stok), 0) AS total_stok FROM buku");
$statistik = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->query("SELECT COUNT(DISTINCT kategori) AS total_kategori FROM buku");
$kategori = $stmt->fetch(PDO::FETCH_ASSOC);

require "includes/header.php";
?>

<div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
    <div class="sapaan">
        <small><?php echo htmlspecialchars(t("welcome_title")); ?></small>
        <h1 class="mb-1"><?php echo htmlspecialchars($_SESSION["nama_lengkap"]); ?> 👋</h1>
        <div class="text-muted"><?php echo htmlspecialchars(t("welcome_sub")); ?></div>
    </div>
    <div class="d-none d-md-flex align-items-center gap-3">
        <div class="tulisan-tangan hero-tagline">“<?php echo htmlspecialchars(t("tagline")); ?>”</div>
        <i class="bi bi-book hero-ikon"></i>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-12 col-md-4">
        <div class="card stat-card stat-biru h-100">
            <div class="card-body d-flex gap-3">
                <div class="stat-ikon"><i class="bi bi-book-fill"></i></div>
                <div>
                    <div class="fw-semibold text-secondary"><?php echo htmlspecialchars(t("total_judul")); ?></div>
                    <div class="stat-angka"><?php echo (int)$statistik["total_judul"]; ?></div>
                    <small class="text-muted"><?php echo htmlspecialchars(t("desc_judul")); ?></small>
                </div>
            </div>
            <a class="stat-panah" href="/BookManage/buku/index.php"><i class="bi bi-arrow-right"></i></a>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card stat-card stat-hijau h-100">
            <div class="card-body d-flex gap-3">
                <div class="stat-ikon"><i class="bi bi-boxes"></i></div>
                <div>
                    <div class="fw-semibold text-secondary"><?php echo htmlspecialchars(t("total_stok")); ?></div>
                    <div class="stat-angka"><?php echo (int)$statistik["total_stok"]; ?></div>
                    <small class="text-muted"><?php echo htmlspecialchars(t("desc_stok")); ?></small>
                </div>
            </div>
            <a class="stat-panah" href="/BookManage/buku/index.php"><i class="bi bi-arrow-right"></i></a>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card stat-card stat-ungu h-100">
            <div class="card-body d-flex gap-3">
                <div class="stat-ikon"><i class="bi bi-grid-1x2-fill"></i></div>
                <div>
                    <div class="fw-semibold text-secondary"><?php echo htmlspecialchars(t("total_kategori")); ?></div>
                    <div class="stat-angka"><?php echo (int)$kategori["total_kategori"]; ?></div>
                    <small class="text-muted"><?php echo htmlspecialchars(t("desc_kategori")); ?></small>
                </div>
            </div>
            <a class="stat-panah" href="/BookManage/buku/index.php"><i class="bi bi-arrow-right"></i></a>
        </div>
    </div>
</div>

<a href="/BookManage/buku/index.php" class="btn btn-primary btn-lg px-4">
    <i class="bi bi-book me-2"></i><?php echo htmlspecialchars(t("kelola_buku")); ?>
    <i class="bi bi-arrow-right ms-3"></i>
</a>

<?php require "includes/footer.php"; ?>