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
            $table->foreignId('employee_id')->nullable()->constrained('employees')->onDelete('cascade');
            $table->string('ticket_number')->unique();
            $table->string('violence_category');
            $table->string('chronology');
            $table->date('date');
            $table->string('scene');
            $table->string('evidence')->nullable();
            $table->timestamps();
        });

        Schema::create('victims', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('reports')->onDelete('cascade');
            $table->string('name');
            $table->string('phone', 13);
            $table->string('address');
            $table->unsignedTinyInteger('age');
            $table->enum('gender', ['Pria', 'Wanita']);
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('perpetrators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('reports')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->unsignedTinyInteger('age')->nullable();
            $table->enum('gender', ['Pria', 'Wanita']);
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('reporters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('reports')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('phone', 13)->nullable();
            $table->string('address')->nullable();
            $table->string('relationship_between');
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
