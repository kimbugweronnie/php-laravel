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
        Schema::create('patient', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('creator');
            $table->foreign('creator')->references('id')->on('users')->onDelete('cascade');
            $table->datetime('date_created');
            $table->unsignedBigInteger('changed_by');
            $table->foreign('changed_by')->references('id')->on('users')->onDelete('cascade');
            $table->datetime('date_changed')->nullable();
            $table->boolean('voided')->default(0);
            $table->unsignedBigInteger('voided_by');
            $table->foreign('voided_by')->references('id')->on('users')->onDelete('cascade');
            $table->datetime('date_voided')->nullable();
            $table->string('void_reason')->nullable();
            $table->string('allergy_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient');
    }
};
