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
        Schema::create('borrow_records', function (Blueprint $table) {
            $table->id(); // Primary key
            // Foreign key to books table, cascades on update and delete
            $table->foreignId('book_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            // Foreign key to users table, cascades on update and delete
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->date('borrowed_at'); // Date when the book was borrowed
            $table->date('due_date')->nullable(); // Due date for returning the book, nullable
            $table->date('returned_at')->nullable(); // Date when the book was returned, nullable
            $table->timestamps(); // Timestamps for created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrow_records');
    }
};
