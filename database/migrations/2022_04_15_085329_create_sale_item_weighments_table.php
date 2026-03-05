<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleItemWeighmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_item_weighments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_item_id');
            $table->foreign('sale_item_id')->references('id')->on('sale_items')->onDelete('cascade');
            $table->foreignId('primary_id')->nullable();
            $table->double('primary_qty')->nullable();
            $table->foreignId('secondary_id')->nullable();
            $table->double('secondary_qty')->nullable();
            $table->boolean('primaryCheck')->nullable();
            $table->boolean('secondaryCheck')->nullable();
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
        Schema::dropIfExists('sale_item_weighments');
    }
}
