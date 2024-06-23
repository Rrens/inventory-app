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
        Schema::create('pemesanans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barang_id')->nullable();
            $table->foreign('barang_id')
                ->references('id')
                ->on('barangs');
            $table->string('pemesanan_id')->unique();
            $table->string('slug')->unique();
            $table->string('store_for');
            $table->double('order_cost')->default(0);
            $table->double('price_total')->nullable();
            $table->boolean('is_verify')->nullable();
            $table->date('order_date');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanans');
    }
};
