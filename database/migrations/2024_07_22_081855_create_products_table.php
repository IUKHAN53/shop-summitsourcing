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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('offerId')->nullable();
            $table->bigInteger('category_id')->nullable();
            $table->string('title')->nullable();
            $table->string('images')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('sold')->nullable();
            $table->string('price')->nullable();
            $table->string('unit')->nullable();
            $table->string('moq')->nullable();
            $table->string('rating')->nullable();
            $table->string('type')->default('trending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
