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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->string('name');
            $table->float('saving_cost');
            $table->float('price');
            $table->string('unit');
            $table->integer('eoq')->default(0);
            $table->integer('rop')->default(0);
            $table->integer('quantity')->default(0);
            $table->integer('leadtime')->nullable();
            $table->integer('max_quantity');
            $table->string('place')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
