<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'mysql';
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('system_id')->nullable();
            $table->string('username');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('salt')->nullable();
            $table->string('secret_question')->nullable();
            $table->string('secret_answer')->nullable();
            $table->integer('creator');
            $table->datetime('date_created');
            $table->integer('changed_by')->nullable();
            $table->datetime('date_changed')->nullable();
            $table->integer('person_id');
            $table->boolean('retired')->default(0);
            $table->integer('retired_by')->nullable();
            $table->string('retire_reason')->nullable();
            $table->string('uuid');
            $table->timestamps();
       
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
