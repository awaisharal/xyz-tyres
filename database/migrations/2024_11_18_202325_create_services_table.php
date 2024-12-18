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
            $table->foreignId('service_provider_id')->constrained()->onDelete('cascade'); // Foreign key to service_providers table
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image')->nullable(); // Assuming you will store the image path
            $table->decimal('price', 8, 2)->default(0);            // $table->time('duration')->nullable();
            $table->integer('duration')->nullable();
            $table->string('duration_type', 20)->nullable();
            $table->tinyInteger('notify_via_email')->default(0);
            $table->tinyInteger('notify_via_sms')->default(0);
            $table->boolean('first_reminder_enabled')->default(false);            
            $table->integer('first_reminder_duration')->nullable(); // Duration for first reminder
            $table->string('first_reminder_duration_type', 20)->nullable(); // Hours before appointment for first reminder
            $table->text('first_reminder_message')->nullable();
            $table->boolean('second_reminder_enabled')->default(false);
            $table->integer('second_reminder_duration')->nullable(); // Duration for second reminder
            $table->string('second_reminder_duration_type', 20)->nullable();  // Hours before appointment for second reminder
            $table->text('second_reminder_message')->nullable();
            $table->boolean('followup_reminder_enabled')->default(false);
            $table->integer('followup_reminder_duration')->nullable(); // Duration for follow-up reminder
            $table->string('followup_reminder_duration_type', 20)->nullable(); // Hours after the appointment for follow-up reminder
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
