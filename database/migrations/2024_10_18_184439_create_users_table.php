<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');
            $table->string('name_en');
            $table->boolean('is_directory')->default(false);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('usrename')->nullable();
            $table->bigInteger('phone')->nullable();
            $table->string('ID_code')->nullable();
            $table->string('passport_code')->nullable();
            $table->double('salary', 10, 2)->default(0.0);
            $table->string('location_ar')->nullable();
            $table->string('location_en')->nullable();
            $table->datetime('date_of_brith')->nullable();
            $table->datetime('join_date')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->unsignedBigInteger('gender_id')->nullable();
            $table->foreign('gender_id')->references('id')->on('lookups')->onDelete('cascade');
            $table->unsignedBigInteger('reigon_id')->nullable();
            $table->foreign('reigon_id')->references('id')->on('lookups')->onDelete('cascade');
            $table->unsignedBigInteger('material_status_id')->nullable();
            $table->foreign('material_status_id')->references('id')->on('lookups')->onDelete('cascade');
            $table->unsignedBigInteger('work_type_id')->nullable();
            $table->foreign('work_type_id')->references('id')->on('lookups')->onDelete('cascade');
            $table->unsignedBigInteger('contract_type_id')->nullable();
            $table->foreign('contract_type_id')->references('id')->on('lookups')->onDelete('cascade');
            $table->unsignedBigInteger('directory_id')->nullable();
            $table->foreign('directory_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('status_user_id')->nullable();
            $table->foreign('status_user_id')->references('id')->on('lookups')->onDelete('cascade');
            $table->string('photo')->nullable();
            $table->text('fcm_token')->nullable();

            $table->string('code_auth')->nullable();
            $table->datetime('expire_time')->nullable();
            $table->datetime('last_login')->nullable();
            $table->string('google_id')->nullable();
            $table->string('facebook_id')->nullable();
            $table->string('twitter_id')->nullable();
            $table->boolean('enable_notification')->default(true);
            $table->string('ip')->nullable();
            $table->json('user_agent')->nullable();

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
