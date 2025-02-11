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
    Schema::create('mskaryawan', function (Blueprint $table) {
        $table->id('kry_id');
        $table->string('kry_username', 50)->unique();
        $table->string('kry_password');
        $table->string('kry_nama_lengkap', 100);
        $table->string('kry_email', 100)->unique();
        $table->string('kry_role', 20);
        $table->string('kry_status_kary', 20);
        $table->string('kry_created_by');
        $table->timestamp('kry_created_date')->default(DB::raw('CURRENT_TIMESTAMP'));
        $table->string('kry_modif_by')->nullable();
        $table->timestamp('kry_modif_date')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mskaryawan');
    }
};
