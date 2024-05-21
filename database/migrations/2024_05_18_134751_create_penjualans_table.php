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
            $table->string('slug');
            $table->double('grand_total')->nullable();
            $table->date('order_date')->nullable();

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
