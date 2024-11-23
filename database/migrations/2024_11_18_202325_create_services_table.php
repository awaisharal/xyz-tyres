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
        $table->integer('duration')->nullable();
        $table->boolean('first_reminder_enabled')->default(false);
        $table->string('first_reminder_days')->nullable();
        $table->string('first_reminder_time')->nullable();
        $table->text('first_reminder_message')->nullable();
        $table->boolean('second_reminder_enabled')->default(false);
        $table->string('second_reminder_days')->nullable();
        $table->string('second_reminder_time')->nullable();
        $table->text('second_reminder_message')->nullable();
        $table->boolean('followup_reminder_enabled')->default(false);
        $table->string('followup_reminder_days')->nullable();
        $table->string('followup_reminder_time')->nullable();
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
