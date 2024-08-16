<?php
include './sentralFunc.php';

$action = isset($_GET['action']) ? $_GET['action'] : "";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        #map {
            height: 550px;
        }

        .geocoder {
            margin-bottom: 0px;
        }

        .mapboxgl-popup-content {
            background-color: #f8f9fa;
            /* Background popup */
            color: #333;
            /* Warna teks */
            font-size: 10px;
            /* Ukuran font */
            border-radius: 100%;
            /* Membulatkan sudut popup secara penuh */
            border: 2px solid #ccc;
            /* Border popup */
            text-align: center;
            /* Memusatkan teks */
        }

        .mapboxgl-popup-close-button {
            display: none;
        }
    </style>
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.48.0/mapbox-gl.css' rel='stylesheet'>
    <link href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v2.3.0/mapbox-gl-geocoder.css' rel='stylesheet'>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="container">
        <div class="row">
            <?php
            if ($action == 'tambah') {
            ?>
                <div class="col-md-6">
                    <form id="signupForm" class="card-form" enctype="multipart/form-data">
                        <div class="bg-white shadow-md rounded-lg">
                            <div class="bg-gray-800 text-white text-center py-2 rounded-t-lg">
                                <strong>Input Data Sentral</strong>
                            </div>
                            <div class="p-4">
                                <div>
                                    <label for="latitude" class="block text-sm font-medium leading-6 text-gray-900">Latitude</label>
                                    <div class="mt-2">
                                        <input type="text" id="latitude" name="latitude" autocomplete="off" required class="p-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                            placeholder="-4.0099">
                                    </div>
                                </div>
                                <div class="mt-1">
                                    <label for="longitude" class="block text-sm font-medium leading-6 text-gray-900">Longitude</label>
                                    <div class="mt-2">
                                        <input type="text" id="longitude" name="longitude" autocomplete="off" required class="p-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                            placeholder="119.6290">
                                    </div>
                                </div>
                                <div class="mt-1">
                                    <label for="nama" class="block text-sm font-medium leading-6 text-gray-900">Nama Sentral</label>
                                    <div class="mt-2">
                                        <input type="text" id="nama" name="nama" autocomplete="off" required class="p-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                            placeholder="Nama sentral">
                                    </div>
                                </div>
                                <div class="mt-1">
                                    <label for="deskripsi" class="block text-sm font-medium leading-6 text-gray-900">Deskripsi</label>
                                    <div class="mt-2">
                                        <input type="text" id="deskripsi" name="deskripsi" autocomplete="off" required class="p-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                            placeholder="Deskripsi">
                                    </div>
                                </div>
                                <input type="file" name="images" accept="images/*">
                                <input class="mt-5 bg-gray-800 text-white py-2 px-4 rounded-md hover:bg-gray-700 transition duration-300 ease-in-out cursor-pointer" type="submit" value="Simpan">
                            </div>
                        </div>
                    </form>

                </div>
            <?php
            }
            ?>

            <div class="flex justify-center items-center min-h-screen bg-gray-100 mt-10">
                <div class="w-full p-8">
                    <?php
                    if ($action == 'tambah') {
                    ?>
                        <div id="geocoder" class="geocoder bg-white p-4 shadow-md rounded-lg"></div>
                        <div id="map" class="w-full bg-gray-200 rounded-lg shadow-md mt-5"></div>
                    <?php
                    }
                    ?>
                    <?php
                    if ($action == '') {
                    ?>
                        <div id="map" style="height: 750px;" class="w-full bg-gray-200 rounded-lg shadow-md"></div>
                    <?php
                    }
                    ?>
                </div>
            </div>

        </div>
    </div>

    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.48.0/mapbox-gl.js'></script>
    <script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v2.3.0/mapbox-gl-geocoder.min.js'></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <script>
        // Ambil data sentral dari PHP
        var markers = <?= get_sentral() ?>;
        var sentral_parepare = [119.6290, -4.0099];

        mapboxgl.accessToken = 'pk.eyJ1IjoiZmFkbHVsbGFoeCIsImEiOiJjbHI0bmZrejcxYmx0MmpudjVkMzRjbm43In0.O_h7GYI9fXaoHr9XnIN5sg';
        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v9',
            center: sentral_parepare,
            zoom: 12
        });

        var geocoder = new MapboxGeocoder({
            accessToken: mapboxgl.accessToken,
        });

        var marker;

        map.on('load', function() {
            addMarker(sentral_parepare, 'load');
            addMarkers(markers);

            geocoder.on('result', function(ev) {
                alert("FIND");
                console.log(ev.result.center);
            });
        });

        map.on('click', function(e) {
            if (marker) {
                marker.remove();
            }
            addMarker(e.lngLat, 'click');
            document.getElementById("latitude").value = e.lngLat.lat;
            document.getElementById("longitude").value = e.lngLat.lng;
        });

        function addMarker(ltlng, event) {
            if (event === 'click') {
                sentral_parepare = ltlng;
            }
            marker = new mapboxgl.Marker({
                    draggable: true,
                    color: "#d02922"
                })
                .setLngLat(sentral_parepare)
                .addTo(map)
                .on('dragend', onDragEnd);
        }

        function addMarkers(coordinates) {
            coordinates.forEach(function(data) {
                var marker = new mapboxgl.Marker()
                    .setLngLat([data.longitude, data.latitude])
                    .addTo(map);

                var popup = new mapboxgl.Popup({
                        offset: 20
                    })
                    .setText(data.nama);

                marker.setPopup(popup).togglePopup();
            });
        }

        function onDragEnd() {
            var lngLat = marker.getLngLat();
            document.getElementById("latitude").value = lngLat.lat;
            document.getElementById("longitude").value = lngLat.lng;
            console.log('longitude: ' + lngLat.lng + '<br />latitude: ' + lngLat.lat);
        }

        $('#signupForm').submit(function(event) {
            event.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: 'sentralFunc.php?tambah_sentral', // Pastikan parameter di URL sesuai
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(data) {
                    // Tangani response sukses
                    alert(data);
                    location.reload();
                },
                error: function(xhr, status, error) {
                    // Tangani error
                    console.error('An error occurred:', xhr.responseText);
                    console.error('Status:', status);
                    console.error('Error:', error);
                }
            });
        });

        document.getElementById('geocoder').appendChild(geocoder.onAdd(map));
    </script>


</body>

</html>