<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('yolo_apis', function (Blueprint $table) {
            $table->enum('api_version', ['2', '3'])->default('2');
            $table->enum('api_status', ['0', '1'])->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('yolo_apis', function (Blueprint $table) {
            //
        });
    }
};
