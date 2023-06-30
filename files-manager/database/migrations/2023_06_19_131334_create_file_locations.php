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
        Schema::create('file_locations', function (Blueprint $table) {
            $table->id();
            $table->string('room_number');
            $table->string('cabinet_number');
            $table->string('shelf_number');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('file_id')->constrained('files')->onDelete('cascade');
            $table->string('manager_id');
            $table->timestamps();
            $table->index('manager_id');  

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_locations');
    }
};
