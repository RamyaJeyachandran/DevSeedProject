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
        Schema::table('patients', function (Blueprint $table) {
            $table->bigInteger('refferedByDoctorId')->unsigned()->nullable();
            $table->bigInteger('witnessHospitalId')->unsigned()->nullable();
            $table->bigInteger('witnessBankId')->unsigned()->nullable();
            $table->string('aadharCardNo')->nullable();
            $table->bigInteger('donorBankId')->unsigned()->nullable();

            $table->foreign('refferedByDoctorId')->references('id')->on('doctors');
            $table->foreign('witnessHospitalId')->references('id')->on('doctors');
            $table->foreign('witnessBankId')->references('id')->on('doctors');
            $table->foreign('donorBankId')->references('id')->on('donorBanks');
         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn('refferedByDoctorId');
            $table->dropColumn('witnessHospitalId');
            $table->dropColumn('witnessBankId');
            $table->dropColumn('aadharCardNo');
            $table->dropColumn('donorBankId');
         });
    }
};
