<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id')->comment('Relationship with blog_categories table');
            $table->integer('user_id')->comment('Relationship with users table');
            $table->string('blog_title');
            $table->longText('blog_description');
            $table->string('blog_thumbnail_photo')->default('default.jpg');
            $table->string('blog_details_photo')->default('default.jpg');
            $table->longText('slug');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogs');
    }
}
