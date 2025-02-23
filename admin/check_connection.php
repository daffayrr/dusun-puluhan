<?php
require '../Database/config.php';

// Fungsi untuk cek HTTP status
function checkHttpStatus($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $http_code;
}

// Fungsi untuk cek ping
function getPing($host) {
    $ping_result = exec("ping -c 1 " . escapeshellarg($host) . " | grep 'time='");
    preg_match('/time=([\d.]+) ms/', $ping_result, $matches);
    return isset($matches[1]) ? $matches[1] . " ms" : "Timeout";
}

$server_url = "https://yourwebsite.com"; // Ganti dengan URL server
$http_status = checkHttpStatus($server_url);
$server_ping = getPing(parse_url($server_url, PHP_URL_HOST));

echo json_encode(["http_status" => $http_status, "server_ping" => $server_ping]);
