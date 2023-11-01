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
        Schema::create('semenanalysis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('liquefaction')->nullable();
            $table->string('appearance')->nullable();
            $table->string('ph')->nullable();
            $table->string('volume')->nullable();
            $table->string('viscosity')->nullable();
            $table->string('abstinence')->nullable();
            $table->string('medication')->nullable();
            $table->string('spermconcentration')->nullable();
            $table->string('agglutination')->nullable();
            $table->string('clumping')->nullable();
            $table->string('granulardebris')->nullable();
            $table->string('totalmotility')->nullable();
            $table->string('rapidprogressivemovement')->nullable();
            $table->string('sluggishprogressivemovement')->nullable();
            $table->string('nonprogressive')->nullable();
            $table->string('nonmotile')->nullable();
            $table->string('normalsperms')->nullable();
            $table->string('headdefects')->nullable();
            $table->string('neckandmidpiecedefects')->nullable();
            $table->string('taildefects')->nullable();
            $table->string('cytoplasmicdroplets')->nullable();
            $table->string('epithelialcells')->nullable();
            $table->string('puscells')->nullable();
            $table->string('rbc')->nullable();
            $table->longText('impression')->nullable();
            $table->longText('comments')->nullable();



            $table->bigInteger('patientId')->unsigned();
            $table->bigInteger('doctorId')->unsigned();
            
            $table->bigInteger('leftScientistId')->unsigned()->nullable();
            $table->bigInteger('centerScientistId')->unsigned()->nullable();
            $table->bigInteger('rightMedicalDirectorId')->unsigned()->nullable();

            $table->bigInteger('leftsigndoctorid')->unsigned()->nullable();
            $table->bigInteger('centersigndoctorid')->unsigned()->nullable();
            $table->bigInteger('rightsigndoctorid')->unsigned()->nullable();


            $table->boolean('is_active')->default(1);
            $table->timestamp('created_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->bigInteger('created_by')->unsigned();
            $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('patientId')->references('id')->on('patients');
            $table->foreign('doctorId')->references('id')->on('doctors');

            $table->foreign('leftsigndoctorId')->references('id')->on('doctorsignatures');
            $table->foreign('centersigndoctorId')->references('id')->on('doctorsignatures');
            $table->foreign('rightsigndoctorId')->references('id')->on('doctorsignatures');

            $table->foreign('leftScientistId')->references('id')->on('doctors');
            $table->foreign('centerScientistId')->references('id')->on('doctors');
            $table->foreign('rightMedicalDirectorId')->references('id')->on('doctors');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semenanalysis');
    }
};
