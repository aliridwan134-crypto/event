<?php

// Mengatur batas waktu eksekusi menjadi tidak terbatas (unlimited)
// Berguna untuk file besar agar proses tidak berhenti di tengah jalan
@set_time_limit(0);
@ignore_user_abort(true);

// =================================================================
// KONFIGURASI
// =================================================================

// URL dari file zip yang akan diunduh
$zipUrl = 'https://github.com/kalcaddle/KodExplorer/archive/refs/heads/master.zip';

// Nama file zip sementara saat disimpan di server
$zipFile = 'downloaded_master.zip';

// Path atau folder tujuan untuk mengekstrak file
// './' berarti akan diekstrak di folder yang sama dengan file PHP ini
$extractPath = './';

// =================================================================
// PROSES EKSEKUSI
// =================================================================

// Langkah 0: Periksa apakah ekstensi PHP Zip sudah terinstall
if (!class_exists('ZipArchive')) {
    die('Error: Ekstensi "ZipArchive" tidak ditemukan. Harap aktifkan di konfigurasi PHP Anda.');
}

// Langkah 1: Mengunduh file zip dari URL
echo "Mencoba mengunduh file dari: $zipUrl ...<br>";
$downloaded = @copy($zipUrl, $zipFile);

if (!$downloaded || !file_exists($zipFile)) {
    die('Error: Gagal mengunduh file. Pastikan URL benar dan server memiliki izin untuk menulis file.');
}

echo "<b>Sukses:</b> File berhasil diunduh sebagai '$zipFile'.<br>";
echo "Memulai proses ekstraksi...<br>";

// Langkah 2: Mengekstrak file zip
$zip = new ZipArchive;
$res = $zip->open($zipFile);

if ($res === TRUE) {
    // Mengekstrak file ke folder tujuan
    $zip->extractTo($extractPath);
    $zip->close();
    
    echo "<b>Sukses:</b> File zip berhasil diekstrak ke '$extractPath'.<br>";
    
    // Langkah 3: Menghapus file zip sementara setelah selesai
    echo "Menghapus file zip sementara...<br>";
    @unlink($zipFile);
    
    echo "<b>Selesai!</b> File zip sementara ('$zipFile') telah dihapus.<br>";
    
} else {
    die("Error: Gagal membuka atau membaca file zip yang telah diunduh.");
}

?>
