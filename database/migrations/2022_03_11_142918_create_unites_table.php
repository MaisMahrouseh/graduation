<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitesTable extends Migration
{

    public function up()
    {
        Schema::create('unites', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['name', 'deleted_at']);

        });
    }


    public function down()
    {
        Schema::dropIfExists('unites');
    }
}
