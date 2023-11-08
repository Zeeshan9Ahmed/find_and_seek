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
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->nullable();
            $table->string('avatar')->nullable();
            $table->string('password')->nullable();
            $table->string('email')->nullable();
            $table->boolean('profile_completed')->default(0);
            $table->enum('role',['user','admin','company', 'individual'])->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('current_role')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('contact')->nullable();
            $table->string('device_type')->nullable();
            $table->string('device_token')->nullable();
            $table->string('social_type')->nullable();
            $table->string('social_token')->nullable();
            $table->enum('is_active',["0","1"])->default(0);
            $table->boolean('is_social')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
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
};
