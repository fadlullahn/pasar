<?php
require("../config/koneksi.php");

if (isset($_GET['tambah_sentral'])) {
    tambah_sentral();
}

function tambah_sentral()
{
    global $conn;

    $lat = mysqli_real_escape_string($conn, $_POST['latitude']);
    $lng = mysqli_real_escape_string($conn, $_POST['longitude']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    // Menangani unggahan gambar
    if (isset($_FILES['images']) && $_FILES['images']['error'] == UPLOAD_ERR_OK) {
        $imagesTmpName = $_FILES['images']['tmp_name'];
        $fileExtension = strtolower(pathinfo($_FILES['images']['name'], PATHINFO_EXTENSION));

        // Generate nama gambar berdasarkan idl dan nama
        // Langkah 1: Insert data terlebih dahulu untuk mendapatkan idl
        $query = "INSERT INTO sentral (latitude, longitude, nama, deskripsi) VALUES ('$lat', '$lng', '$nama', '$deskripsi')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $idl = mysqli_insert_id($conn); // Ambil idl terakhir yang diinsert

            // Format nama gambar
            $formattedName = str_replace(' ', '-', $nama);
            $imagesName = $formattedName . '-' . $idl . '.' . $fileExtension;
            $imagesPath = '../uploads/' . $imagesName;

            // Periksa ekstensi file
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($fileExtension, $allowedExtensions)) {
                if (move_uploaded_file($imagesTmpName, $imagesPath)) {
                    // Update nama file gambar di database
                    $updateQuery = "UPDATE sentral SET images = '$imagesName' WHERE idl = $idl";
                    $updateResult = mysqli_query($conn, $updateQuery);

                    if (!$updateResult) {
                        die('Gagal mengupdate nama gambar di database.');
                    }
                } else {
                    die('Gagal memindahkan gambar.');
                }
            } else {
                die('Ekstensi file tidak diizinkan.');
            }

            echo json_encode("Data sentral Berhasil Disimpan");
        } else {
            die('Invalid query: ' . mysqli_error($conn));
        }
    } else {
        // Jika tidak ada gambar diunggah
        $imagesNameOnly = NULL; // Atau kosongkan jika tidak ada gambar
        // Insert data tanpa gambar
        $query = sprintf(
            "INSERT INTO sentral (idl, latitude, longitude, nama, deskripsi, images) VALUES (NULL, '%s', '%s', '%s', '%s', '%s');",
            $lat,
            $lng,
            $nama,
            $deskripsi,
            $imagesNameOnly
        );

        $result = mysqli_query($conn, $query);

        if ($result) {
            echo json_encode("Data sentral Berhasil Disimpan");
        } else {
            die('Invalid query: ' . mysqli_error($conn));
        }
    }
}



function get_sentral()
{
    global $conn;

    $sqldata = mysqli_query($conn, "SELECT longitude, latitude, nama, idl FROM sentral");

    $rows = array();

    while ($r = mysqli_fetch_assoc($sqldata)) {
        $rows[] = $r;
    }

    // Pastikan data dikembalikan sebagai JSON dengan nama sentral
    echo json_encode($rows);

    if (!$rows) {
        return null;
    }
}


if (isset($_GET['action']) && $_GET['action'] == 'get_sentral_by_idl') {
    $idl = intval($_GET['idl']);
    get_sentral_by_idl($idl);
}

function get_sentral_by_idl($idl)
{
    global $conn;

    $query = "SELECT * FROM sentral WHERE idl = $idl";
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
