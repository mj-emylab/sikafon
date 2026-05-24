<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePinsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pins', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique();
            $table->integer('user_id')->nullable();
            $table->string('msg')->nullable();
            $table->string('code')->nullable();
            $table->string('codeable_type')->nullable();
            $table->integer('codeable_id')->nullable()->default(0);
            $table->string('expired_at')->nullable();
            $table->integer('type')->nullable()->default(0);
            $table->integer('status')->nullable()->default(0);
            $table->integer('right')->nullable()->default(0);
            $table->boolean('is_active')->nullable()->default(true);
            $table->timestamps();
            $table->softDeletes();
            // $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pins');
    }
}
