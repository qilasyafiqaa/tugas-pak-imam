<?php
// ==========================================
// DATA DAN PROSES PERHITUNGAN
// ==========================================

$hasil = false;

$hargaMobil = 0;
$dpPersen = 0;
$tenor = 0;
$jumlahDP = 0;
$bunga = 0;
$angsuran = 0;
$totalBayar = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $hargaMobil = isset($_POST["harga_mobil"]) ? (float) $_POST["harga_mobil"] : 0;
    $dpPersen = isset($_POST["dp"]) ? (float) $_POST["dp"] : 0;
    $tenor = isset($_POST["tenor"]) ? (int) $_POST["tenor"] : 0;

    if ($hargaMobil > 0 && $dpPersen > 0 && $tenor > 0) {

        // Menghitung nominal DP
        $jumlahDP = $hargaMobil * ($dpPersen / 100);

        // Bunga tetap 20%
        $bunga = $hargaMobil * 0.20;

        // Mengubah tenor tahun menjadi bulan
        $jumlahBulan = $tenor * 12;

        // Sisa pembayaran setelah DP
        $sisaPembayaran = ($hargaMobil + $bunga) - $jumlahDP;

        // Angsuran setiap bulan
        $angsuran = $sisaPembayaran / $jumlahBulan;

        // Total pembayaran
        $totalBayar = $hargaMobil + $bunga;

        $hasil = true;
    }
}

// Fungsi untuk format Rupiah
function rupiah($nilai)
{
    return "Rp " . number_format($nilai, 0, ",", ".");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>AutoFinance - Kalkulator Angsuran</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            margin: 0;
            background: #f4f7fb;
            color: #263238;
            font-family: Arial, Helvetica, sans-serif;
        }

        .navbar {
            background: #101820;
        }

        .brand-logo {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: #ffffff;
            color: #101820;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 21px;
        }

        .hero {
            min-height: 360px;
            margin-bottom: 60px;
            display: flex;
            align-items: center;
            background:
                linear-gradient(rgba(16, 24, 32, .78), rgba(16, 24, 32, .78)),
                url("https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&w=1600&q=80")
                center/cover;
            color: white;
        }

        .hero-title {
            font-size: 48px;
            font-weight: 800;
        }

        .hero-text {
            max-width: 600px;
            color: #dce3e8;
        }

        .main-card {
            /* Kartu dimulai setelah hero, tanpa menumpuk */
            margin-top: 0 !important;
            position: relative;
            z-index: 2;
            border: 0;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, .12);
        }

        .section-title {
            font-weight: 800;
        }

        .calculator-head {
            background: #101820;
            color: white;
            padding: 24px;
        }

        .form-control,
        .form-select {
            min-height: 48px;
            border-radius: 10px;
        }

        /* Jarak antarlabel dan kolom input, termasuk pilihan DP */
        .form-label {
            display: block;
            margin-bottom: 10px;
        }

        .tenor-option {
            min-height: 45px;
            margin-bottom: 5px;
        }

        .btn-hitung {
            margin-top: 8px;
        }

        /* Jarak menu navigasi agar Beranda tidak berdempetan dengan menu lain */
        @media (min-width: 992px) {
            .navbar-nav {
                column-gap: 1.25rem;
            }
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #101820;
            box-shadow: 0 0 0 .2rem rgba(16, 24, 32, .10);
        }

        .btn-hitung {
            background: #101820;
            border: none;
            color: white;
            min-height: 48px;
            border-radius: 10px;
            transition: .2s;
        }

        .btn-hitung:hover {
            background: #263642;
            color: white;
            transform: translateY(-1px);
        }

        .car-photo {
            width: 100%;
            height: 100%;
            min-height: 330px;
            object-fit: cover;
            border-radius: 18px;
        }

        .info-box {
            background: #f1f5f8;
            border-radius: 14px;
            padding: 20px;
        }

        .tenor-option {
            border: 1px solid #dce2e6;
            border-radius: 10px;
            padding: 10px 14px;
            cursor: pointer;
            transition: .2s;
        }

        .tenor-option:hover {
            background: #f3f6f8;
        }

        .result-card {
            border: 0;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 12px 30px rgba(0, 0, 0, .09);
        }

        .result-head {
            background: #101820;
            color: white;
            padding: 20px;
        }

        .result-row {
            padding: 14px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .monthly-box {
            background: #edf2f5;
            border-radius: 16px;
            padding: 24px;
            text-align: center;
        }

        .monthly-box h2 {
            font-weight: 800;
            color: #101820;
        }

        .feature-card {
            border: 0;
            border-radius: 16px;
            height: 100%;
            box-shadow: 0 7px 25px rgba(0, 0, 0, .06);
        }

        .feature-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: #101820;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 22px;
        }

        footer {
            margin-top: 70px;
            background: #101820;
            color: white;
            padding: 35px 0;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 35px;
            }

            .hero {
                margin-bottom: 30px;
            }

            .main-card {
                margin-top: 0 !important;
            }
        }
    </style>
