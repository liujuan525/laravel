<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepliesTable extends Migration 
{
	public function up()
	{
		Schema::create('replies', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('topic_id')->unsigned()->default(0)->index();
            $table->integer('user_id')->unsigned()->default(0)->index();
            $table->text('content');
            // 当 user_id 对应的 users 表数据被删除时，删除此条数据
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // 当 topic_id 对应的 topics 表数据被删除时，删除此条数据
            $table->foreign('topic_id')->references('id')->on('topics')->onDelete('cascade');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('replies');
	}
}
