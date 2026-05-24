<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountUsersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_users', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique();
            $table->integer('user_id')->nullable();
            $table->integer('account_id')->nullable();
            $table->integer('code_id')->nullable();
            $table->integer('qrcode_id')->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('account_no')->nullable();
            $table->string('account_ref')->nullable();
            $table->string('agent_code')->nullable();
            $table->string('about')->nullable();
            $table->integer('type')->nullable()->default(0);
            $table->string('balance')->nullable();
            $table->integer('status')->nullable()->default(0);
            $table->boolean('is_active')->nullable()->default(true);
            $table->timestamps();
            $table->softDeletes();
            // $table->foreign('user_id')->references('id')->on('users');
            // $table->foreign('account_id')->references('id')->on('accounts');
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
        Schema::drop('account_users');
    }
}
