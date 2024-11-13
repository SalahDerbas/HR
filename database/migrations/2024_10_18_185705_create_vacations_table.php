<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacations', function (Blueprint $table) {
            $table->id();
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->string('doucument')->nullable();
            $table->string('reason')->nullable();
            $table->unsignedBigInteger('type_vacation_id')->nullable();
            $table->foreign('type_vacation_id')->references('id')->on('lookups')->onDelete('cascade');
            $table->unsignedBigInteger('status_vacation_id')->nullable();
            $table->foreign('status_vacation_id')->references('id')->on('lookups')->onDelete('cascade');
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
        Schema::dropIfExists('vacations');
    }
}
