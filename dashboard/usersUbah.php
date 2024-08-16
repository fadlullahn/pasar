<?php
// Memanggil Data Yang Mau Di Edit
$id = $_GET['id'];

if (isset($_POST['update'])) {

    // Ambil Data Dari Input Yang Mau Di Update
    $level = $_POST['level'];


    // Proses Update Data Users
    $sql = "UPDATE users SET level='$level' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo 'Updated';
    }
}

$sql = "SELECT * FROM users WHERE id='$id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>


<form action="" method="POST">
    <div class="space-y-12 sm:space-y-16">
        <div class="items-center justify-center grid grid-cols-3">
            <h2 class="font-bold leading-7 text-gray-900 text-center">Edit Users</h2>
            <div class="mt-10 space-y-8 border-b border-gray-900/10 pb-12 sm:space-y-0 sm:divide-y sm:divide-gray-900/10 sm:border-t sm:pb-0">
                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:py-6">
                    <label class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5" for="">Username</label>
                    <div class="mt-2 sm:col-span-2 sm:mt-0">
                        <input type="text" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" value="<?php echo $row["username"] ?>" readonly>

                    </div>
                </div>
                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:py-6">
                    <label class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5" for="">Password</label>
                    <div class="mt-2 sm:col-span-2 sm:mt-0">
                        <input type="text" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" readonly>
                    </div>
                </div>
                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:py-6">
                    <label class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5" for="">Level</label>
                    <select class="form-control chosen" data-placeholder="Pilih Level" name="level">
                        <option value="<?php echo $row["level"] ?>"><?php echo $row["level"] ?></option>
                        <option value="User">User</option>
                        <option value="Admin">Admin</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-6 flex items-center justify-center gap-x-6">
        <a class="text-sm font-semibold leading-6 text-gray-900" href="?page=users">Batal</a>
        <input class="inline-flex justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" type="submit" name="update" value="Update">
    </div>
</form>