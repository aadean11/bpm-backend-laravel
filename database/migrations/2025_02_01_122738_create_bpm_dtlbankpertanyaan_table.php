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
    Schema::create('bpm_dtlbankpertanyaan', function (Blueprint $table) {
        $table->id('dtl_id');
        $table->unsignedBigInteger('pty_id');
        $table->unsignedBigInteger('kry_id');
        $table->string('dtl_status');
        $table->string('dtl_created_by');
        $table->timestamp('dtl_created_date')->useCurrent();
        $table->string('dtl_modif_by')->nullable();
        $table->timestamp('dtl_modif_date')->nullable();
        $table->timestamps();

        // Foreign key constraints, jika ada
        $table->foreign('pty_id')->references('pty_id')->on('bpm_mspertanyaan');
        $table->foreign('kry_id')->references('kry_id')->on('karyawan'); // Pastikan ini sesuai dengan struktur tabel karyawan
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bpm_dtlbankpertanyaan');
    }
};
