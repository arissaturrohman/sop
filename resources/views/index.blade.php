<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Beranda - SI-RAJA PBJ</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="{{ asset('frontend/img/logo demak.png') }}" rel="icon">
    <link href="{{ asset('frontend/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('frontend/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('frontend/css/main.css') }}" rel="stylesheet">

    <!-- =======================================================
  * Template Name: Passion
  * Template URL: https://bootstrapmade.com/passion-bootstrap-template/
  * Updated: Jul 21 2025 with Bootstrap v5.3.7
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

    <header id="header" class="header fixed-top">

        <div class="branding d-flex align-items-cente">

            <div class="container position-relative d-flex align-items-center justify-content-between">
                <a href="{{ route('home') }}" class="logo d-flex align-items-center">
                    <!-- Uncomment the line below if you also wish to use an image logo -->
                    <img src="{{ asset('img/logo demak.png') }}" alt="">
                    <h1 class="sitename">SI-RAJA PBJ</h1>
                </a>

                <nav id="navmenu" class="navmenu">
                    <ul>
                        <li><a href="{{ route('home') }}" class="active">Beranda</a></li>
                        <li><a href="{{ route('login') }}">Login</a></li>
                    </ul>
                    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
                </nav>

            </div>

        </div>

    </header>

    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero section dark-background">

            <div class="hero-background">
                <img src="{{ asset('frontend/img/bg-14.webp') }}" alt="" data-aos-duration="1000">
                <div class="overlay"></div>
            </div>

            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="hero-content">
                            <span class="hero-badge">SI-RAJA</span>
                            <h1>Sistem Informasi Regulasi & SOP Pengadaan Barang dan Jasa</h1>
                            <p>Selamat datang di Sistem Si Raja, untuk menuju Demak Smart City dan mendukung keterbukaan
                                data dan informasi di Kabupaten Demak</p>
                            {{-- <div class="hero-actions">
                <a href="#services" class="btn-primary">Explore Services</a>
                <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="btn-secondary glightbox">
                  <i class="bi bi-play-circle"></i>
                  <span>Watch Demo</span>
                </a>
              </div> --}}
                            <div class="hero-stats">
                                <div class="stat-item">
                                    <span class="stat-number">{{ $today }}</span>
                                    <span class="stat-label">Pengunjung Hari ini</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-number">{{ $month }}</span>
                                    <span class="stat-label">Pengunjung Bulan ini</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-number">{{ $total }}</span>
                                    <span class="stat-label">Total Pengunjung</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="hero-visual">
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="feature-card">
                                        <i class="bi bi-shield-check"></i>
                                        <span>Secure &amp; Reliable</span>
                                    </div>
                                    <div class="feature-card">
                                        <i class="bi bi-transparency"></i>
                                        <span>Transparency & Accountability</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="feature-card">
                                        <i class="bi bi-search"></i>
                                        <span>Smart Search</span>
                                    </div>
                                    <div class="feature-card">
                                        <i class="bi bi-rocket-takeoff"></i>
                                        <span>Easy & Fast Access</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section><!-- /Hero Section -->

        <!-- About Section -->
        <section id="about" class="about section">

            <div class="container">

                <h1 class="mb-4">Daftar Dokumen SOP & SP</h1>

                <!-- Filter Form -->
                <form method="GET" action="{{ route('home') }}" class="row g-3 mb-4">
                    <div class="col-md-4">
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="form-control form-control-lg" placeholder="Cari data...">
                    </div>

                    <div class="col-md-2">
                        <select name="opd" class="form-select form-control-lg">
                            <option value="">-- Semua OPD --</option>
                            @foreach ($opds as $opd)
                                <option value="{{ $opd->id }}"
                                    {{ request('opd') == $opd->id ? 'selected' : '' }}>
                                    {{ $opd->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="tahun" class="form-select form-control-lg">
                            <option value="">-- Semua Tahun --</option>
                            @foreach ($tahunList as $tahun)
                                <option value="{{ $tahun }}"
                                    {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                    {{ $tahun }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="jenis" class="form-select form-control-lg">
                            <option value="">-- Semua Jenis --</option>
                            <option value="SOP" {{ request('jenis') == 'SOP' ? 'selected' : '' }}>SOP</option>
                            <option value="SP" {{ request('jenis') == 'SP' ? 'selected' : '' }}>SP</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button class="btn btn-primary w-100"><i class="bi bi-search"></i> Filter</button>
                    </div>

                    {{-- TOMBOL RESET muncul hanya jika ada filter aktif --}}
                    <div class="col-md-2 d-grid ms-auto">
                        @if (request()->has('search') || request()->has('opd') || request()->has('tahun') || request()->has('jenis'))
                            <button type="button" class="btn btn-danger" onclick="resetForm()"><i
                                    class="bi bi-arrow-clockwise"></i> Reset</button>
                        @endif
                    </div>

                </form>
                <hr>

                <!-- Table SOP -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="tableData">
                        <thead>
                            <tr>
                                <th class="d-none">Judul</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sops as $index => $sop)
                                <tr>
                                    <td class="align-top px-3 py-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex flex-column gap-1">
                                                <h5 class="fw-semibold mb-0">{{ $sop->judul }}</h5>
                                                <div class="text-muted small">{{ $sop->opd->name ?? '-' }}</div>
                                                <div class="text-secondary small">
                                                    {{ \Carbon\Carbon::parse($sop->created_at)->translatedFormat('d-M-Y') }}
                                                </div>
                                            </div>

                                            <div class="ms-3">
                                                @if ($sop->file)
                                                    <a href="{{ asset('storage/' . $sop->file) }}" target="_blank"
                                                        class="btn btn-sm btn-success">
                                                        <i class="bi bi-eye"></i> Lihat
                                                    </a>
                                                @else
                                                    <em class="text-muted small">Tidak ada file</em>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $sops->withQueryString()->links() }}
                </div>

            </div>

        </section><!-- /About Section -->


    </main>

    <footer id="footer" class="footer position-relative dark-background">

        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-5 col-md-12 footer-about">
                    <a href="/" class="logo d-flex align-items-center">
                        <span class="sitename">SI-RAJA</span>
                    </a>
                    <p>SOP Management adalah aplikasi berbasis web yang digunakan untuk mengelola Standard Operating
                        Procedure (SOP) secara terpusat, aman, dan mudah diakses.</p>
                    {{-- <div class="social-links d-flex mt-4">
                        <a href=""><i class="bi bi-twitter-x"></i></a>
                        <a href=""><i class="bi bi-facebook"></i></a>
                        <a href=""><i class="bi bi-instagram"></i></a>
                        <a href=""><i class="bi bi-linkedin"></i></a>
                    </div> --}}
                </div>

                <div class="col-lg-2 col-6 footer-links">
                    {{-- <h4>Useful Links</h4>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About us</a></li>
                        <li><a href="#">Services</a></li>
                        <li><a href="#">Terms of service</a></li>
                        <li><a href="#">Privacy policy</a></li>
                    </ul> --}}
                </div>

                <div class="col-lg-2 col-6 footer-links">
                    {{-- <h4>Our Services</h4>
                    <ul>
                        <li><a href="#">Web Design</a></li>
                        <li><a href="#">Web Development</a></li>
                        <li><a href="#">Product Management</a></li>
                        <li><a href="#">Marketing</a></li>
                        <li><a href="#">Graphic Design</a></li>
                    </ul> --}}
                </div>

                <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
                    <h4>Hubungi Kami</h4>
                    <p>Bagian Pengadaan Barang/Jasa</p>
                    <p>Setda Kabupaten Demak Gedung B Lt. 1</p>
                    <p>Jl. Kyai Singkil No. 7 Demak - 59511</p>
                    <p class="mt-4"><strong>Helpdesk:</strong> <span><a
                                href="https://wa.me/6289666000717">089-666-000-717</a></span> (Chat Only)</p>
                    <p><strong>Email:</strong> <span>ukpbjdemak@gmail.com</span></p>
                </div>

            </div>
        </div>

        <div class="container text-center mt-4">
            <p>© <span>Copyright</span> <strong class="px-1 sitename">SI-RAJA</strong> <span>All Rights
                    Reserved</span></p>
            <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you've purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
            </div>
        </div>

    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>

    <!-- Vendor JS Files -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('frontend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('frontend/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('frontend/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <!-- DataTables -->

    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.min.js"></script>

    <!-- Main JS File -->
    <script src="{{ asset('frontend/js/main.js') }}"></script>
    <script>
        // Fungsi untuk mengatur ulang form filter
        function resetForm() {
            const url = new URL(window.location.href);
            url.searchParams.delete('search');
            url.searchParams.delete('opd');
            url.searchParams.delete('tahun');
            url.searchParams.delete('jenis');
            window.location.href = url.toString();
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#tableData').DataTable({
                    searching: false,
                    lengthMenu: [
                        [5, 10, 25],
                        [5, 10, 25]
                    ],
                    language: {
                        "emptyTable": "Tidak ada data yang tersedia",
                        "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                        "infoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
                        "infoFiltered": "(disaring dari _MAX_ total data)",
                        "lengthMenu": "Tampilkan _MENU_ data",
                        "zeroRecords": "Tidak ditemukan data yang sesuai",
                        "paginate": {
                            "first": "Pertama",
                            "last": "Terakhir",
                            "next": "Selanjutnya",
                            "previous": "Sebelumnya"
                        },
                    },
                }

            );
        });
    </script>

</body>

</html>
