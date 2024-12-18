<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Link Google Fonts untuk Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <!-- Link FontAwesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <title>Login Page</title>
<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Poppins', sans-serif; /* Menggunakan font Poppins */
    background-color: #f4f4f4;
}

.container {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background-color: #ffffff;
}

/* header {
    text-align: center;
    margin-bottom: 30px;
    margin-top:0px;
} */


h1 {
    font-size: 24px;
    color: #2654A1; /* Menggunakan warna biru sesuai kode */
    margin-top: 10px;
}

.content {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 80%;
    max-width: 1200px;
    padding: 20px;
    gap: 40px;
}

.image-section {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
}

.illustration {
    max-width: 100%;
    height: auto;
}

.login-form {
    flex: 1;
    max-width: 400px;
    background-color: #ffffff;
    padding: 30px;
    border-radius: 40px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.login-form h2 {
    text-align: center;
    margin-bottom: 20px;
    font-size: 22px;
    color: #333;
}

.login-form label {
    display: block;
    margin-bottom: 8px;
    font-size: 14px;
    color: #333;
}

.login-form input {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.login-form button {
    width: 100%;
    padding: 10px;
    background-color: #2654A1; /* Warna biru sesuai kode */
    border: none;
    border-radius: 5px;
    color: white;
    font-size: 16px;
    cursor: pointer;
}

.login-form button:hover {
    background-color: #1d4590; /* Menggunakan warna biru yang lebih gelap saat hover */
}
footer {
    background-color: #2654A1; /* Warna biru sesuai kode */
    color: white;
    text-align: center;
    padding: 20px 0;
    width: 100%;
    position: absolute;
    bottom: 0;
    left: 0;
}
header {
    background-color: #2654A1; /* Warna biru sesuai kode */
    color: white;
    text-align: left;
    padding: 20px 0;
    width: 100%;
    position: absolute;
    top: 0;
    left: 0;
}
.input-group {
    position: relative;
    margin-bottom: 20px;
}

.input-group i {
    position: absolute;
    left: 15px;
    top: 30%;
    transform: translateY(-50%);
    color: #2654A1; /* Ikon berwarna biru */
}

.input-group input {
    width: 100%;
    padding: 10px 10px 10px 40px; /* Memberi ruang agar ikon tidak tertutup */
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
}


footer a {
    color: white;
    text-decoration: none;
}

footer a:hover {
    text-decoration: underline;
}

</style>    
</head>
<body>
    <div class="container">
        
        <header>
            <img style="width:10% " src="{{ asset('images/logobpm.png') }}" alt="BPM Astra" >
           
        </header>
        <h1>Sejahtera Bersama Bangsa</h1>
        <div class="content">
      
            <!-- <div class="image-section">
                <img src="image.png" alt="Illustration" class="illustration">
            </div> -->
            <div class="login-form">
                <h2 style="color:#2654A1" class="border-bottom">Login</h2>
                <form action="{{ route('login.store') }}" method="POST">
                    @csrf
                <div class="input-group">
                    <i class="fas fa-user"></i> <!-- Ikon untuk Username -->
                    <input type="text" id="username" name="username" placeholder="Username" required/>
                </div>

                <div class="input-group">
                    <i class="fas fa-lock"></i> <!-- Ikon untuk Password -->
                    <input type="password" id="password" name="password" placeholder="Password" required/>
                </div>
            <button type="submit">Masuk</button>
                </form>
            </div>
        </div>
            <!-- Header -->

        <footer>
    <p>© 2024 Badan Penjamin Mutu Politeknik Astra. All Rights Reserved.</p>
</footer>

    </div>
</body>
</html>
