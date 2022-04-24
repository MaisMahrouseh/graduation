<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ForeginKeys extends Migration
{

    public function up()
    {
        Schema::table('favorites', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users', 'id');
            $table->foreignId('store_id')->constrained('stores', 'id');
        });
        Schema::table('store_departments', function (Blueprint $table) {
            $table->foreignId('store_id')->constrained('stores', 'id');
            $table->foreignId('department_id')->constrained('departments', 'id');
        });
        Schema::table('rates', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users', 'id');
            $table->foreignId('store_id')->constrained('stores', 'id');
        });
        Schema::table('user_searches', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users', 'id');
        });
        Schema::table('user_stores', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users', 'id');
            $table->foreignId('store_id')->constrained('stores', 'id');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('product_id')->nullable()->constrained('products', 'id');
        });
        Schema::table('carts', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users', 'id');
            $table->foreignId('product_id')->constrained('products', 'id');
        });
        Schema::table('store_products', function (Blueprint $table) {
            $table->foreignId('store_id')->constrained('stores', 'id');
            $table->foreignId('department_id')->constrained('departments', 'id');
            $table->foreignId('product_id')->constrained('products', 'id');
        });
        Schema::table('product_details', function (Blueprint $table) {
            $table->foreignId('store_product_id')->constrained('store_products', 'id');
            $table->foreignId('unite_id')->constrained('unites', 'id');
        });
        Schema::table('solds', function (Blueprint $table) {
            $table->foreignId('product_detail_id')->constrained('product_details', 'id');
        });
        Schema::table('notifications', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained('users', 'id');
            $table->foreignId('store_id')->nullable()->constrained('stores', 'id');
        });

    }


    public function down()
    {

    }
}
