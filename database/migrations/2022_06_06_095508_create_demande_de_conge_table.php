$<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDemandeDeCongeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conges', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('utilisateur')->nullable();
            $table->foreign('utilisateur')->references('id')->on('users');
            $table->string("type")->nullable();
            $table->date("date_debut")->nullable();
            $table->date("date_fin")->nullable();
            $table->datetime("durée")->nullable();
            $table->string("certificat")->nullable();
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
        //
    }
}
