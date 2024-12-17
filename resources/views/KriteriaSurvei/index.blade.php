<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survei BPM</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <style>
        /* Reset CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        /* Warna */
        :root {
            --blue: #2654A1;
            --white: #fff;
            --gray: #f5f5f5;
        }

        /* Body */
        body {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* Sidebar */
        .sidebar {
            background-color: var(--blue);
            color: var(--white);
            width: 250px;
            transition: width 0.3s ease;
            position: relative;
        }

        .sidebar .logo {
            display: flex;
            align-items: center;
            padding: 15px;
            font-size: 20px;
            background-color: #1E4584;
        }

        .sidebar .menu-toggle {
            margin-right: 10px;
            cursor: pointer;
        }

        .sidebar ul {
            list-style-type: none;
            margin-top: 20px;
            padding-left: 0;
        }

        .sidebar ul li {
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .sidebar ul li a {
            text-decoration: none; /* Hilangkan garis bawah link */
            color: inherit; /* Warna mengikuti elemen induk */
            display: flex;
            align-items: center;
            padding: 15px; /* Ruang di sekitar ikon dan teks */
            width: 100%;
        }

        .sidebar ul li i {
            margin-right: 10px;
        }

        /* Hover efek untuk sidebar */
        .sidebar ul li:hover a {
            background-color: #ffffff;  /* background putih */
            color: var(--blue);  /* teks biru */
        }

        /* Active state */
        .sidebar ul li.active a {
            background-color: #ffffff; /* Latar putih */
            color: var(--blue); /* Teks biru */
            font-weight: bold; /* Teks tebal */
        }

        .sidebar ul li.active a i {
            color: var(--blue); /* Warna ikon biru */
        }

        /* Main Content */
        .main-content {
            flex: 1;
            background-color: white;
            transition: margin-left 0.3s ease;
            padding: 20px;
            overflow-y: auto;
        }

        .header h2 {
            margin-bottom: 10px;
        }

        /* Sidebar Collapse */
        .sidebar.collapse {
            width: 60px;
        }

        .sidebar.collapse .logo span,
        .sidebar.collapse ul li span {
            display: none;
        }

        .sidebar.collapse ul li i {
            font-size: 20px;
        }

        .main-content.collapse {
            margin-left: 60px;
        }

        .logout {
            position: absolute;
            bottom: 20px;
            left: 15px;
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .logout i {
            margin-right: 10px;
        }

        /* Styling untuk Pagination dan Breadcrumbs */
        .pagination {
            display: flex;
            list-style-type: none;
            padding-left: 0;
        }

        .page-item {
            margin: 0 5px;
        }

        .page-link {
            padding: 10px 15px;
            color: #007bff;
            text-decoration: none;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .page-item.disabled .page-link {
            color: #ccc;
        }

        .page-item .page-link:hover {
            background-color: #f1f1f1;
        }

        .breadcrumb {
            background-color: #f8f9fa;
            padding: 10px 15px;
            border-radius: 5px;
        }

        .breadcrumb-item {
            display: inline;
            font-size: 14px;
        }

        .breadcrumb-item + .breadcrumb-item::before {
            content: ">";
            padding: 0 10px;
        }

        .breadcrumb-item a {
            text-decoration: none;
            color: #007bff;
        }

        .breadcrumb-item.active {
            color: #6c757d;
        }

        #sidebar.collapse {
        width: 0;
        overflow: hidden;
        transition: width 0.3s ease;
    }


          /* Styles for Navbar, Sidebar, and Main Content
    .navbar {
        background-color: #333;
        padding: 10px;
        color: #fff;
    }
    .btn {
        background: none;
        color: #fff;
        border: none;
        font-size: 20px;
    }

    #sidebar {
        width: 250px;
        background-color: #444;
        transition: width 0.3s ease;
    }
    .sidebar ul {
        list-style: none;
        padding: 0;
    }
    .sidebar ul li a {
        color: #fff;
        text-decoration: none;
        padding: 10px;
        display: block;
    }
    #mainContent {
        margin-left: 250px;
        padding: 20px;
    }
    #sidebar.collapse ~ #mainContent {
        margin-left: 0;
    } */
    </style>
</head>
<body>
        <div class="logo">
            <i class="fas fa-bars menu-toggle" id="menuToggle"></i>
            <span>BPM</span>
        </div>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">

        <ul>
            <li><a href="../index"><i class="fas fa-home"></i><span>Dashboard</span></a></li>
            <li><a href=""><i class="fas fa-list"></i><span>Kriteria Survei</span></a></li>
            <li><a href="../SkalaPenilaian/index"><i class="fas fa-sliders-h"></i><span>Skala Penilaian</span></a></li>
            <li><a href="../PertanyaanSurvei/index"><i class="fas fa-question-circle"></i><span>Pertanyaan</span></a></li>
            <li><a href="../TemplateSurvei/index"><i class="fas fa-file"></i><span>Template Survei</span></a></li>
            <li><a href="../Survei/index"><i class="fas fa-poll"></i><span>Survei</span></a></li>
            <li><a href="../DaftarSurvei/index"><i class="fas fa-list-alt"></i><span>Daftar Survei</span></a></li>
        </ul>
        <div class="logout">
            <i class="fas fa-sign-out-alt"></i> Log Out
        </div>
    </div>

    <!-- Konten Utama -->
    <div class="main-content" id="mainContent">
        <div class="header">
            <div>
                <h1>Kriteria Survei</h1>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">Kriteria Survei</li>
                </ol>
            </nav>
        </div>
        <div class="content">
            <div class="mb-3 mt-5">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="fas fa-plus"></i> Tambah Baru</button>
            </div>
            <div class="row mb-4 col-12">
                <div class="col-md-10">
                    <input type="text" placeholder="Cari Kriteria Survei" class="form-control">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
                </div>
            </div>
            <div class="col-12">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kriteria</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="3" class="text-center">Tidak Ada Data</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Kriteria</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="">
                    <div class="modal-body">
                        <div>
                            <label for="">Nama Kriteria <span style="color:red">*</span></label>
                            <input type="text" placeholder="Masukkan Nama Kriteria" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    // Toggle Sidebar
    const menuToggle = document.getElementById("menuToggle");
    const sidebar = document.getElementById("sidebar");
    const mainContent = document.getElementById("mainContent");

    menuToggle.addEventListener("click", () => {
        sidebar.classList.toggle("collapse"); // Hanya sidebar yang diperkecil
    });

    // Handle Active State untuk Menu
    const menuLinks = document.querySelectorAll(".sidebar ul li a");

    menuLinks.forEach(link => {
        link.addEventListener("click", function() {
            // Menambahkan 'active' hanya pada menu yang dipilih
            menuLinks.forEach(l => l.parentElement.classList.remove("active"));
            this.parentElement.classList.add("active");
        });
    });
</script>
<script>
    // Handle Toggle Sidebar
    const menuToggle = document.getElementById("menuToggle");
    const sidebar = document.getElementById("sidebar");

    menuToggle.addEventListener("click", () => {
        sidebar.classList.toggle("collapse");

        // Ubah ikon tombol menu sesuai status sidebar
        if (sidebar.classList.contains("collapse")) {
            menuToggle.innerHTML = '<i class="fas fa-bars"></i>';
        } else {
            menuToggle.innerHTML = '<i class="fas fa-times"></i>';
        }
    });
</script>

</body>
</html>
