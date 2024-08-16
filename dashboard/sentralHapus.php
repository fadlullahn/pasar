<?php
$idl = $_GET['idl'];

$sql = "SELECT images FROM sentral WHERE idl='$idl'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $imagesName = $row['images'];

  // Hapus data dari database
  $deleteSql = "DELETE FROM sentral WHERE idl='$idl'";
  if ($conn->query($deleteSql) === TRUE) {
    // Jika data berhasil dihapus, hapus file gambar
    if ($imagesName) {
      $imagesPath = '../uploads/' . $imagesName;
      if (file_exists($imagesPath)) {
        unlink($imagesPath); // Menghapus file gambar
      }
    }

    echo "<script>
            alert('Sentral berhasil dihapus.');
            window.location.href = 'index.php?page=sentral';
        </script>";
  } else {
    echo "Error: " . $conn->error;
  }
} else {
  echo "Tidak ada data dengan ID tersebut.";
}

$conn->close();
