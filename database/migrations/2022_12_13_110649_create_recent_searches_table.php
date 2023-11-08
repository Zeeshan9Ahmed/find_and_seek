<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecentSearchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recent_searches', function (Blueprint $table) {
            $table->id();
            $table->integer('searched_by')->nullable();
            $table->integer('searched_user_id')->nullable();
            $table->text('searched_text')->nullable();
            $table->integer('job_id')->nullable();
            $table->enum('type',['company', 'user'])->nullable();
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
        Schema::dropIfExists('recent_searches');
    }
}
