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
        Schema::create('penjualans', function (Blueprint $table) {
            $table->string('penjualan_id');
            $table->primary('penjualan_id');
            $table->unsignedBigInteger('barang_id')->nullable();
            $table->foreign('barang_id')
                ->references('id')
                ->on('barangs');
            $table->string('slug')->nullable();
            $table->double('grand_total')->nullable();
            $table->date('order_date')->nullable();
            $table->integer('quantity');
            $table->boolean('status')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['penjualan_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualans');
    }
};
