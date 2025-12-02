<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Baris ini mengatasi error "Table already exists"
        Schema::dropIfExists('reports'); 

        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reporter_user_id');
            $table->unsignedBigInteger('reported_photo_id');
            $table->text('reason');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    } // <--- Tadi error karena kurung tutup ini hilang

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};