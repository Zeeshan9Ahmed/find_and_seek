<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_employess')->nullable();
            $table->string('representative_avatar')->nullable();
            $table->string('representative_name')->nullable();
            $table->string('representative_email')->nullable();
            $table->string('representative_contact')->nullable();
            $table->string('representative_address')->nullable();
            $table->string('representative_city')->nullable();
            $table->string('representative_state')->nullable();
            $table->string('representative_zip_code')->nullable();
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
        Schema::dropIfExists('companies');
    }
}
