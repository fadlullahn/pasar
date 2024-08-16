<?php

if (isset($_POST['simpan'])) {
    $username = $_POST['username'];
    $pass = md5($_POST['pass']);
    $level = $_POST['level'];

    // Validasi Data Users
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
?>
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Data Tidak Tersimpan Karena Username Sudah Digunakan</strong>
        </div>
<?php
    } else {
        // Proses Simpan Setelah Di Validasi
        $sql = "INSERT INTO users VALUES (Null,'$username','$pass','$level')";
        if ($conn->query($sql) === TRUE) {
            echo 'Tambah Data Berhasil';
        }
    }
}
?>
<form action="" method="POST">
    <div class="space-y-12 sm:space-y-16">
        <div class="items-center justify-center grid grid-cols-3">
            <h2 class="font-bold leading-7 text-gray-900 text-center">Tambah Users</h2>
            <div class="mt-10 space-y-8 border-b border-gray-900/10 pb-12 sm:space-y-0 sm:divide-y sm:divide-gray-900/10 sm:border-t sm:pb-0">
                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:py-6">
                    <label for="Username" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Username</label>
                    <div class="mt-2 sm:col-span-2 sm:mt-0">
                        <input type="text" name="username" maxlength="20" required class="p-1 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:py-6">
                    <label for="Password" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Password</label>
                    <div class="mt-2 sm:col-span-2 sm:mt-0">
                        <input type="password" name="pass" maxlength="20" required class="p-1 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:py-6">
                    <label for="Level" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Level</label>
                    <div class="mt-2 sm:col-span-2 sm:mt-0">
                        <select name="level" data-placeholder="Pilih Level" class="chosen block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                            <option value=""></option>
                            <option value="User">User</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 flex items-center justify-center gap-x-6">
        <a href="?page=users" class="text-sm font-semibold leading-6 text-gray-900">Batal</a>
        <input type="submit" name="simpan" value="Simpan" class="inline-flex justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
    </div>
</form>