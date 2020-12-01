<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContinutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('continut', function (Blueprint $table) {
            $table->id();
            $table->string('data');
            $table->foreignId('categorie_id');
            $table->string('titlu');
            $table->string('descriere');
            $table->foreignId('user_id');
            $table->boolean('verificat');
            $table->timestamps();
            $table->foreign('categorie_id')->references('id')->on('categorii');
            $table->foreign("user_id")->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('continuts');
    }
}
