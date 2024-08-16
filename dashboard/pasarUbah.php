<?php
include '../config/koneksi.php';

// Jika ID pasar ada di URL, ambil datanya
if (isset($_GET['idl'])) {
    $idl = $conn->real_escape_string($_GET['idl']);

    $result = $conn->query("SELECT * FROM pasar WHERE idl = '$idl'");
    $pasar = $result->fetch_assoc();

    if (!$pasar) {
        die("Pasar tidak ditemukan.");
    }
} else {
    die("ID Pasar tidak ditemukan.");
}

// Ambil data sentral untuk dropdown
$sentralResult = $conn->query("SELECT nama FROM sentral");
$sentralOptions = [];
while ($row = $sentralResult->fetch_assoc()) {
    $sentralOptions[] = $row['nama'];
}

// Proses form jika metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idl = $conn->real_escape_string($_POST['idl']);
    $latitude = $conn->real_escape_string($_POST['latitude']);
    $longitude = $conn->real_escape_string($_POST['longitude']);
    $nsentral = $conn->real_escape_string($_POST['nsentral']);
    $nama = $conn->real_escape_string($_POST['nama']);
    $deskripsi = $conn->real_escape_string($_POST['deskripsi']);

    $sql = "UPDATE pasar SET latitude='$latitude', longitude='$longitude', nsentral='$nsentral', nama='$nama', deskripsi='$deskripsi' WHERE idl='$idl'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
        alert('Pasar berhasil diperbarui.');
        window.location.href = 'index.php?page=pasar';
      </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-4">Edit Pasar</h1>
    <form action="" method="post" class="bg-white p-6 rounded shadow-md">
        <input type="hidden" name="idl" value="<?php echo htmlspecialchars($pasar['idl']); ?>">
        <div class="mb-4">
            <label for="latitude" class="block text-gray-700 font-bold mb-2">Latitude:</label>
            <input type="text" id="latitude" name="latitude" value="<?php echo htmlspecialchars($pasar['latitude']); ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="mb-4">
            <label for="longitude" class="block text-gray-700 font-bold mb-2">Longitude</label>
            <input type="text" id="longitude" name="longitude" value="<?php echo htmlspecialchars($pasar['longitude']); ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="mb-4">
            <label for="nsentral" class="block text-gray-700 font-bold mb-2">Sentral</label>
            <select id="nsentral" name="nsentral" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <option value="">Pilih Sentral</option>
                <?php foreach ($sentralOptions as $sentralName): ?>
                    <option value="<?php echo htmlspecialchars($sentralName); ?>" <?php echo $pasar['nsentral'] == $sentralName ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($sentralName); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-4">
            <label for="nama" class="block text-gray-700 font-bold mb-2">Nama Pasar</label>
            <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($pasar['nama']); ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="mb-4">
            <label for="deskripsi" class="block text-gray-700 font-bold mb-2">Deskripsi</label>
            <input type="text" id="deskripsi" name="deskripsi" value="<?php echo htmlspecialchars($pasar['deskripsi']); ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-indigo-600 text-white font-bold py-2 px-4 rounded hover:bg-indigo-500 focus:outline-none focus:shadow-outline">Update</button>
        </div>
    </form>
</div>