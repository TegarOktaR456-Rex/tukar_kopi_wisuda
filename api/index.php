<?php

// Arahkan penyimpanan compiled view ke folder /tmp bawaan Vercel
$_ENV['VIEW_COMPILED_PATH'] = '/tmp/storage/framework/views';

// Buat foldernya jika belum ada
if (!is_dir($_ENV['VIEW_COMPILED_PATH'])) {
    mkdir($_ENV['VIEW_COMPILED_PATH'], 0777, true);
}

// Teruskan ke file bootstrap Laravel
require __DIR__ . '/../public/index.php';