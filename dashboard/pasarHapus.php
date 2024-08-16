<?php

$idl = $_GET['idl'];

$sql = "DELETE FROM pasar WHERE idl='$idl'";
if ($conn->query($sql) === TRUE) {
  echo "<script>
    alert('Pasar berhasil dihapus.');
    window.location.href = 'index.php?page=pasar';
  </script>";
}
$conn->close();
