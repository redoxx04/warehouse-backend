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
    Schema::create('carts', function (Blueprint $table) {
        $table->increments('id_cart');
        $table->unsignedInteger('id_user'); // Associate cart with user
        $table->unsignedInteger('id_produk'); // Product added to the cart
        $table->integer('jumlah_produk_invoice'); // Quantity of product in the cart
        // Add any other necessary fields
        $table->timestamps();

        $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        $table->foreign('id_produk')->references('id_produk')->on('products')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carts');
    }
};
