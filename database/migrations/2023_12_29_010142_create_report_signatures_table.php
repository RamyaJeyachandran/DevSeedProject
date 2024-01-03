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
        Schema::create('report_signatures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('leftDoctorId')->unsigned()->nullable();
            $table->bigInteger('leftSignId')->unsigned()->nullable();

            $table->bigInteger('rightDoctorId')->unsigned()->nullable();
            $table->bigInteger('rightSignId')->unsigned()->nullable();

            $table->bigInteger('centerDoctorId')->unsigned()->nullable();
            $table->bigInteger('centerSignId')->unsigned()->nullable();

            $table->boolean('isDefault');

            $table->bigInteger('hospitalId')->unsigned();
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
            
            $table->foreign('leftDoctorId')->references('id')->on('doctors');
            $table->foreign('rightDoctorId')->references('id')->on('doctors');
            $table->foreign('centerDoctorId')->references('id')->on('doctors');
            $table->foreign('leftSignId')->references('id')->on('doctorsignatures');
            $table->foreign('rightSignId')->references('id')->on('doctorsignatures');
            $table->foreign('centerSignId')->references('id')->on('doctorsignatures');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_signatures');
    }
};
