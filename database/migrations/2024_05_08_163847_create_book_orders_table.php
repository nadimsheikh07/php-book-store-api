<?php

use App\Models\Book;
use App\Models\BookOrder;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('book_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->integer('total');
            $table->enum('status', ['pending', 'processing', 'cancel', 'complete'])->default('pending');
            $table->timestamps();
        });

        Schema::create('book_order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(BookOrder::class)->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignIdFor(Book::class)->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->integer('quantity')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_orders');
    }
};
