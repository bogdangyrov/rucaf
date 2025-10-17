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
        Schema::table('attribute_values', function (Blueprint $table) {
            $table->index(['product_id', 'attribute_id', 'value_id'], 'idx_av_product_attribute_value');
        });

        Schema::table('attributes', function (Blueprint $table) {
            $table->index('slug', 'idx_attributes_slug');
        });

        Schema::table('values', function (Blueprint $table) {
            $table->index('slug', 'idx_values_slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('idx_products_subcategory_active_views');
        });

        Schema::table('attribute_values', function (Blueprint $table) {
            $table->dropIndex('idx_av_product_attribute_value');
        });

        Schema::table('attributes', function (Blueprint $table) {
            $table->dropIndex('idx_attributes_slug');
        });

        Schema::table('values', function (Blueprint $table) {
            $table->dropIndex('idx_values_slug');
        });
    }
};
