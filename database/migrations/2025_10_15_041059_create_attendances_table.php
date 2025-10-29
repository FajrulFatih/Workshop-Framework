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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('karyawan_id');
            $table->date('tanggal');
            $table->timestamp('waktu_masuk')->nullable();
            $table->timestamp('waktu_keluar')->nullable();
            $table->enum('status_absensi', ['hadir', 'izin', 'sakit', 'alpha'])->default('hadir');
            $table->rememberToken();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('karyawan_id')
                ->references('id')
                ->on('employees')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropForeign(['karyawan_id']);
            $table->dropColumn(['karyawan_id']);
        });
    }
};
