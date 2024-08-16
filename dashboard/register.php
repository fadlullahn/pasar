<?php
include '../config/koneksi.php';

if (isset($_POST['submit'])) {
    // Ambil data dari form
    $username = $_POST['username'];
    $pass = $_POST['pass'];
    $confirm_pass = $_POST['confirm_pass'];

    // Validasi
    if (empty($username) || empty($pass) || empty($confirm_pass)) {
        header("Location: register.php?msg=empty");
        exit();
    }

    if ($pass !== $confirm_pass) {
        header("Location: register.php?msg=mismatch");
        exit();
    }

    // Hash password menggunakan MD5
    $hashed_pass = md5($pass);

    // Siapkan query SQL untuk mengecek apakah username sudah ada
    $query_check = "SELECT * FROM users WHERE username = ?";
    $stmt_check = $conn->prepare($query_check);
    $stmt_check->bind_param("s", $username);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // Username sudah ada
        header("Location: register.php?msg=user_exists");
        exit();
    }

    // Query SQL untuk insert data
    $query_insert = "INSERT INTO users (username, pass, level) VALUES (?, ?, 'User')";
    $stmt_insert = $conn->prepare($query_insert);
    $stmt_insert->bind_param("ss", $username, $hashed_pass);

    if ($stmt_insert->execute()) {
        // Registrasi berhasil
        header("Location: register.php?msg=success");
        exit();
    } else {
        // Terjadi kesalahan
        header("Location: register.php?msg=error");
        exit();
    }
}

// Tutup koneksi
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>REGISTER</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="flex min-h-full flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="mt-6 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Buat Akun</h2>

            <!-- Validasi Register -->
            <?php
            if (isset($_GET['msg'])) {
                $msg = $_GET['msg'];
                switch ($msg) {
                    case 'empty':
                        echo '<div class="alert alert-danger bg-red-200 text-red-700 p-4 mb-4 rounded-md">
                                <strong>Semua field harus diisi!</strong>
                              </div>';
                        break;
                    case 'mismatch':
                        echo '<div class="alert alert-danger bg-red-200 text-red-700 p-4 mb-4 rounded-md">
                                <strong>Password dan Konfirmasi Password tidak cocok!</strong>
                              </div>';
                        break;
                    case 'user_exists':
                        echo '<div class="alert alert-danger bg-red-200 text-red-700 p-4 mb-4 rounded-md">
                                <strong>Username sudah digunakan!</strong>
                              </div>';
                        break;
                    case 'success':
                        echo '<div class="alert alert-success bg-green-200 text-green-700 p-4 mb-4 rounded-md">
                                <strong>Buat Akun berhasil!</strong>
                              </div>';
                        break;
                    case 'error':
                        echo '<div class="alert alert-danger bg-red-200 text-red-700 p-4 mb-4 rounded-md">
                                <strong>Terjadi kesalahan saat buat akun. Silakan coba lagi!</strong>
                              </div>';
                        break;
                }
            }
            ?>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-[480px]">
            <div class="bg-white px-6 py-12 shadow sm:rounded-lg sm:px-12">
                <form class="space-y-6" method="POST">
                    <div>
                        <label for="username" class="block text-sm font-medium leading-6 text-gray-900">Username</label>
                        <div class="mt-2">
                            <input name="username" type="text" autocomplete="off" required class="p-1 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div>
                        <label for="pass" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                        <div class="mt-2">
                            <input name="pass" type="password" autocomplete="off" required class="p-1 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div>
                        <label for="confirm_pass" class="block text-sm font-medium leading-6 text-gray-900">Confirm Password</label>
                        <div class="mt-2">
                            <input name="confirm_pass" type="password" autocomplete="off" required class="p-1 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div>
                        <input type="submit" name="submit" value="Register" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    </div>
                </form>
                <div>
                    <div class="mt-2">
                        <a href="../index.php" class="flex w-full items-center justify-center rounded-md bg-red-200 px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus-visible:ring-transparent">
                            <span class="text-sm font-semibold leading-6">Home</span>
                        </a>
                    </div>
                </div>
                <p class="mt-10 text-center text-sm text-gray-400">
                    Sudah Punya Akun?
                    <a href="login.php" class="font-semibold leading-6 text-indigo-400 hover:text-indigo-300">Login Disini</a>
                </p>
            </div>
        </div>
    </div>
</body>

</html>