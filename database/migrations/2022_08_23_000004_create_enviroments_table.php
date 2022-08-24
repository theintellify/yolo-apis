<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnviromentsTable extends Migration
{
    public function up()
    {
        Schema::create('enviroments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('enviroment');
            $table->string('baseurl');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
