<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDemanderhTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demanderh', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('utilisateur')->nullable();
            $table->foreign('utilisateur')->references('id')->on('users');
            $table->string("type")->nullable();
            $table->string("langue")->nullable();
            $table->string("Commentaire")->nullable();
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
        Schema::dropIfExists('demanderh');
    }
}
