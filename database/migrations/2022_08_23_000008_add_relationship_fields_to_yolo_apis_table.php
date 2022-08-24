<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToYoloApisTable extends Migration
{
    public function up()
    {
        Schema::table('yolo_apis', function (Blueprint $table) {
            $table->unsignedBigInteger('enviroment_id')->nullable();
            $table->foreign('enviroment_id', 'enviroment_fk_7195726')->references('id')->on('enviroments');
        });
    }
}
