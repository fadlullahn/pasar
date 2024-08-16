<?php
$sql = "SELECT COUNT(*) as jumlah FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_users = $row['jumlah'];
} else {
    $total_users = 0;
}

$sql = "SELECT COUNT(*) as jumlah FROM pasar";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_pasar = $row['jumlah'];
} else {
    $total_pasar = 0;
}

$sql = "SELECT COUNT(*) as jumlah FROM sentral";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_sentral = $row['jumlah'];
} else {
    $total_sentral = 0;
}
$conn->close();
?>

<div class="space-y-16 py-8 xl:space-y-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-none">
            <div class="flex items-center justify-between">
                <h2 class="text-base font-semibold leading-7 text-gray-900">Dashboard</h2>
            </div>
            <ul role="list" class="mt-6 grid gap-x-6 gap-y-8 justify-center items-center text-center lg:grid-cols-3 xl:gap-x-8">
                <li class="overflow-hidden rounded-xl border border-gray-200">
                    <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 p-6">
                        <div class="text-sm font-medium leading-6 text-gray-900">Sentral</div>
                    </div>
                    <dl class="-my-3 divide-y divide-gray-100 px-6 py-4 text-sm leading-6">
                        <div class="flex justify-between gap-x-4 py-3">
                            <dt class="text-gray-500">Total</dt>
                            <dd class="flex items-start gap-x-2">
                                <div class="font-medium text-gray-900"><?php echo $total_sentral; ?></div>
                            </dd>
                        </div>
                    </dl>
                </li>
                <li class="overflow-hidden rounded-xl border border-gray-200">
                    <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 p-6">
                        <div class="text-sm font-medium leading-6 text-gray-900">Pasar</div>
                    </div>
                    <dl class="-my-3 divide-y divide-gray-100 px-6 py-4 text-sm leading-6">
                        <div class="flex justify-between gap-x-4 py-3">
                            <dt class="text-gray-500">Total</dt>
                            <dd class="flex items-start gap-x-2">
                                <div class="font-medium text-gray-900"><?php echo $total_pasar; ?></div>
                            </dd>
                        </div>
                    </dl>
                </li>
                <li class="overflow-hidden rounded-xl border border-gray-200">
                    <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 p-6">
                        <div class="text-sm font-medium leading-6 text-gray-900">Users</div>
                    </div>
                    <dl class="-my-3 divide-y divide-gray-100 px-6 py-4 text-sm leading-6">
                        <div class="flex justify-between gap-x-4 py-3">
                            <dt class="text-gray-500">Total</dt>
                            <dd class="flex items-start gap-x-2">
                                <div class="font-medium text-gray-900"><?php echo $total_users; ?></div>
                            </dd>
                        </div>
                    </dl>
                </li>
            </ul>
        </div>
    </div>
</div>