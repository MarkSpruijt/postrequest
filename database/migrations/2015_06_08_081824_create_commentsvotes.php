<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsvotes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('comment_votes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('comment_id');
			$table->boolean('vote'); // 0 = negative, 1 = positive;
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
		Schema::drop('comment_votes');
	}

}
