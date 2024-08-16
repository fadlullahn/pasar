<div class="px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="font-bold text-xl leading-6 text-gray-900">Data Pasar</h1>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <a href="?page=pasar&action=tambah" class="block rounded-md bg-indigo-600 px-3 py-2 text-center font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Tambah
            </a>
        </div>
    </div>
    <div class="mt-8 flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left font-semibold text-gray-900 sm:pl-6">No</th>
                                <th scope="col" class="px-3 py-3.5 text-left font-semibold text-gray-900">Nama Sentral</th>
                                <th scope="col" class="px-3 py-3.5 text-left font-semibold text-gray-900">Nama Pasar</th>
                                <th scope="col" class="px-3 py-3.5 text-left font-semibold text-gray-900">Deskripsi</th>
                                <th scope="col" class="px-3 py-3.5 text-left font-semibold text-gray-900">Latitude</th>
                                <th scope="col" class="px-3 py-3.5 text-left font-semibold text-gray-900">Longitude</th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6"></th>
                            </tr>
                        </thead>
                        <tbody id="data-container" class="divide-y divide-gray-200 bg-white">
                            <?php
                            $sql = "SELECT * FROM pasar";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                $i = 1;
                                while ($row = $result->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '<td class="whitespace-nowrap py-4 pl-4 pr-3 font-medium text-gray-900 sm:pl-6">' . $i++ . '</td>';
                                    echo '<td class="whitespace-nowrap px-3 py-4 text-gray-900">' . $row['nsentral'] . '</td>';
                                    echo '<td class="whitespace-nowrap px-3 py-4 text-gray-900">' . $row['nama'] . '</td>';
                                    echo '<td class="whitespace-nowrap px-3 py-4 text-gray-900">' . truncate_description($row['deskripsi']) . '</td>';
                                    echo '<td class="whitespace-nowrap px-3 py-4 text-gray-900">' . $row['latitude'] . '</td>';
                                    echo '<td class="whitespace-nowrap px-3 py-4 text-gray-900">' . $row['longitude'] . '</td>';
                                    echo '<td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right font-medium sm:pr-6">';
                                    echo '<a href="?page=pasar&action=update&idl=' . $row['idl'] . '" class="text-indigo-600 hover:text-indigo-900">Edit</a>';
                                    echo ' | ';
                                    echo '<a onclick="return confirm(\'Yakin ingin menghapus data ini?\')" href="?page=pasar&action=hapus&idl=' . $row['idl'] . '" class="text-indigo-600 hover:text-indigo-900">Hapus</a>';
                                    echo '</td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td colspan="6" class="text-center py-4 text-gray-500">Tidak ada data yang ditemukan</td></tr>';
                            }

                            $conn->close();
                            ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
function truncate_description($text, $char_limit = 20)
{
    if (strlen($text) > $char_limit) {
        return substr($text, 0, $char_limit) . '...';
    }
    return $text;
}
?>