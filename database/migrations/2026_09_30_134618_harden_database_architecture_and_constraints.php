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
        // 1. Soft Deletes for Products & Categories
        Schema::table('categories', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->softDeletes();
            $table->unsignedInteger('stock_quantity')->default(0)->change();
            $table->decimal('price', 12, 2)->unsigned()->change();
        });

        // 2. Orders: user_id nullOnDelete to preserve historical orders
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->foreignId('user_id')->nullable()->change()->constrained('users')->nullOnDelete();
            $table->decimal('total_amount', 12, 2)->unsigned()->change();
        });

        // 3. Order Items: restrictOnDelete for product_id
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->foreignId('product_id')->change()->constrained('products')->restrictOnDelete();
            $table->unsignedInteger('quantity')->change();
            $table->decimal('unit_price', 12, 2)->unsigned()->change();
            $table->decimal('subtotal', 12, 2)->unsigned()->change();
        });

        // 4. Reviews: Unique (user_id, product_id)
        Schema::table('reviews', function (Blueprint $table) {
            $table->unique(['user_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'product_id']);
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->foreignId('product_id')->change()->constrained('products')->cascadeOnDelete();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->foreignId('user_id')->nullable(false)->change()->constrained('users')->cascadeOnDelete();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
