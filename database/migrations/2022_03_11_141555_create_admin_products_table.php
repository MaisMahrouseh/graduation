<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminProductsTable extends Migration
{

    public function up()
    {
        Schema::create('admin_products', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->string('image');
            $table->timestamps();
            $table->softDeletes();

        });
    }


    public function down()
    {
        Schema::dropIfExists('admin_products');
    }
}
