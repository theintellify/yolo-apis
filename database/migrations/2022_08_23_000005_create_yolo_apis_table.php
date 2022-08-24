<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYoloApisTable extends Migration
{
    public function up()
    {
        Schema::create('yolo_apis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('api_type');
            $table->string('url');
            $table->string('endpoint');
            $table->string('cognito');
            $table->longText('request_body');
            $table->longText('response_data')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
