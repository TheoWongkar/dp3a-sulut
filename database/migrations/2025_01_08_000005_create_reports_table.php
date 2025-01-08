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
            $table->string('ticket_number')->unique();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->string('violence_category');
            $table->string('description');
            $table->date('date');
            $table->string('scene');
            $table->string('evidence');
            $table->timestamps();
        });

        Schema::create('victims', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('reports')->onDelete('cascade');
            $table->string('name');
            $table->tinyInteger('age');
            $table->enum('gender', ['Pria', 'Wanita']);
            $table->string('description');
            $table->timestamps();
        });

        Schema::create('perpetrators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('reports')->onDelete('cascade');
            $table->string('name');
            $table->tinyInteger('age');
            $table->string('relationship_between');
            $table->string('description');
            $table->timestamps();
        });

        Schema::create('reporters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('reports')->onDelete('cascade');
            $table->string('whatsapp')->nullable();
            $table->string('telegram')->nullable();
            $table->string('instagram')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });

        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('reports')->onDelete('cascade');
            $table->enum('status', ['Diterima', 'Diproses', 'Selesai', 'Dibatalkan']);
            $table->string('description');
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
