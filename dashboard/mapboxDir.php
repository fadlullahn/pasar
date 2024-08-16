<?php
include './pasarFunc.php';

include '../config/koneksi.php';

// Ambil daftar sentral dari database
$result = $conn->query("SELECT DISTINCT nama FROM sentral");
$sentralList = [];
while ($row = $result->fetch_assoc()) {
    $sentralList[] = $row['nama'];
}

// Proses form jika metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nsentral = $conn->real_escape_string($_POST['nsentral']);

    // Ambil data pasar berdasarkan nsentral
    $pasarResult = $conn->query("SELECT * FROM pasar WHERE nsentral = '$nsentral'");
    $pasarList = [];
    while ($row = $pasarResult->fetch_assoc()) {
        $pasarList[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Display Navigation Directions</title>
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">

    <link href="https://api.mapbox.com/mapbox-gl-js/v3.6.0/mapbox-gl.css" rel="stylesheet">
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.3.1/mapbox-gl-directions.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <script src="https://api.mapbox.com/mapbox-gl-js/v3.6.0/mapbox-gl.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.3.1/mapbox-gl-directions.js"></script>
    <script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v2.3.0/mapbox-gl-geocoder.min.js'></script>
    <style>
        .mapboxgl-popup-content {
            background-color: #f8f9fa;
            color: #333;
            font-size: 12px;
            border-radius: 10px;
            border: 2px solid #ccc;
            text-align: center;
        }

        .mapboxgl-popup-close-button {
            display: none;
        }
    </style>
</head>

<body>

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Pencarian Pasar</h1>
        <!-- Daftar Sentral -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-2">Silahkan Pilih Sentral</h2>
            <ul class="space-y-4">
                <?php foreach ($sentralList as $sentral): ?>
                    <?php
                    // Ambil detail sentral dari database jika diperlukan
                    $sentralName = $conn->real_escape_string($sentral);
                    $query = "SELECT nama, latitude, longitude, deskripsi, images FROM sentral WHERE nama = '$sentralName'";
                    $result = $conn->query($query);
                    $sentralDetail = $result->fetch_assoc();
                    ?>
                    <li class="flex items-center justify-between p-4 border border-gray-200 rounded">
                        <!-- Nama Sentral -->
                        <p class="text-lg font-semibold"><?php echo htmlspecialchars($sentralDetail['nama']); ?></p>

                        <!-- Tombol-Tombol -->
                        <div class="flex space-x-2">
                            <!-- Tombol Daftar Pasar -->
                            <form method="POST" class="inline">
                                <input type="hidden" name="nsentral" value="<?php echo htmlspecialchars($sentral); ?>">
                                <button type="submit" class="bg-indigo-600 text-white font-bold py-2 px-4 rounded hover:bg-indigo-500">
                                    Pilih
                                </button>
                            </form>
                            <!-- Tombol Info -->
                            <button onclick='showModalSen(<?php echo json_encode($sentralDetail, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_HEX_APOS); ?>)' class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-400">
                                Info
                            </button>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>



        <!-- Daftar Pasar -->
        <div>
            <?php if (isset($pasarList)): ?>
                <?php if (empty($pasarList)): ?>
                    <p class="text-gray-600">Tidak Ada Pasar Yang Ditemukan Untuk Sentral "<?php echo htmlspecialchars($_POST['nsentral']); ?>"</p>
                <?php else: ?>
                    <h2 class="text-xl font-semibold mb-2">Daftar Pasar Untuk Sentral "<?php echo htmlspecialchars($_POST['nsentral']); ?>"</h2>
                    <ul>
                        <?php foreach ($pasarList as $pasar): ?>
                            <li class="mb-4 p-4 border border-gray-200 rounded flex items-center justify-between space-x-4">
                                <!-- Nama Pasar -->
                                <span class="text-lg font-semibold flex-grow"><?php echo htmlspecialchars($pasar['nama']); ?></span>
                                <!-- Tombol Info -->
                                <button onclick='showModal(<?php echo json_encode($pasar); ?>)' class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-400">
                                    Info
                                </button>
                                <!-- Tombol Lokasi -->
                                <button
                                    onclick="startNavigation(<?php echo htmlspecialchars(json_encode([$pasar['longitude'], $pasar['latitude']])); ?>)"
                                    class="bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-400">
                                    Lokasi
                                </button>

                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            <?php else: ?>
                <p class="text-gray-600">Pilih Sentral Untuk Melihat Data Pasar</p>
            <?php endif; ?>
        </div>

    </div>

    <!-- Modal -->
    <div id="modal" class="fixed inset-0 z-50 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded shadow-lg w-1/3">
            <h3 class="text-lg font-bold mb-2" id="modal-name">Nama Pasar</h3>
            <p><strong>Latitude:</strong> <span id="modal-latitude"></span></p>
            <p><strong>Longitude:</strong> <span id="modal-longitude"></span></p>
            <p><strong>Deskripsi:</strong> <span id="modal-deskripsi"></span></p>
            <button onclick="closeModal()" class="mt-4 bg-red-500 text-white font-bold py-2 px-4 rounded hover:bg-red-400">Tutup</button>
        </div>
    </div>

    <!-- Modal Sen -->
    <div id="modalSen" class="fixed inset-0 z-50 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded shadow-lg w-1/3">
            <h3 class="text-lg font-bold mb-2" id="modalSen-name">Sentral</h3>
            <img id="modalSen-image" class="h-[150px] w-[150px] mb-2" src="" alt="Gambar Sentral">
            <p><strong>Latitude:</strong> <span id="modalSen-latitude"></span></p>
            <p><strong>Longitude:</strong> <span id="modalSen-longitude"></span></p>
            <p><strong>Deskripsi:</strong> <span id="modalSen-deskripsi"></span></p>
            <button onclick="closeModalSen()" class="mt-4 bg-red-500 text-white font-bold py-2 px-4 rounded hover:bg-red-400">Tutup</button>
        </div>
    </div>


    <script>
        function showModalSen(sentral) {
            document.getElementById('modalSen-name').innerText = sentral.nama;
            document.getElementById('modalSen-latitude').innerText = sentral.latitude;
            document.getElementById('modalSen-longitude').innerText = sentral.longitude;
            document.getElementById('modalSen-deskripsi').innerText = sentral.deskripsi;
            document.getElementById('modalSen-image').src = '../uploads/' + sentral.images; // Atur src gambar
            document.getElementById('modalSen').classList.remove('hidden');
        }


        function closeModalSen() {
            document.getElementById('modalSen').classList.add('hidden');
        }

        function getSentralData(id) {
            const sentralList = <?php echo json_encode($sentralList); ?>;
            const sentral = sentralList.find(sentral => sentral.idl == id);
            return sentral;
        }

        function showModal(pasar) {
            document.getElementById('modal-name').innerText = pasar.nama;
            document.getElementById('modal-latitude').innerText = pasar.latitude;
            document.getElementById('modal-longitude').innerText = pasar.longitude;
            // Log deskripsi untuk memastikan nilainya benar
            console.log("Original Deskripsi:", pasar.deskripsi);

            // Mengganti <br> dengan <br> agar HTML mengenali sebagai baris baru
            const deskripsiWithLineBreaks = pasar.deskripsi.replace(/<br>/gi, '<br>');

            console.log("Processed Deskripsi:", deskripsiWithLineBreaks); // Log setelah diubah
            document.getElementById('modal-deskripsi').innerHTML = deskripsiWithLineBreaks;

            document.getElementById('modal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }

        function getPasarData(id) {
            const pasarList = <?php echo json_encode($pasarList); ?>;
            const pasar = pasarList.find(pasar => pasar.idl == id);
            return pasar;
        }
    </script>


    <div id="map" class="w-4/5 h-[700px] mx-auto mt-5 border-2 border-gray-300 rounded-lg"></div>
    <!-- Modal -->
    <div id="infoModal" class="modal fixed inset-0 z-50 hidden overflow-auto bg-gray-900 bg-opacity-50 pt-16">
        <div class="modal-content bg-white mx-auto p-6 border border-gray-400 rounded-lg w-1/3">
            <span class="close text-gray-400 text-2xl font-bold float-right cursor-pointer hover:text-black">&times;</span>
            <h2 class="text-xl font-semibold mb-4">Informasi Pasar</h2>
            <div id="modal-content-placeholder">
                <!-- Informasi tambahan akan dimuat di sini -->
            </div>
        </div>
    </div>


    <script>
        var markers = <?= get_pasar() ?>;
        var pasar_parepare = [119.6290, -4.0099];

        mapboxgl.accessToken = 'pk.eyJ1IjoiZmFkbHVsbGFoeCIsImEiOiJjbHI0bmZrejcxYmx0MmpudjVkMzRjbm43In0.O_h7GYI9fXaoHr9XnIN5sg';

        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v12',
            center: pasar_parepare,
            zoom: 15
        });

        // Menambahkan kontrol navigasi peta
        map.addControl(new mapboxgl.NavigationControl());

        // Menambahkan plugin Directions
        var directions = new MapboxDirections({
            accessToken: mapboxgl.accessToken,
            unit: 'metric',
            profile: 'mapbox/driving',
            interactive: false,
            alternatives: true, // Menampilkan rute alternatif
            voiceInstructions: true, // Mengaktifkan petunjuk suara
            zoom: true, // Otomatis melakukan zoom
            bannerInstructions: false, // Menampilkan instruksi spanduk
            language: 'id', // Mengatur bahasa Indonesia
            controls: {
                inputs: true, // Menampilkan input asal dan tujuan
                instructions: true, // Menampilkan instruksi rute
            },
        });

        map.addControl(directions, 'top-left');

        // Mengatur lokasi awal peta dan Directions menjadi lokasi saat ini
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var currentLocation = [position.coords.longitude, position.coords.latitude];

                // Update pusat peta ke lokasi saat ini
                map.setCenter(currentLocation);

                // Update lokasi default untuk Directions
                pasar_parepare = currentLocation;

                // Atur lokasi saat ini sebagai titik awal untuk Directions
                directions.setOrigin(currentLocation);

                // Tambahkan marker untuk lokasi saat ini (opsional)
                new mapboxgl.Marker({
                        color: "#1d1d86"
                    })
                    .setLngLat(currentLocation)
                    .setPopup(new mapboxgl.Popup().setHTML("<strong>Lokasi Anda</strong>"))
                    .addTo(map);

                addMarkers(markers);
            }, function(error) {
                console.error("Geolocation error: ", error);
                // Jika gagal mendapatkan lokasi, tetap gunakan lokasi default
                directions.setOrigin(pasar_parepare);
                addMarkers(markers);
            });
        } else {
            console.error("Geolocation is not supported by this browser.");
            // Jika geolocation tidak didukung, tetap gunakan lokasi default
            directions.setOrigin(pasar_parepare);
            addMarkers(markers);
        }

        function addMarkers(coordinates) {
            coordinates.forEach(function(data) {
                var marker = new mapboxgl.Marker()
                    .setLngLat([data.longitude, data.latitude])
                    .addTo(map);

                var popupContent = `
                <div>
                    <strong>${data.nama}</strong><br>
            

                </div>
              
            `;
                // <button onclick="showInfo(${data.idl})" style="background-color: #007bff; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer;">Info</button>
                //     <button onclick="startNavigation([${data.longitude}, ${data.latitude}])" style="background-color: #28a745; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; margin-top: 5px;">Start</button>

                var popup = new mapboxgl.Popup({
                        offset: 20
                    })
                    .setHTML(popupContent);

                marker.setPopup(popup).togglePopup();
            });
        }

        function showInfo(idl) {
            // Memunculkan modal
            var modal = document.getElementById("infoModal");
            modal.style.display = "block";

            // Mengambil data informasi pasar dari server
            $.ajax({
                url: './pasarFunc.php',
                method: 'GET',
                data: {
                    idl: idl,
                    action: 'get_pasar_by_idl'
                },
                success: function(response) {
                    document.getElementById("modal-content-placeholder").innerHTML = response;
                },
                error: function() {
                    document.getElementById("modal-content-placeholder").innerHTML = 'Gagal mengambil data.';
                }
            });
        }

        function startNavigation(destination) {
            // Mengatur titik akhir untuk navigasi
            directions.setDestination(destination);

            // Scroll ke elemen dengan ID "map" dengan offset
            const mapElement = document.getElementById('map');
            const offset = -80; // Atur offset sesuai kebutuhan (positif untuk menggulir lebih jauh, negatif untuk lebih dekat)

            // Hitung posisi target dengan offset
            const targetPosition = mapElement.getBoundingClientRect().top + window.pageYOffset + offset;

            window.scrollTo({
                top: targetPosition,
                behavior: 'smooth'
            });
        }

        // Menutup modal ketika tombol close diklik
        var span = document.getElementsByClassName("close")[0];
        span.onclick = function() {
            var modal = document.getElementById("infoModal");
            modal.style.display = "none";
        }

        // Menutup modal ketika area di luar modal diklik
        window.onclick = function(event) {
            var modal = document.getElementById("infoModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>


</body>

</html>