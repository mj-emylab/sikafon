<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique();
            $table->integer('user_id')->nullable();
            $table->integer('from_id')->nullable();
            $table->integer('to_id')->nullable();
            $table->integer('account_from_id')->nullable();
            $table->integer('account_to_id')->nullable();
            $table->integer('code_id')->nullable();
            $table->integer('qrcode_id')->nullable();
            $table->string('amount')->nullable();
            $table->string('about')->nullable();
            $table->integer('type')->nullable()->default(0);
            $table->integer('status')->nullable()->default(0);
            $table->boolean('is_active')->nullable()->default(true);
            $table->timestamps();
            $table->softDeletes();
            // $table->foreign('user_id')->references('id')->on('users');
            // $table->foreign('from_id')->references('id')->on('users');
            // $table->foreign('to_id')->references('id')->on('users');
            // $table->foreign('account_from_id')->references('id')->on('account_users');
            // $table->foreign('account_to_id')->references('id')->on('account_users');
            // $table->foreign('code_id')->references('id')->on('codes');
            // $table->foreign('qrcode_id')->references('id')->on('codes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('payments');
    }
}
