<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWallPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wall_posts', function (Blueprint $table) {
            $table->id();
            $table->string('subscription_id');
            $table->string('unique_id')->nullable();
            $table->string('name', 100);
            $table->string('email', 100);
            $table->string('company', 100)->nullable();
            $table->string('position', 100)->nullable();
            $table->text('message');
            $table->string('image')->nullable();
            $table->boolean('visible')->default(0);
            $table->boolean('approved')->default(0);
            $table->string('background')->nullable();
            $table->string('font_color')->nullable();
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
        Schema::dropIfExists('wall_posts');
    }
}
