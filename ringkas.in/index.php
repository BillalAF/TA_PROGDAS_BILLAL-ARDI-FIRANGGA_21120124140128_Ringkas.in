<!-- login session -->
<?php
include 'dburl.php';
session_start();
$login = isset($_SESSION["email"]);
$email = "";
$name = "";
$shrt_url = ""; // Inisialisasi variabel
$error_message = ""; // Inisialisasi variabel untuk pesan kesalahan

if ($login) {   
    $email = $_SESSION["email"];
    $name = $_SESSION["name"];
}

function generateShortCode($length = 6) {
    return substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, $length);
}

function isValidUrl($url) {
    // Cek format URL
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        return false;
    }

    // Cek ketersediaan URL
    $headers = @get_headers($url);
    if ($headers && strpos($headers[0], '200') !== false) {
        return true;
    }

    return false;
}

// shortner start
if (isset($_POST['Generate'])) { 
    // checking login
    if (!$login){
        header('location: login/');
        exit();
    }
    
    $long_url = $connection->real_escape_string($_POST['url']);
    
    // Validasi URL
    if (!isValidUrl($long_url)) {
        $error_message = 'URL tidak valid atau tidak dapat diakses. Silakan coba lagi.';
    } else {
        do {
            $shrt_url = generateShortCode();
            // Check apakah kode pendek sudah ada
            $result = $connection->query("SELECT * FROM urls WHERE shrt_url = '$shrt_url'");
        } while ($result->num_rows > 0); // Ulangi sampai mendapatkan kode unik

        // Check Url apakah sudah ada
        $result = $connection->query("SELECT * FROM urls WHERE long_url = '$long_url' and user_email = '$email'");
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $shrt_url = $row['shrt_url'];
        } else {
            // Pastikan $shrt_url tidak kosong sebelum menyimpan
            if (!empty($shrt_url)) {
                $connection->query("INSERT INTO urls (long_url, shrt_url, user_email) VALUES ('$long_url', '$shrt_url', '$email')");
            } else {
                $error_message = 'Gagal menghasilkan kode pendek. Silakan coba lagi.';
            }
        }
    }
  
    // Check Url apakah sudah ada
    $result = $connection->query("SELECT * FROM urls WHERE long_url = '$long_url' and user_email = '$email'");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $shrt_url = $row['shrt_url'];
    } else {
        // Pastikan $shrt_url tidak kosong sebelum menyimpan
        if (!empty($shrt_url)) {
            $connection->query("INSERT INTO urls (long_url, shrt_url, user_email) VALUES ('$long_url', '$shrt_url', '$email')");
        } else {
            $error_message = 'Gagal menghasilkan kode pendek. Silakan coba lagi.';
        }
    }

    // header("location: hasil/index.php?shrt=$shrt_url");
}
?>
<!-- url shoterner end -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
    <link rel="stylesheet" href="./style/pom.css">

    <title>main page</title>
    <h1>
        <nav class="navbar is-spaced has-shadow is-dark" role="navigation" aria-label="main navigation">
            <div class="navbar-brand">
                <a class="navbar-item" href=".">
                    <img src="style/img/logo.png" alt="web logo" style="max-height: 45px;;">
                </a>
            </div>

            <div id="navbarBasicExample" class="navbar-end is-active is-right">

                <div class="navbar-end is-right">

                    <div class="navbar-item  is-right">
                        <div class="buttons">

                            <?php 
                             if (!$login) :
                            ?>
                            <a class="button is-info" href="register\">
                                Sign up
                            </a>
                            <a class="button is-warning" href="login\">
                                Log in
                            </a>
                            <?php
                            else : 
                            ?>
                            <a class="button is-danger" href="logout.php">
                                log out
                            </a>
                            <?php
                             endif;
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </nav> <!-- navbar end -->
    </h1>

</head>

<body>

    <h1>
        <?php
         strtoupper("WELCOME $name \n");
        ?>
    </h1>

    <p>
    <section class="hero has-background-black  is-fullheight">
        <div class="hero-body">

            <div class="container">
                <!-- ini header text -->

                <h2 class="container title is-size-1 has-text-centered"> <?php
                    echo ucwords("welcome $name \n");
                        ?> </h2>
                <h2 class="container title is-size-1 has-text-centered">

                    Mari meringkas link yang anda miliki

                </h2>


                <!-- header end -->
                <!-- link generate box -->
                <div class="column is-narrow">
                    <form action="" method="post">
                        <div class="field">
                            <div class="field is-grouped">

                                <p class="control is-expanded">
                                    <input class="input is-large is-size-4 is-rounded " type="url" required
                                        placeholder="Masukan link yang anda punya" name="url">
                                </p>

                                <p class="control">
                                <div class="buttons are-medium is-right ">
                                    <input name="Generate" class="button is-size-4 is-rounded is-danger has-text-white"
                                        type="submit" value="Generate" />
                                </div>
                                </p>

                            </div>
                    </form>
            

                </div>


                <div class="hero-body">
                </div>
            </div>
            <!-- link generate box end-->
            </form>
            <!-- tabel history -->
            <h3>
                <div class="table-container">
                    <table class="table is-hoverable is-size-6 is-bordered is-fullwidth" id="tabel">
                        <thead class=" is-bordered">
                            <tr class="is-link">
                                <th>Link sebelumnya</th>
                                <th>hasil </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $query = mysqli_query($connection,"select * from urls WHERE user_email ='$email'");
                            while ($row = mysqli_fetch_assoc($query)) { ?>
                            <tr>
                                <td class="is-bordered"><?php echo $row['long_url']; ?></td>
                                <td class="is-bordered">
                                    <?php echo "http://localhost/ringkas.in/link?shrt=".$row['shrt_url']; ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </h3>
            <!-- end -->
        </div>
        </div>
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
