<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppPlansTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_plans', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique();
            $table->integer('user_id')->nullable();
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
        Schema::drop('app_plans');
    }
}
