<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->string('invoice');
            $table->string('namaPembeli');
            $table->string('genderPembeli');
            $table->unsignedBigInteger('idProduk');
            $table->string('namaProduk')->nullable();
            $table->integer('jumlahProduk');
            $table->decimal('harga', 15, 2);
            $table->decimal('totalHarga', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};
