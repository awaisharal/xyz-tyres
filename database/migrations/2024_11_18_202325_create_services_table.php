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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key to shopkeepers table
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image')->nullable(); // Assuming you will store the image path
            $table->decimal('price', 8, 2);
            $table->integer('duration')->nullable(); // Duration in minutes or any unit you prefer
            $table->dateTime('first_reminder_date')->nullable();
            $table->text('first_reminder_message')->nullable();
            $table->dateTime('second_reminder_date')->nullable();
            $table->text('second_reminder_message')->nullable();
            $table->dateTime('followup_reminder_date')->nullable();
            $table->text('followup_reminder_message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};