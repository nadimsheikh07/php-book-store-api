<?php

use App\Models\Book;
use App\Models\Tag;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->timestamps();
        });

        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('writer')->nullable();
            $table->text('cover_image')->nullable();
            $table->text('description')->nullable();
            $table->decimal('rate', 18, 4)->default(0);
            $table->timestamps();
        });

        Schema::create('book_tag', function (Blueprint $table) {            
            $table->foreignIdFor(Book::class)->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignIdFor(Tag::class)->constrained()->onDelete('cascade')->onUpdate('cascade');            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
        Schema::dropIfExists('books');
        Schema::dropIfExists('book_tags');
    }
};
