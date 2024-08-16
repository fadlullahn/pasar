<?php
include './config/koneksi.php'
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Pasar</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .hidden1 {
            display: none;
        }

        html,
        body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
        }
    </style>
</head>

<body>
    <?php
    require_once 'components/navbar.php';
    ?>

    <main class="flex flex-1 lg:px-[110px]">
        <div class="w-full">
            <?php
            $page = isset($_GET['page']) ? $_GET['page'] : "";

            if ($page == "") {
                include "header.php";
            } elseif ($page == "about") {
                include "about.php";
            }
            ?>
        </div>
    </main>

    <?php
    require_once 'components/footer.php';
    ?>

    <script src="./js/navbar.js"></script>
    <script src="./js//itemActive.js"></script>

</body>

</html>