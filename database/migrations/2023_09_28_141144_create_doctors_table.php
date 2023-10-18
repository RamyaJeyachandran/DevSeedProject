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
        Schema::create('doctors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('doctorCodeNo');
            $table->string('name');
            $table->string('profileImage')->nullable();
            $table->string('signature')->nullable();
            $table->datetime('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('phoneNo');
            $table->string('email');
            $table->string('education')->nullable();
            $table->string('designation')->nullable();
            $table->bigInteger('departmentId')->unsigned()->nullable();;
            $table->string('experience')->nullable();
            $table->string('address')->nullable();
            $table->string('bloodGroup')->nullable();


            $table->bigInteger('hospitalId')->unsigned()->nullable();
            $table->bigInteger('branchId')->unsigned()->nullable();

            $table->boolean('is_active')->default(1);
            $table->timestamp('created_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->bigInteger('created_by')->unsigned();
            $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('departmentId')->references('id')->on('departments');
            
            $table->foreign('hospitalId')->references('id')->on('hospitalsettings');
            $table->foreign('branchId')->references('id')->on('hospitalBranch');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
