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
        Schema::create('log_transantions', function (Blueprint $table) {
            $table->increments('id_log_transaction');
            $table->unsignedInteger('id_invoice');
            $table->foreign('id_invoice')->references('id_invoice')->on('log_invoices')->onDelete('cascade');
            $table->unsignedInteger('id_produk');
            $table->foreign('id_produk')->references('id_produk')->on('products')->onDelete('cascade');
            $table->integer('jumlah_produk');
            $table->integer('total_harga_produk');
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
        Schema::dropIfExists('log_transantions');
    }
};
