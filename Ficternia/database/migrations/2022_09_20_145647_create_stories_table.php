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
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('visibility')->default("private");
            $table->integer("views")->default(0);
            $table->longText('description')->nullable();
            $table->foreignId("content_id")->nullable()->constrained()->onDelete('cascade');
            $table->foreignId("genre_id")->constrained();
            $table->foreignId("audience_id")->constrained();
            $table->foreignId("state_id")->constrained();
            $table->string('img_path')->nullable();
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
        Schema::dropIfExists('stories');
    }
};
