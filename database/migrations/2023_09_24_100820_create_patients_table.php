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
        Schema::create('patients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('hcNo');
            $table->string('name');
            $table->string('profileImage')->nullable();
            $table->datetime('dob')->nullable();
            $table->integer('age')->nullable();
            $table->string('gender')->nullable();
            $table->string('bloodGroup')->nullable();
            $table->string('martialStatus')->nullable();
            $table->string('patientWeight')->nullable();
            $table->string('patientHeight')->nullable();
            $table->string('phoneNo');
            $table->string('email');
            $table->longText('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('pincode')->nullable();
            $table->string('spouseName')->nullable();
            $table->string('spousePhnNo')->nullable();
            $table->string('refferedBy')->nullable();
            $table->string('refDoctorName')->nullable();
            $table->string('refDrHospitalName')->nullable();
            $table->longText('reason')->nullable();

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
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
