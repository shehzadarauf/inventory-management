<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('sale_no')->nullable();
            $table->foreignId('customer_id');
            $table->string('transport');
            $table->string('vehicle_no')->nullable();
            $table->string('status')->default('pending');
            $table->text('details')->nullable();
            $table->string('picture')->nullable();
            $table->boolean('weighted')->default(false);
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
        Schema::dropIfExists('sales');
    }
}
