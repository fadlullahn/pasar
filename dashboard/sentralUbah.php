<?php
include '../config/koneksi.php';

// Jika ID sentral ada di URL, ambil datanya
if (isset($_GET['idl'])) {
    $idl = $conn->real_escape_string($_GET['idl']);

    $result = $conn->query("SELECT * FROM sentral WHERE idl = '$idl'");
    $sentral = $result->fetch_assoc();

    if (!$sentral) {
        die("Sentral tidak ditemukan.");
    }
} else {
    die("ID Sentral tidak ditemukan.");
}

// Proses form jika metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idl = $conn->real_escape_string($_POST['idl']);
    $latitude = $conn->real_escape_string($_POST['latitude']);
    $longitude = $conn->real_escape_string($_POST['longitude']);
    $nama = $conn->real_escape_string($_POST['nama']);
    $deskripsi = $conn->real_escape_string($_POST['deskripsi']);

    $currentImageName = $sentral['images']; // Nama gambar lama

    // Menangani unggahan gambar
    if (isset($_FILES['images']) && $_FILES['images']['error'] == UPLOAD_ERR_OK) {
        $imagesTmpName = $_FILES['images']['tmp_name'];
        $fileExtension = strtolower(pathinfo($_FILES['images']['name'], PATHINFO_EXTENSION));

        // Format nama gambar baru
        if ($currentImageName) {
            // Menggunakan nama gambar lama dan idl untuk format baru
            $formattedName = str_replace(' ', '-', $nama);
            $newImageName = $formattedName . '-' . $idl . '.' . $fileExtension;
            $imagesPath = '../uploads/' . $newImageName;
        } else {
            $newImageName = basename($_FILES['images']['name']);
            $imagesPath = '../uploads/' . $newImageName;
        }

        // Periksa ekstensi file
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($fileExtension, $allowedExtensions)) {
            if (move_uploaded_file($imagesTmpName, $imagesPath)) {
                // Hapus gambar lama dari server jika ada
                if ($currentImageName && file_exists('../uploads/' . $currentImageName)) {
                    unlink('../uploads/' . $currentImageName);
                }
                // Simpan nama file gambar baru
                $imageNameOnly = $newImageName;
            } else {
                die('Gagal memindahkan gambar.');
            }
        } else {
            die('Ekstensi file tidak diizinkan.');
        }
    } else {
        $imageNameOnly = $currentImageName; // Gunakan nama gambar lama jika tidak ada gambar baru
    }

    $sql = "UPDATE sentral SET latitude='$latitude', longitude='$longitude', nama='$nama', deskripsi='$deskripsi', images='$imageNameOnly' WHERE idl='$idl'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
        alert('Sentral berhasil diperbarui.');
        window.location.href = 'index.php?page=sentral';
      </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>



<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-4">Edit sentral</h1>
    <form action="" method="post" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md">
        <input type="hidden" name="idl" value="<?php echo htmlspecialchars($sentral['idl']); ?>">
        <div class="mb-4">
            <label for="latitude" class="block text-gray-700 font-bold mb-2">Latitude:</label>
            <input type="text" id="latitude" name="latitude" value="<?php echo htmlspecialchars($sentral['latitude']); ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="mb-4">
            <label for="longitude" class="block text-gray-700 font-bold mb-2">Longitude</label>
            <input type="text" id="longitude" name="longitude" value="<?php echo htmlspecialchars($sentral['longitude']); ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="mb-4">
            <label for="nama" class="block text-gray-700 font-bold mb-2">Nama sentral</label>
            <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($sentral['nama']); ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="mb-4">
            <label for="deskripsi" class="block text-gray-700 font-bold mb-2">Deskripsi</label>
            <input type="text" id="deskripsi" name="deskripsi" value="<?php echo htmlspecialchars($sentral['deskripsi']); ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="mb-4">
            <label for="images" class="block text-gray-700 font-bold mb-2">Gambar</label>
            <input type="file" id="images" name="images" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">

            <?php if ($sentral['images']): ?>
                <div class="mt-4">
                    <p class="text-gray-600 text-sm mb-2">Biarkan kosong jika tidak ingin mengubah gambar.</p>
                    <img src="../uploads/<?php echo htmlspecialchars($sentral['images']); ?>" alt="Preview" class="w-[300px] h-auto rounded">
                </div>
            <?php endif; ?>

        </div>
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-indigo-600 text-white font-bold py-2 px-4 rounded hover:bg-indigo-500 focus:outline-none focus:shadow-outline">Update</button>
        </div>
    </form>

</div>