</head>

<body>

<!-- ================= NAVBAR ================= -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container py-2">

        <a href="#" class="navbar-brand d-flex align-items-center gap-2 fw-bold">
            <div class="brand-logo">
                <i class="bi bi-car-front-fill"></i>
            </div>
            <span>AutoFinance</span>
        </a>

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav ms-auto gap-lg-3">
                <li class="nav-item">
                    <a class="nav-link" href="#beranda">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#kalkulator">Kalkulator</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#tentang">Tentang</a>
                </li>
            </ul>
        </div>

    </div>
</nav>


<!-- ================= HERO ================= -->
<section class="hero" id="beranda">
    <div class="container py-5">

        <div class="row align-items-center">
            <div class="col-lg-8">

                <span class="badge bg-light text-dark px-3 py-2 mb-3">
                    <i class="bi bi-calculator"></i>
                    Simulasi Pembiayaan Mobil
                </span>

                <h1 class="hero-title mb-3">
                    Hitung Angsuran Mobil
                    <br>
                    dengan Lebih Mudah
                </h1>

                <p class="lead hero-text mb-4">
                    Gunakan kalkulator AutoFinance untuk mengetahui
                    perkiraan cicilan mobil berdasarkan harga, DP,
                    dan tenor yang kamu pilih.
                </p>

                <a href="#kalkulator" class="btn btn-light px-4 py-2 fw-semibold">
                    Mulai Menghitung
                    <i class="bi bi-arrow-down ms-1"></i>
                </a>

            </div>
        </div>

    </div>
</section>


