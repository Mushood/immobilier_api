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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->integer('batch')->nullable(true);
            $table->string('title');
            $table->string('link');
            $table->string('category')->nullable(true);
            $table->string('location')->nullable(true);
            $table->string('region')->nullable(true);
            $table->string('type')->nullable(true);
            $table->string('purchasing_type')->nullable(true);
            $table->bigInteger('price')->nullable(true);
            $table->integer('surface_area')->nullable(true);
            $table->integer('surface_area_land')->nullable(true);
            $table->integer('surface_area_interior')->nullable(true);
            $table->integer('bedrooms')->nullable(true);
            $table->integer('bathrooms')->nullable(true);
            $table->integer('toilets')->nullable(true);
            $table->boolean('done')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('properties');
    }
};
