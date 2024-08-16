<?php

$id = $_GET['id'];

$sql = "DELETE FROM users WHERE id='$id'";
if ($conn->query($sql) === TRUE) {
    echo 'Hapus Data Berhasil';
}
$conn->close();
