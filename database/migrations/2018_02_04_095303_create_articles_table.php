<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',125)->default('')->comment('文章标题');
            $table->text('content')->comment('文章内容');
            $table->tinyInteger('user_id')->comment('文章所属用户');
            $table->tinyInteger('category_id')->comment('文章所属分类');
            $table->dateTime('created_at')->comment('添加时间');
            $table->dateTime('updated_at')->comment('修改时间');
            $table->dateTime('deleted_at')->comment('删除时间')->nullable();
            $table->unique('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
