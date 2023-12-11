<?php

use App\Models\FlashSale;
use App\Models\Media;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(FlashSale::class)->nullable();
            $table->string('name');
            $table->string('slug');
            $table->foreignId('category_id')->nullable()->constrained('categories');
            $table->foreignId('subcategory_id')->nullable()->constrained('sub_categories');
            $table->foreignId('brand_id')->nullable()->constrained('brands');
            $table->text('description')->nullable();
            $table->double('price');
            $table->decimal('rating', 8, 2)->default(5);
            $table->integer('stock_in');
            $table->integer('stock_out')->default(0);
            $table->integer('discount')->nullable();
            $table->string('image');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
