<?php
session_start();

$bahasa_tersedia = ["id", "en"];
$pilihan = $_GET["lang"] ?? "";

if (in_array($pilihan, $bahasa_tersedia)) {
    $_SESSION["bahasa"] = $pilihan;
}

$tujuan  = "/BookManage/dashboard.php";
$referer = $_SERVER["HTTP_REFERER"] ?? "";

if ($referer !== "") {
    $path  = parse_url($referer, PHP_URL_PATH);
    $query = parse_url($referer, PHP_URL_QUERY);

    if ($path && strpos($path, "/BookManage/") === 0 && strpos($path, "set_bahasa.php") === false) {
        $tujuan = $path;
        if ($query) {
            $tujuan .= "?" . $query;
        }
    }
}

header("Location: " . $tujuan);
exit;