<!-- ================= CONTENT ================= -->
<main class="container" id="kalkulator">

    <div class="card main-card">

        <div class="row g-0">

            <!-- FOTO MOBIL -->
            <div class="col-lg-5 p-3">
                <img
                    src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=900&q=80"
                    alt="Mobil"
                    class="car-photo"
                >
            </div>


            <!-- FORM -->
            <div class="col-lg-7">

                <div class="calculator-head">
                    <h3 class="mb-1 fw-bold">
                        <i class="bi bi-calculator-fill me-2"></i>
                        Kalkulator Angsuran
                    </h3>

                    <p class="mb-0 text-white-50">
                        Masukkan data mobil untuk melihat estimasi cicilan.
                    </p>
                </div>

                <div class="p-4">

                    <form method="POST" action="">

                        <!-- Harga -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Harga Mobil
                            </label>

                            <div class="input-group">
                                <span class="input-group-text">Rp</span>

                                <input
                                    type="number"
                                    name="harga_mobil"
                                    class="form-control"
                                    placeholder="Contoh: 150000000"
                                    min="1"
                                    value="<?php echo isset($_POST['harga_mobil']) ? htmlspecialchars($_POST['harga_mobil']) : ''; ?>"
                                    required
                                >
                            </div>
                        </div>


                        <!-- DP -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Uang Muka / DP
                            </label>

                            <select name="dp" class="form-select" required>
                                <option value="">Pilih persentase DP</option>

                                <?php
                                $daftarDP = [10, 20, 30, 40, 50, 60];

                                foreach ($daftarDP as $nilaiDP) {
                                    $selected = ($dpPersen == $nilaiDP) ? "selected" : "";

                                    echo "<option value='$nilaiDP' $selected>$nilaiDP%</option>";
                                }
                                ?>
                            </select>
                        </div>


                        <!-- Tenor -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold d-block">
                                Pilih Tenor
                            </label>

                            <div class="row g-2">

                                <?php
                                for ($tahun = 1; $tahun <= 5; $tahun++) {

                                    $checked = ($tenor == $tahun) ? "checked" : "";

                                    echo "
                                    <div class='col-6 col-md'>
                                        <label class='tenor-option d-flex align-items-center gap-2'>
                                            <input
                                                type='radio'
                                                name='tenor'
                                                value='$tahun'
                                                class='form-check-input mt-0'
                                                $checked
                                                required
                                            >
                                            <span>$tahun Tahun</span>
                                        </label>
                                    </div>
                                    ";
                                }
                                ?>

                            </div>
                        </div>


                        <!-- Tombol -->
                        <button type="submit" class="btn btn-hitung w-100 fw-bold">
                            <i class="bi bi-calculator me-2"></i>
                            Hitung Angsuran
                        </button>

                    </form>

                </div>
            </div>

        </div>
    </div>


    <!-- ================= HASIL ================= -->
    <?php
    if ($hasil) {
        echo "
        <div class='card result-card mt-5'>

            <div class='result-head'>
                <h4 class='mb-1 fw-bold'>
                    <i class='bi bi-check-circle-fill me-2'></i>
                    Hasil Perhitungan
                </h4>

                <small class='text-white-50'>
                    Berikut adalah perkiraan angsuran berdasarkan data yang dimasukkan.
                </small>
            </div>

            <div class='card-body p-4'>

                <div class='row g-4'>

                    <div class='col-md-6'>

                        <div class='result-row d-flex justify-content-between'>
                            <span>Harga Mobil</span>
                            <strong>" . rupiah($hargaMobil) . "</strong>
                        </div>

                        <div class='result-row d-flex justify-content-between'>
                            <span>DP ($dpPersen%)</span>
                            <strong>" . rupiah($jumlahDP) . "</strong>
                        </div>

                        <div class='result-row d-flex justify-content-between'>
                            <span>Tenor</span>
                            <strong>$tenor Tahun</strong>
                        </div>

                    </div>


                    <div class='col-md-6'>

                        <div class='result-row d-flex justify-content-between'>
                            <span>Bunga</span>
                            <strong>20%</strong>
                        </div>

                        <div class='result-row d-flex justify-content-between'>
                            <span>Nilai Bunga</span>
                            <strong>" . rupiah($bunga) . "</strong>
                        </div>

                        <div class='result-row d-flex justify-content-between'>
                            <span>Total Pembayaran</span>
                            <strong>" . rupiah($totalBayar) . "</strong>
                        </div>

                    </div>

                </div>


                <div class='monthly-box mt-4'>
                    <p class='mb-1 text-muted'>
                        Estimasi Angsuran Per Bulan
                    </p>

                    <h2 class='mb-1'>
                        " . rupiah($angsuran) . "
                    </h2>

                    <small class='text-muted'>
                        selama $tenor tahun atau " . ($tenor * 12) . " bulan
                    </small>
                </div>

            </div>
        </div>
        ";
    }
    ?>


    <!-- ================= TENTANG ================= -->
    <section class="py-5" id="tentang">

        <div class="text-center mb-4">
            <h2 class="section-title">Kenapa Menggunakan AutoFinance?</h2>
            <p class="text-muted">
                Membantu menghitung simulasi angsuran secara sederhana.
            </p>
        </div>

        <div class="row g-4">

            <div class="col-md-4">
                <div class="card feature-card p-4">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-lightning-charge-fill"></i>
                    </div>

                    <h5 class="fw-bold">Cepat</h5>
                    <p class="text-muted mb-0">
                        Hasil perhitungan dapat dilihat setelah data
                        harga, DP, dan tenor dimasukkan.
                    </p>
                </div>
            </div>


            <div class="col-md-4">
                <div class="card feature-card p-4">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-calculator-fill"></i>
                    </div>

                    <h5 class="fw-bold">Mudah Digunakan</h5>
                    <p class="text-muted mb-0">
                        Tampilan sederhana sehingga pengguna dapat
                        mengisi data dengan mudah.
                    </p>
                </div>
            </div>


            <div class="col-md-4">
                <div class="card feature-card p-4">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-car-front-fill"></i>
                    </div>

                    <h5 class="fw-bold">Simulasi Mobil</h5>
                    <p class="text-muted mb-0">
                        Cocok digunakan untuk melihat perkiraan cicilan
                        kendaraan sebelum melakukan pembelian.
                    </p>
                </div>
            </div>

        </div>
    </section>

</main>


<!-- ================= FOOTER ================= -->
<footer>
    <div class="container text-center">

        <div class="mb-2">
            <i class="bi bi-car-front-fill fs-3"></i>
        </div>

        <?php
            echo "<h5 class='fw-bold mb-1'>AutoFinance</h5>";
            echo "<p class='mb-0 text-white-50'>Kalkulator Simulasi Angsuran Mobil</p>";
            echo "<small class='text-white-50'>&copy; " . date("Y") . " AutoFinance</small>";
        ?>

    </div>
</footer>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
