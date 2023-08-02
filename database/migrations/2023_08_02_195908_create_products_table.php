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
            $table->unsignedBigInteger('id_produk')->primary();
            $table->integer('kode_produk',20);
            $table->string('kategori_produk');
            $table->string('sub_kategori_produk');
            $table->string('nama_produk');
            $table->integer('harga_produk',20);
            $table->float('harga_modal');
            $table->integer('jumlah_produk',20);
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
