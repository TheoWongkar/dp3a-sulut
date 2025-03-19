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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('handled_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('ticket_number')->unique();
            $table->string('violence_category');
            $table->text('chronology')->nullable();
            $table->date('date');
            $table->string('scene');
            $table->string('evidence')->nullable();
            $table->timestamps();
        });

        Schema::create('victims', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('reports')->onDelete('cascade');
            $table->text('nik')->nullable();
            $table->text('name');
            $table->string('phone', 13);
            $table->string('address')->nullable();
            $table->unsignedTinyInteger('age')->default(0);
            $table->enum('gender', ['Pria', 'Wanita']);
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('perpetrators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('reports')->onDelete('cascade');
            $table->text('nik')->nullable();
            $table->text('name')->nullable();
            $table->string('phone', 13)->nullable();
            $table->string('address')->nullable();
            $table->unsignedTinyInteger('age')->default(0);
            $table->enum('gender', ['Pria', 'Wanita']);
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('reporters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('reports')->onDelete('cascade');
            $table->text('nik')->nullable();
            $table->text('name');
            $table->string('phone', 13);
            $table->string('address')->nullable();
            $table->unsignedTinyInteger('age')->default(0);
            $table->enum('gender', ['Pria', 'Wanita']);
            $table->enum('relationship_between', ['Orang Tua', 'Saudara', 'Guru', 'Teman', 'Lainnya']);
            $table->timestamps();
        });

        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('reports')->onDelete('cascade');
            $table->enum('status', ['Diterima', 'Diproses', 'Selesai', 'Dibatalkan'])->default('Diterima');
            $table->string('description')->default('Laporan diterima, menunggu persetujuan admin.');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
        Schema::dropIfExists('victims');
        Schema::dropIfExists('perpetrators');
        Schema::dropIfExists('reporters');
        Schema::dropIfExists('statuses');
    }
};
