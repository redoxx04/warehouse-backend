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
        Schema::create('log_invoices', function (Blueprint $table) {
            $table->increments('id_invoice');
            $table->string('nomor_invoice');
            $table->string('nama_invoice');
            $table->string('asal_transaksi');
            $table->string('contact_number');
            $table->string('address_invoice');
            $table->unsignedInteger('total_transaksi');
            $table->unsignedInteger('id_user');
            $table->foreign('id_user')->references('id_user')->on('users');
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
        Schema::dropIfExists('log_invoices');
    }
};
