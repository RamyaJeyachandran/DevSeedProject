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
        Schema::create('appointments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('appointmentDate');
            $table->time('appointmentTime', $precision = 0);
            $table->bigInteger('patientId')->unsigned();
            $table->bigInteger('doctorId')->unsigned();
            $table->longText('reason')->nullable();
            $table->string('status')->default("Created");

            $table->bigInteger('hospitalId')->unsigned()->nullable();
            $table->bigInteger('branchId')->unsigned()->nullable();

            $table->boolean('is_active')->default(1);
            $table->timestamp('created_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->bigInteger('created_by')->unsigned();
            $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('hospitalId')->references('id')->on('hospitalsettings');
            $table->foreign('branchId')->references('id')->on('hospitalBranch');
            $table->foreign('doctorId')->references('id')->on('doctors');
            $table->foreign('patientId')->references('id')->on('patients');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
