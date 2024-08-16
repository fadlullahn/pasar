<?php
require("../config/koneksi.php");

if (isset($_GET['tambah_pasar'])) {
    tambah_pasar();
}

function tambah_pasar()
{
    global $conn;

    $lat = mysqli_real_escape_string($conn, $_GET['latitude']);
    $lng = mysqli_real_escape_string($conn, $_GET['longitude']);
    $nsentral = mysqli_real_escape_string($conn, $_GET['nsentral']);
    $nama = mysqli_real_escape_string($conn, $_GET['nama']);
    $deskripsi = mysqli_real_escape_string($conn, $_GET['deskripsi']);

    $query = sprintf(
        "INSERT INTO pasar (idl, latitude, longitude, nsentral, nama, deskripsi) VALUES (NULL, '%s', '%s', '%s', '%s','%s');",
        $lat,
        $lng,
        $nsentral,
        $nama,
        $deskripsi
    );

    $result = mysqli_query($conn, $query);

    if ($result) {
        echo json_encode("Data pasar Berhasil Disimpan");
    } else {
        die('Invalid query: ' . mysqli_error($conn));
    }
}

function get_pasar()
{
    global $conn;

    $sqldata = mysqli_query($conn, "SELECT longitude, latitude, nama, idl FROM pasar");

    $rows = array();

    while ($r = mysqli_fetch_assoc($sqldata)) {
        $rows[] = $r;
    }

    // Pastikan data dikembalikan sebagai JSON dengan nama pasar
    echo json_encode($rows);

    if (!$rows) {
        return null;
    }
}


if (isset($_GET['action']) && $_GET['action'] == 'get_pasar_by_idl') {
    $idl = intval($_GET['idl']);
    get_pasar_by_idl($idl);
}

function get_pasar_by_idl($idl)
{
    global $conn;

    $query = "SELECT * FROM pasar WHERE idl = $idl";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $data = mysqli_fetch_assoc($result);
        echo "<p>Nama: " . $data['nama'] . "</p>";
        echo "<p>Deskripsi: " . $data['deskripsi'] . "</p>";
        echo "<p>Latitude: " . $data['latitude'] . "</p>";
        echo "<p>Longitude: " . $data['longitude'] . "</p>";
    } else {
        echo "Data tidak ditemukan.";
    }
}
