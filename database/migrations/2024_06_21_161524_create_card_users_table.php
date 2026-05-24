<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardUsersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_users', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique();
            $table->integer('user_id')->nullable();
            $table->integer('card_id')->nullable();
            $table->string('msg')->nullable();
            $table->string('code')->nullable();
            $table->string('issued_at')->nullable();
            $table->string('expired_at')->nullable();

            
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('card_no')->nullable();
            $table->string('id_type')->nullable();
            $table->string('live_selfie')->nullable(); 

            $table->integer('type')->nullable()->default(0);
            $table->integer('status')->nullable()->default(0);
            $table->integer('right')->nullable()->default(0);
            $table->boolean('is_active')->nullable()->default(true);
            $table->timestamps();
            $table->softDeletes();
            // $table->foreign('user_id')->references('id')->on('users');
            // $table->foreign('card_id')->references('id')->on('cards');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('card_users');
    }
}
