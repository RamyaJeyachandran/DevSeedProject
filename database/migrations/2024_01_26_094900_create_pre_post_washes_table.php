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
        Schema::create('pre_post_washes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('liquefaction')->nullable();
            $table->string('ph')->nullable();
            $table->string('wbc')->nullable();
            $table->string('volume')->nullable();
            $table->string('viscosity')->nullable();
            $table->string('preSpermConcentration')->nullable();
            $table->string('preSpermCount')->nullable();
            $table->string('preMotility')->nullable();
            $table->string('preRapidProgressive')->nullable();
            $table->string('preSlowProgressive')->nullable();
            $table->string('preNonProgressive')->nullable();
            $table->string('preImmotile')->nullable();
            $table->string('media')->nullable();
            $table->longText('methodUsed')->nullable();
            $table->string('countInMl')->nullable();
            $table->string('postMotility')->nullable();
            $table->string('postRapidProgressive')->nullable();
            $table->string('postSlowProgressive')->nullable();
            $table->string('postNonProgressive')->nullable();
            $table->string('postImmotile')->nullable();
            $table->longText('impression')->nullable();

            $table->bigInteger('patientId')->unsigned();
            $table->integer('patientSeqNo');
            $table->bigInteger('doctorId')->unsigned();
            $table->bigInteger('reportSignId')->unsigned()->nullable();
            
            $table->boolean('is_active')->default(1);
            $table->timestamp('created_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->bigInteger('created_by')->unsigned();
            $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('patientId')->references('id')->on('patients');
            $table->foreign('doctorId')->references('id')->on('doctors');
            $table->foreign('reportSignId')->references('id')->on('report_signatures');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_post_washes');
    }
};
