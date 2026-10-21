<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Admin;
use App\Models\Pelayan;
use App\Models\Tamu; // Import Model Tamu
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Membuat Akun Admin (Rex)
        $adminUser = User::create([
            'name' => 'rex',
            'email' => 'rex@tukarkopi.com', // Email dummy wajib ada
            'password' => Hash::make('45654'), // Password wajib di-hash
            'role' => 'admin',
        ]);

        // Menyambungkan data user_id ke tabel admins
        Admin::create([
            'user_id' => $adminUser->id,
        ]);

        // 2. Membuat Akun Pelayan (Iqbal)
        $pelayanIqbal = User::create([
            'name' => 'iqbal',
            'email' => 'iqbal@tukarkopi.com', // Email dummy wajib ada
            'password' => Hash::make('iqbal123'), // Password wajib di-hash
            'role' => 'pelayan',
        ]);

        // Menyambungkan data user_id ke tabel pelayans
        Pelayan::create([
            'user_id' => $pelayanIqbal->id,
        ]);

        // 3. Membuat Akun Pelayan (Arya)
        $pelayanArya = User::create([
            'name' => 'arya',
            'email' => 'aryagemink@tukarkopi.com', // Email dummy wajib ada
            'password' => Hash::make('arya123'), // Password wajib di-hash
            'role' => 'pelayan',
        ]);

        // Menyambungkan data user_id ke tabel pelayans
        Pelayan::create([
            'user_id' => $pelayanArya->id,
        ]);

        // -------------------------------------------------------------
        // 4. INSERT DATA TAMUS (DARI FILE EXCEL)
        // -------------------------------------------------------------
        
        // Cek apakah library phpspreadsheet sudah diinstal
        if (!class_exists('\PhpOffice\PhpSpreadsheet\IOFactory')) {
            $this->command->error("Library PhpSpreadsheet belum diinstal!");
            $this->command->warn("Jalankan: composer require phpoffice/phpspreadsheet");
            return;
        }

        // --- A. PROSES FILE EXCEL PERTAMA ---
        $this->command->info('Memulai proses import data dari file pertama: Data_urut_penukaran_kopi.xlsx...');
        $excelFile1 = storage_path('app/Data_urut_penukaran_kopi.xlsx');

        if (!file_exists($excelFile1)) {
            $this->command->error("File Excel pertama tidak ditemukan!");
            $this->command->warn("Pastikan file 'Data_urut_penukaran_kopi.xlsx' ada di 'storage/app/'.");
        } else {
            try {
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($excelFile1);
                $sheet = $spreadsheet->getActiveSheet();
                $dataTamu1 = [];

                // Loop sesuai baris dari 2 sampai 107
                for ($row = 2; $row <= 107; $row++) {
                    $nim = $sheet->getCell('C' . $row)->getValue();
                    $nama = $sheet->getCell('D' . $row)->getValue();
                    $barcode = $sheet->getCell('I' . $row)->getValue();

                    if (!empty($barcode) && !empty($nim)) {
                        $dataTamu1[] = [
                            'nim'        => (string) $nim,
                            'nama'       => (string) $nama,
                            'barcode'    => (string) $barcode,
                            'is_scanned' => false,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }

                if (count($dataTamu1) > 0) {
                    Tamu::insert($dataTamu1);
                    $this->command->info(count($dataTamu1) . ' data Tamu berhasil diimport dari file pertama!');
                } else {
                    $this->command->warn('Tidak ada data valid yang terbaca dari file Excel pertama.');
                }
            } catch (\Exception $e) {
                $this->command->error("Terjadi kesalahan saat membaca file pertama: " . $e->getMessage());
            }
        }

        // --- B. PROSES FILE EXCEL KEDUA ---
        $this->command->info('Memulai proses import data dari file kedua: teman_dibagi2.xlsx...');
        $excelFile2 = storage_path('app/teman_ti.xlsx');

        if (!file_exists($excelFile2)) {
            $this->command->error("File Excel kedua tidak ditemukan!");
            $this->command->warn("Pastikan file 'teman_ti.xlsx' ada di 'storage/app/'.");
        } else {
            try {
                $spreadsheet2 = \PhpOffice\PhpSpreadsheet\IOFactory::load($excelFile2);
                $sheet2 = $spreadsheet2->getActiveSheet();
                $dataTamu2 = [];

                // Mendapatkan baris maksimal yang memiliki data agar dinamis
                $highestRow = $sheet2->getHighestDataRow();

                for ($row = 2; $row <= $highestRow; $row++) {
                    // Mengambil nilai berdasarkan kolom yang sudah ditentukan (C, D, I)
                    $nim = $sheet2->getCell('C' . $row)->getValue();
                    $nama = $sheet2->getCell('D' . $row)->getValue();
                    $barcode = $sheet2->getCell('I' . $row)->getValue();

                    // Pastikan Barcode dan NIM tidak kosong
                    if (!empty($barcode) && !empty($nim)) {
                        $dataTamu2[] = [
                            'nim'        => (string) $nim,
                            'nama'       => (string) $nama,
                            'barcode'    => (string) $barcode,
                            'is_scanned' => false,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }

                if (count($dataTamu2) > 0) {
                    Tamu::insert($dataTamu2);
                    $this->command->info(count($dataTamu2) . ' data Tamu berhasil diimport dari file kedua!');
                } else {
                    $this->command->warn('Tidak ada data valid yang terbaca dari file Excel kedua.');
                }
            } catch (\Exception $e) {
                $this->command->error("Terjadi kesalahan saat membaca file kedua: " . $e->getMessage());
            }
        }
        
        $this->command->info('Semua proses seeder selesai dijalankan!');
    }
}