<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penjualan_details', function (Blueprint $table) {
            $table->string('penjualan_detail_id')->primary();
            $table->string('penjualan_id')->nullable();
            $table->foreign('penjualan_id')
                ->references('penjualan_id')
                ->on('penjualans');
            $table->unsignedBigInteger('barang_id')->nullable();
            $table->foreign('barang_id')
                ->references('id')
                ->on('barangs');
            $table->integer('quantity');
            $table->double('subtotal');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan_details');
    }
};
