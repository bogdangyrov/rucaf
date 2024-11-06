<?php

use App\Models\Category;
use App\Models\ProductType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->json('images')->nullable();
            $table->integer('price')->nullable();
            $table->integer('discount_price')->nullable();
            $table->text('description');
            $table->boolean('is_new')->default(true);
            $table->boolean('is_hit_of_sales')->default(false);
            $table->foreignIdFor(ProductType::class);
            $table->foreignIdFor(Category::class);
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
