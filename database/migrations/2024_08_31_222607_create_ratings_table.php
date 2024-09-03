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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id(); // Primary key
            // Foreign key to users table, cascades on update and delete
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            // Foreign key to books table, cascades on update and delete
            $table->foreignId('book_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->integer('rating')->check('rating >= 1 and rating <= 5'); // Rating value between 1 and 5
            $table->string('review')->nullable(); // Optional review text
            $table->timestamps(); // Timestamps for created_at and updated_at
            // Unique constraint to prevent duplicate ratings by the same user for the same book
            $table->unique(['user_id', 'book_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
