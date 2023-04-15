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
        Schema::create('reading_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId("story_id")->constrained("stories")->onDelete('cascade');
            $table->foreignId("user_id")->constrained("users")->onDelete('cascade');
            $table->foreignId("current_chapter_id")->constrained("chapters")->onDelete('cascade');
            $table->boolean('is_done')->default(false);
            $table->string('status_update')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reading_statuses');
    }
};
