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
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id_produk');
            $table->integer('kode_produk');
            $table->unsignedInteger('id_sub_kategori');
            $table->foreign('id_sub_kategori')->references('id_sub_kategori')->on('sub_kategori')->onDelete('cascade');
            $table->string('nama_produk');
            $table->integer('harga_produk');
            $table->float('harga_modal');
            $table->integer('jumlah_produk');
            $table->string('SKU_produk');
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
        Schema::dropIfExists('products');
    }
};
