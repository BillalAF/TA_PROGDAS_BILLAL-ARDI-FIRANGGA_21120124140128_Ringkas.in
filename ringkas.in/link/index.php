<?php
include '../dburl.php';

if (isset($_GET['shrt'])) {
    $code = $connection->real_escape_string($_GET['shrt']);
    $result = $connection->query("SELECT * FROM urls WHERE shrt_url = '$code'");

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        header(header: "Location: " . $row['long_url']);
        exit();

    } else {
        echo "Short URL not found!";
    }
} else {
    echo "No short code provided!";
}
?>
