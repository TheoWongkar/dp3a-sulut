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
            $table->enum('violence_category', ['Fisik', 'Psikis', 'Seksual', 'Penelantaran', 'Eksploitasi', 'Lainnya']);
            $table->text('chronology')->nullable();
            $table->date('incident_date');
            $table->string('regency');
            $table->string('district');
            $table->string('scene');
            $table->string('evidence')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index('violence_category');
        });

        Schema::create('victims', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('reports')->onDelete('cascade');
            $table->text('nik')->nullable();
            $table->string('name')->nullable();
            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();
            $table->unsignedTinyInteger('age')->nullable();
            $table->enum('gender', ['Laki-laki', 'Perempuan'])->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('suspects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('reports')->onDelete('cascade');
            $table->text('nik')->nullable();
            $table->string('name')->nullable();
            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();
            $table->unsignedTinyInteger('age')->nullable();
            $table->enum('gender', ['Laki-laki', 'Perempuan'])->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('reporters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('reports')->onDelete('cascade');
            $table->text('nik')->nullable();
            $table->string('name');
            $table->string('phone', 20);
            $table->text('address')->nullable();
            $table->unsignedTinyInteger('age')->nullable();
            $table->enum('gender', ['Laki-laki', 'Perempuan']);
            $table->enum('relationship_between', ['Diri Sendiri', 'Orang Tua', 'Saudara', 'Guru', 'Teman', 'Lainnya']);
            $table->timestamps();
        });

        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('reports')->onDelete('cascade');
            $table->foreignId('changed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('status', ['Diterima', 'Menunggu Verifikasi', 'Diproses', 'Selesai', 'Dibatalkan'])->default('Diterima');
            $table->text('description');
            $table->timestamps();

            $table->index('status', 'reports_status_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
        Schema::dropIfExists('victims');
        Schema::dropIfExists('suspects');
        Schema::dropIfExists('reporters');
        Schema::dropIfExists('statuses');
    }
};
