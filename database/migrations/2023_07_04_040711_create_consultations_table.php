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
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('society_id');
            $table->unsignedBigInteger('docter_id')->nullable();
            $table->enum('status', ['accepted', 'declined', 'pending'])->default('pending');
            $table->text('disease_history');
            $table->text("current_symptoms");
            $table->text("doctor_notes")->nullable();
            $table->foreign('docter_id')->references('id')->on('medicals');
            $table->foreign('society_id')->references('id')->on('societies');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};