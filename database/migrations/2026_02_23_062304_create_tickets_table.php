<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique();
            $table->string('location'); // Kolom Nomor Tiket Otomatis
            $table->string('requester_name');          // 1. Nama
            $table->string('divisi');                  // 2. Divisi
            $table->string('no_wa');                   // 3. No WA
            $table->text('subject');                // 4. Kendala
            $table->enum('priority', ['Low', 'Medium', 'High', 'Critical']);
            $table->enum('status', ['New', 'Open', 'On-hold', 'Pending', 'Resolved', 'Spam', 'Trash'])->default('New');
            $table->string('channel')->default('Web');
            $table->string('assigned_to')->nullable(); // Nama Teknisi
            $table->timestamp('started_at')->nullable(); // Waktu Mulai Dikerjakan
            $table->timestamp('finished_at')->nullable(); // Waktu Selesai
            $table->timestamps();
        });
    }
};
