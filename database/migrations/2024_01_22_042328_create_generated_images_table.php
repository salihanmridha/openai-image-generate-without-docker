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
        Schema::create('generated_images', function (Blueprint $table) {
            $table->id();
            $table->string("keyword", 255);
            $table->enum("status", ["PROCESSING", "COMPLETED", "FAILED"])->default("PROCESSING");
            $table->text("prompt")->nullable();
            $table->string('file_name', 255)->nullable();
            $table->string('file_path', 255)->nullable();
            $table->tinyInteger('progress')->default(10);
            $table->text('result')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generated_images');
    }
};
