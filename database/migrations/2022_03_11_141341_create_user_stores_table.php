<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserStoresTable extends Migration
{

    public function up()
    {
        Schema::create('user_stores', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

        });
    }

 
    public function down()
    {
        Schema::dropIfExists('user_stores');
    }
}
