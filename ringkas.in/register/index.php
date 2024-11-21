<?php
session_start();
include '../dburl.php';
$error = '';

if (isset($_POST['register']))  {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmpassword'] ?? '';

    $checkEmailQuery = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($connection, $checkEmailQuery);

    if (mysqli_num_rows($result) > 0) {
        $error = "Email sudah terdaftar. Silahkan menggunakan email lain.";
    } elseif ($password !== $confirmPassword) {
        $error = "Kata sandi tidak cocok. Pastikan kedua kata sandi sama.";
    } else {
        $password = sha1($password);
        $sql = "INSERT INTO users (Email, Password, Nama) VALUES ('$email', '$password', '$name')";
        
        if (mysqli_query($connection, $sql)) {

            // session untuk menyimpan sesi login

            header("Location: ../login");
            exit();
        } else {
            $error = "Terjadi kesalahan saat menjalankan query: " . mysqli_error($connection);
        }
    }
}

if ($error) {
    echo "<script>alert('$error');</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
    <title>register page</title>
</head>

<body>
    <!-- bulma navbar -->
    <h1>
        <nav class="navbar is-spaced has-shadow is-dark" role="navigation" aria-label="main navigation">
            <div class="navbar-brand">
                <a class="navbar-item" href="../">
                <img src="../style/img/logo.png" alt="web logo" style="max-height: 45px;;">
                </a>
            </div>

            <div id="navbarBasicExample" class="navbar-end is-active is-right">

                <div class="navbar-end is-right">

                    <div class="navbar-item  is-right">
                        <div class="buttons">
                            <a class="button is-info" href="./">
                                Sign up
                            </a>
                            <a class="button is-warning" href="../login">
                                Log in
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </nav> <!-- navbar end -->
    </h1>
    
    <p>

    <section section class="hero is-fullheight-with-navbar">
        <div class="hero-body">
            <div class="container">
                <!-- ini header login -->
                <h3 class="columns title is-centered">Register</h3>
                <p class="columns is-centered subtittle">Bikin akun anda</p>
                <!-- header end -->
                <!-- textbox register -->
                <div class="column is-4 is-offset-4">
                    <div class="box">
                        <form action="" method="post">
                            <div class="field">
                                <div class="field">
                                    <div class="control">
                                        <input name="name" class="input is-medium" type="input" placeholder="Nama" required />
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="control">
                                        <input name="email" class="input is-medium" type="email" placeholder="Email" required/>
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="control">
                                        <input name="password" class="input is-medium" type="password" required
                                            placeholder="Password" />
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="control">
                                        <input name="confirmpassword" type="password" class="input is-medium"
                                            placeholder="konfirmasi password">
                                    </div>

                                    <div class="field">
                                        <div class="buttons is-right column is-8 is-offset-9">
                                            <input name="register" type="submit"
                                                class="button is-dark is-warning is-right" value="Register">
                                        </div>
                                    </div>

                        </form>
                    </div>
                    <!-- box isi -->

                    <!-- box end -->
                </div>
            </div>
            <!-- text viewBox end -->
        </div>
        </>
    </section>

    </p>


</body>

<footer class="footer">
    <div class="content has-text-centered">

        <p>
            <strong>ringkas.in</strong> by <a href="https://www.instagram.com/ardhyc/">Billal Ardi F.</a>
            Terimakasih untuk
            <a href="https://Bulma.io/">Bulma.io</a>. untuk library css
            <!-- a untuk link text -->
        </p>
    </div>
</footer>

</html>