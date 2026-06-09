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
        Schema::table('product_types', function (Blueprint $table) {
            $table->string('h1')->nullable();
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->string('h1')->nullable();
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
        });

        Schema::table('subcategories', function (Blueprint $table) {
            $table->string('h1')->nullable();
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->string('h1')->nullable();
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_types', function (Blueprint $table) {
            $table->dropColumn(['h1', 'seo_title', 'seo_description', 'og_title', 'og_description']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['h1', 'seo_title', 'seo_description', 'og_title', 'og_description']);
        });

        Schema::table('subcategories', function (Blueprint $table) {
            $table->dropColumn(['h1', 'seo_title', 'seo_description', 'og_title', 'og_description']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['h1', 'seo_title', 'seo_description', 'og_title', 'og_description']);
        });
    }
};
