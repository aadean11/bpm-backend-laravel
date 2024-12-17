<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Sidebar</title>
    <!-- Link FontAwesome untuk ikon -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

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
            padding-left:0;
        }

        .sidebar ul li {
            padding: 15px;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .sidebar ul li i {
            margin-right: 10px;
        }

        .sidebar ul li:hover {
            background-color: #ffffff;
            color: var(--blue);
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

        /* Sembunyikan teks pada sidebar saat collapsed */
        .sidebar.collapse .logo span,
        .sidebar.collapse ul li span {
            display: none;
        }

        /* Pastikan ikon tetap terlihat */
        .sidebar.collapse ul li i {
            font-size: 20px; /* ukuran ikon agar tetap terlihat dengan baik */
        }

        .sidebar.collapse .menu-toggle {
            margin-right: 0;
        }

        .sidebar.collapse .logout i {
            margin: 0 auto;
        }

        .main-content.collapse {
            margin-left: 60px;
        }
                /* Hover efek untuk sidebar */
        .sidebar ul li:hover {
            background-color: #ffffff;  /* background putih */
            color: var(--blue);  /* teks biru */
        }

        /* Mengubah warna ikon saat hover */
        .sidebar ul li:hover i {
            color: var(--blue);  /* ikon menjadi biru saat hover */
        }

        /* Mengubah warna teks saat hover */
        .sidebar ul li:hover span {
            color: var(--blue);  /* teks menjadi biru saat hover */
        }
                /* Active state untuk menu */
        .sidebar ul li.active {
            background-color: #ffffff; /* Latar putih */
            color: var(--blue); /* Teks biru */
            font-weight: bold; /* Teks tebal */
        }

        .sidebar ul li.active i {
            color: var(--blue); /* Warna ikon biru */
        }

    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="logo">
            <i class="fas fa-bars menu-toggle" id="menuToggle"></i>
            <span>BPM</span>
        </div>
        <ul>
            <li><i class="fas fa-home" active></i><span> Dashboard</span></li>
            <li><i class="fas fa-list"></i><span> Kriteria Survei</span></li>
            <li><i class="fas fa-sliders-h"></i><span> Skala Penilaian</span></li>
            <li><i class="fas fa-question-circle"></i><span> Pertanyaan</span></li>
            <li><i class="fas fa-file"></i><span> Template Survei</span></li>
            <li><i class="fas fa-poll"></i><span> Survei</span></li>
            <li><i class="fas fa-list-alt"></i><span> Daftar Survei</span></li>
        </ul>
        <div class="logout">
            <i class="fas fa-sign-out-alt"></i> Log Out
        </div>
    </div>

    <!-- Konten Utama -->
    <div class="main-content" id="mainContent">
        <!-- Header -->
        <div class="header">
            <h2>Konten Utama</h2>
        </div>
        <div class="content">
            <p>Ini adalah konten utama. Sidebar dapat ditutup dan konten akan menyesuaikan ukuran.</p>
        </div>
    </div>

    <!-- Link JavaScript -->
    <script>
        // Toggle Sidebar
        const menuToggle = document.getElementById("menuToggle");
        const sidebar = document.getElementById("sidebar");
        const mainContent = document.getElementById("mainContent");

        menuToggle.addEventListener("click", () => {
            sidebar.classList.toggle("collapse");
            mainContent.classList.toggle("collapse");
        });
    </script>

    <script>
        // Ambil semua elemen <li> di sidebar
const menuItems = document.querySelectorAll(".sidebar ul li");

// Tambahkan event listener untuk setiap menu item
menuItems.forEach((item) => {
    item.addEventListener("click", () => {
        // Hapus class 'active' dari semua item
        menuItems.forEach((menu) => menu.classList.remove("active"));

        // Tambahkan class 'active' ke item yang diklik
        item.classList.add("active");
    });
});

    </script>
</body>
</html>
