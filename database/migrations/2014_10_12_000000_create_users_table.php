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
            $table->string('uuid');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('username');
            $table->string('phone')->nullable();
            $table->string('avatar')->default('https://res.cloudinary.com/iro/image/upload/v1595613322/avatar.png');
            $table->string('header')->default('https://res.cloudinary.com/iro/image/upload/v1594295895/samples/Rectangle_1547.png');

            $table->string('provider', 20)->nullable();
            $table->string('provider_id')->nullable();
            $table->string('access_token')->nullable();

            $table->string('location')->nullable()->default(null);
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            
            $table->string('role')->default('user');
            $table->boolean('show_location')->default(true);
            $table->rememberToken();
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
