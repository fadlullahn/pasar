<?php
// Mengaktifkan Session
session_start();

// Menghapus Semua Session
session_destroy();

// Mengalihkan Halaman Sambil Mengirim Pesan Logout
header("Location:login.php");
