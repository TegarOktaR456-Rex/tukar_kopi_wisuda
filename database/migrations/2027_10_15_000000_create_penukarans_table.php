<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penukarans', function (Blueprint $table) {$table->id();
            
            // Relasi ke tabel pelayans (siapa yang men-scan)
            $table->foreignId('pelayan_id')
                  ->constrained('pelayans')
                  ->onDelete('cascade');
                  
            // Relasi ke tabel tamus (siapa yang di-scan barcode-nya)
            $table->foreignId('tamu_id')
                  ->constrained('tamus')
                  ->onDelete('cascade');
                  
            // Mencatat kapan penukaran kopi terjadi
            $table->timestamp('waktu_penukaran')->useCurrent();$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penukarans');
    }
};