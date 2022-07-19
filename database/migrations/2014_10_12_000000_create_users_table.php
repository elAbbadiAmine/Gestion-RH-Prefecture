<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('nom');
            $table->string('prenom')->nullable();
            $table->string('CNE')->inuque()->nullable();
            $table->unsignedInteger('Division')->nullable();
           // $table->foreign('Division')->references('id')->on('division');
            $table->string('Matricule')->unique()->nullable();
            $table->string('Sex')->nullable();
            $table->date('Date_naissance')->nullable();
            $table->string('Adresse')->nullable();
            $table->string('Telephone')->unique()->nullable();
            $table->date('Date_recrutement')->nullable();
            $table->string('Intitule')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('password')->nullable();
            $table->string('type')->default('admin')->nullable();
            $table->mediumText('bio')->nullable();
            $table->string('photo')->default('profile.png')->nullable();
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
