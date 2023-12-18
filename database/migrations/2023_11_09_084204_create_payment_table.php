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
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('userId')->unsigned();
            $table->boolean('isSuccess');
            $table->string('code');
            $table->string('message');
            $table->string('merchantId');
            $table->string('merchantTransactionId');
            $table->string('transactionId');
            $table->integer('amount');
            $table->string('state');
            $table->string('responseCode');
            $table->string('paymentType');
            //NETBANKING
            $table->string('pgTransactionId')->nullable();
            $table->string('pgServiceTransactionId')->nullable();
            $table->string('bankTransactionId')->nullable();
            $table->string('bankId')->nullable();
            // UPI
            $table->string('utr')->nullable();
            //Card reader
            $table->string('cardType')->nullable();
            $table->string('pgAuthorizationCode')->nullable();
            $table->string('arn')->nullable();
            $table->string('brn')->nullable();
            //Failed
            $table->longText('responseCodeDescription')->nullable();

            $table->boolean('is_active')->default(1);
            $table->timestamp('created_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->bigInteger('created_by')->unsigned();
            $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();
            
            $table->foreign('userId')->references('id')->on('users');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
