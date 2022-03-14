<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSearchTable extends Migration
{

    public function up()
    {
        Schema::create('user_search', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->timestamps();
            $table->softDeletes();

        });
    }


    public function down()
    {
        Schema::dropIfExists('user_search');
    }
}
