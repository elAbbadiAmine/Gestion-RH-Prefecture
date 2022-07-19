<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDemandeUtilisateurTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demande_utilisateur', function (Blueprint $table) {
            $table->increments('id_demande_utilisateur');
            $table->date('date_etat');
            $table->unsignedInteger('id_demande');
            //$table->foreign('id_demande')->references('id_demande')->on('demande');
            $table->unsignedInteger('id_etat');
            //$table->foreign('id_etat')->references('id_etat')->on('etat');
            $table->unsignedInteger('id_utilisateur');
            //$table->foreign('id_utilisateur')->references('id')->on('users');
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
        Schema::dropIfExists('demande_utilisateur');
    }
}
