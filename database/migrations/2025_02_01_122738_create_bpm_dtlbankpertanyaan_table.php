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
        $table->bigIncrements('dtl_id');
        $table->bigInteger('pty_id')->unsigned();
        $table->bigInteger('kry_id')->unsigned();
        $table->string('dtl_status');
        $table->string('dtl_created_by');
        $table->timestamp('dtl_created_date')->default(DB::raw('CURRENT_TIMESTAMP'));
        $table->string('dtl_modif_by')->nullable();
        $table->timestamp('dtl_modif_date')->nullable();
        $table->timestamps();
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
