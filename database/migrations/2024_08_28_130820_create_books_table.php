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
        Schema::create('books', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('title')->unique(); // Book title, must be unique
            $table->string('author'); // Author of the book
            $table->string('type'); // Type of the book
            $table->string('description'); // Description of the book
            $table->date('published_at'); // Publication date of the book
            $table->timestamps(); // Timestamps for created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
