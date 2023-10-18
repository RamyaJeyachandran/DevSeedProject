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
        Schema::create('patient_consent_forms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('patientId')->unsigned();
            $table->bigInteger('consentFormId')->unsigned();

            $table->boolean('is_active')->default(1);
            $table->timestamp('created_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->bigInteger('created_by')->unsigned();
            $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('patientId')->references('id')->on('patients');
            $table->foreign('consentFormId')->references('id')->on('consent_froms');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_consent_forms');
    }
};
