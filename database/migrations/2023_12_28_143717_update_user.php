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
        Schema::table('users', function (Blueprint $table) {
            $table->string('colorId')->nullable();
            $table->bigInteger('defaultHospitalId')->unsigned()->nullable();
            $table->bigInteger('defaultBranchId')->unsigned()->nullable();
            $table->timestamp('lastActivityDateTime')->nullable();

            $table->foreign('defaultHospitalId')->references('id')->on('hospitalsettings');
            $table->foreign('defaultBranchId')->references('id')->on('hospitalBranch');
         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('colorId');
            $table->dropColumn('defaultHospitalId');
            $table->dropColumn('defaultBranchId');
         });
    }
};
