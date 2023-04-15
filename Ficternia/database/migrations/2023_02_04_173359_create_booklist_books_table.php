<?php

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
        Schema::create('booklist_books', function (Blueprint $table) {
            $table->id();
            $table->foreignId("booklist_id")->constrained("book_lists")->onDelete('cascade');
            $table->foreignId("book_id")->constrained("stories")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booklist_books');
    }
};
