<?php
// Ma'lumotlarni olish
$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $latitude = $data['latitude'] ?? null;
    $longitude = $data['longitude'] ?? null;

    if ($latitude && $longitude) {
        // Bu yerda ma'lumotni saqlash yoki qayta ishlash mumkin
        echo "Kenglik: $latitude, Uzunlik: $longitude";
    } else {
        echo "Geolokatsiya ma'lumotlari noto'g'ri.";
    }
} else {
    echo "Hech qanday ma'lumot kelmadi.";
}
?>
