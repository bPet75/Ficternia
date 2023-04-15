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
        Schema::create('chapters', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default("Untitled chapter")->nullable();
            $table->integer("serial");
            $table->longText('body')->nullable();
            $table->foreignId("draft_id")->constrained()->onDelete('cascade');
            $table->integer("views")->default(0);
            $table->string('visibility')->default("private");
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
        Schema::dropIfExists('chapters');
    }
};
