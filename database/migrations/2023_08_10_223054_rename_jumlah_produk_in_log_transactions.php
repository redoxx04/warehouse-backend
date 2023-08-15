<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameJumlahProdukInLogTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('log_transactions', function (Blueprint $table) {
            $table->renameColumn('jumlah_produk', 'jumlah_produk_invoice');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('log_transantions', function (Blueprint $table) {
            $table->renameColumn('jumlah_produk_invoice', 'jumlah_produk');
        });
    }
}
