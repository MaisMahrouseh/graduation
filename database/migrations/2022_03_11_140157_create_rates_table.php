<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatesTable extends Migration
{

    public function up()
    {
        Schema::create('rates', function (Blueprint $table) {
            $table->id();
            $table->decimal('rate');
            $table->timestamps();
            $table->softDeletes();
        });
    }

  
    public function down()
    {
        Schema::dropIfExists('rates');
    }
}
