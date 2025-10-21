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
        Schema::table('querygrouplinks', function (Blueprint $table) {
            $table->foreign('querygroupid')->references('querygroupid')->on('querygroups')->onDelete('cascade');
            $table->foreign('queryid')->references('queryid')->on('queries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
