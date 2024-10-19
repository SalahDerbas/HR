<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMissingPunchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('missing_punches', function (Blueprint $table) {
            $table->id();
            $table->datetime('date')->nullable();
            $table->text('time')->nullable();
            $table->string('reason')->nullable();
            $table->string('document')->nullable();
            $table->unsignedBigInteger('type_missing_punch_id')->nullable();
            $table->foreign('type_missing_punch_id')->references('id')->on('lookups')->onDelete('cascade');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('missing_punches');
    }
}
