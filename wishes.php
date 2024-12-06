<?php
// Konfigurasi database
$host = "localhost";
$user = "root";
$password = ""; // Ubah jika Anda telah menetapkan password untuk root
$dbname = "my_database";

// Koneksi ke database
$conn = new mysqli($host, $user, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Handle request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Ambil semua data dari tabel wishes
    $sql = "SELECT name, comment FROM wishes ORDER BY created_at DESC";
    $result = $conn->query($sql);

    $wishes = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $wishes[] = $row;
        }
    }

    // Kirim data dalam format JSON
    header('Content-Type: application/json');
    echo json_encode($wishes);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Simpan data baru ke tabel wishes
    $name = $conn->real_escape_string($_POST['name']);
    $comment = $conn->real_escape_string($_POST['comment']);

    $sql = "INSERT INTO wishes (name, comment) VALUES ('$name', '$comment')";
    if ($conn->query($sql) === TRUE) {
        echo "Wish added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Tutup koneksi
$conn->close();
?>
