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
        Schema::create('normal_values', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('liquefaction')->nullable();
            $table->string('apperance')->nullable();
            $table->string('ph')->nullable();
            $table->string('volume')->nullable();
            $table->string('viscosity')->nullable();
            $table->string('abstinence')->nullable();
            $table->string('medication')->nullable();
            $table->string('spermConcentration')->nullable();
            $table->string('agglutination')->nullable();
            $table->string('clumping')->nullable();
            $table->string('granularDebris')->nullable();
            $table->string('totalMotility')->nullable();
            $table->string('rapidProgressiveMovement')->nullable();
            $table->string('sluggishProgressiveMovement')->nullable();
            $table->string('nonProgressive')->nullable();
            $table->string('nonMotile')->nullable();
            $table->string('normalSperms')->nullable();
            $table->string('headDefects')->nullable();
            $table->string('neckMidPieceDefects')->nullable();
            $table->string('tailDeffects')->nullable();
            $table->string('cytoplasmicDroplets')->nullable();
            $table->string('epithelialCells')->nullable();
            $table->string('pusCells')->nullable();
            $table->string('RBC')->nullable();

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

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('normal_values');
    }
};
