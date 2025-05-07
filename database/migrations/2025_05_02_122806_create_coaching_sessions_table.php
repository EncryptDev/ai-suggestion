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
        Schema::create('coaching_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('kepsek_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('observasi_id')->constrained('observasis','id')->cascadeOnDelete();
            $table->date('tanggal');
            $table->text('topik_diskusi');
            $table->text('hasil_refleksi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coaching_sessions');
    }
};
