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
        Schema::create('constants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tableName')->nullable();
            $table->bigInteger('parentTableId')->nullable();;
            $table->string('name')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamp('created_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('created_by');
            $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
            $table->integer('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('constants');
    }
};
