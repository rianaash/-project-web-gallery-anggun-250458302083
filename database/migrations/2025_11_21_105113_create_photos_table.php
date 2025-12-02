<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('photos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Pemilik foto
        $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Kategori
        $table->string('image_url');
        $table->string('title');
        $table->text('caption')->nullable();
        $table->integer('likes_count')->default(0); // Hitung cepat like
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photos');
    }
};
