<?php
include '../dburl.php';
session_start();
if (isset($_SESSION["email"])) {
    header("location: ../");
    exit();
}
if(@$_POST['login']){
    $email = $_POST ['email'];
    $password = sha1($_POST ['password']);
    
    
    $sql = "SELECT * FROM users WHERE Email = '$email' AND Password ='$password'";   
    $results = mysqli_query($connection,$sql);

      if(mysqli_num_rows(result: $results) > 0){
         $row = mysqli_fetch_array(result: $results);
         $_SESSION["email"] = $row["Email"];
         $_SESSION["name"] = $row["Nama"];
         header ("location: ../");
         
         }
         else{
            echo "<script>alert('email dan password salah!!');</script>";
        }
    }
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
    <title>login page</title>

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
                            <a class="button is-info" href="../register">
                                <strong>Sign up</strong>
                            </a>
                            <a class="button is-warning" href="../login">
                                Log in
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </nav> <!-- navbar end -->
</head>

<body>
    </h1>
    <p>
    <section section class="hero is-fullheight-with-navbar">
        <div class="hero-body">
            <div class="container">
                <!-- ini header login -->
                <h3 class="columns title is-centered">Login</h3>
                <p class="columns is-centered subtittle">mohon masukan akun anda untuk melanjutkannya</p>
                <!-- header end -->
                <!-- textbox login -->
                <div class="column is-4 is-offset-4">
                    <div class="box">
                        <form action="" method="post">
                            <div class="field">
                                <div class="control">
                                    <input name="email" class="input is-medium" type="email" required placeholder="Email" />
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <input name="password" class="input is-medium" required type="password"
                                        placeholder="Password" />
                                </div>
                            </div>
                            <div class="buttons is-right">
                                <input name="login" type="submit" class="button is-dark is-warning is-right"
                                    value="Login">
                            </div>

                        </form>

                    </div>
                </div>
                <!-- text Box end -->
            </div>
        </div>
    </section>

    </p>


</body>
<!-- footer -->
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
<!-- footer end -->

</html>