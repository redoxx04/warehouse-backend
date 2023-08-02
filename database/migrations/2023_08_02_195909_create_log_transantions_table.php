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
            $table->unsignedBigInteger('id_log_transaction')->primary();
            $table->unsignedBigInteger('id_invoice');             
            $table->foreign('id_invoice')->references('id_invoice')->on('log_invoices')->onDelete('cascade');
            $table->unsignedBigInteger('id_produk');             
            $table->foreign('id_produk')->references('id_produk')->on('products')->onDelete('cascade');
            $table->integer('jumlah_produk',50);
            $table->integer('total_harga_produk',50);
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
