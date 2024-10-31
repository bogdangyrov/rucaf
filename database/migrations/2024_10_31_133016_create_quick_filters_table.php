<?php

use App\Models\Value;
use App\Models\Attribute;
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
        Schema::create('quick_filters', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ProductType::class);
            $table->foreignIdFor(Attribute::class);
            $table->foreignIdFor(Value::class);
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quick_filters');
    }
};
