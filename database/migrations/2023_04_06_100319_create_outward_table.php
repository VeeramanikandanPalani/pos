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
        Schema::create('outward', function (Blueprint $table) {
            $table->id();
            $table->string('supplier_code',255);
            $table->foreign('supplier_code')->references('supplier_code')->on('supplier');
            $table->string('item_code',255);
            $table->foreign('item_code')->references('item_code')->on('items');
            $table->string('item_qty');
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
        Schema::dropIfExists('outward');
    }
};
