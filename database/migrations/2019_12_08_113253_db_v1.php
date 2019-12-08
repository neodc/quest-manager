<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DbV1 extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create(
			'campaigns',
			function (Blueprint $table) {
				$table->bigIncrements('id');
				$table->string('name');
			}
		);

		Schema::create(
			'campaign_user',
			function (Blueprint $table) {
				$table->unsignedBigInteger('campaign_id');
				$table->unsignedBigInteger('user_id');
				$table->boolean('is_dm');

				$table->foreign('campaign_id')
					->references('id')
					->on('campaigns')
					->onDelete('cascade');

				$table->foreign('user_id')
					->references('id')
					->on('users')
					->onDelete('cascade');

				$table->unique(['campaign_id', 'user_id']);
			}
		);

		Schema::create(
			'quests',
			function (Blueprint $table) {
				$table->bigIncrements('id');
				$table->unsignedBigInteger('campaign_id');
				$table->string('name');
				$table->string('icon');

				$table->foreign('campaign_id')
					->references('id')
					->on('campaigns')
					->onDelete('cascade');
			}
		);

		Schema::create(
			'steps',
			function (Blueprint $table) {
				$table->bigIncrements('id');
				$table->unsignedBigInteger('quest_id');
				$table->string('name');
				$table->mediumText('player_content');
				$table->mediumText('dm_content');
				$table->enum('state', ['todo', 'in_progress', 'done']);
				$table->boolean('is_visible');

				$table->foreign('quest_id')
					->references('id')
					->on('quests')
					->onDelete('cascade');
			}
		);

		Schema::create(
			'resources',
			function (Blueprint $table) {
				$table->bigIncrements('id');
				$table->unsignedBigInteger('campaign_id');
				$table->string('name');
				$table->mediumText('player_description');
				$table->mediumText('dm_description');
				$table->boolean('is_visible');

				$table->foreign('campaign_id')
					->references('id')
					->on('campaigns')
					->onDelete('cascade');
			}
		);

		Schema::create(
			'comments',
			function (Blueprint $table) {
				$table->bigIncrements('id');
				$table->unsignedBigInteger('quest_id');
				$table->unsignedBigInteger('user_id')->nullable();
				$table->unsignedBigInteger('step_id')->nullable();
				$table->unsignedBigInteger('resource_id')->nullable();
				$table->mediumText('player_text');
				$table->mediumText('dm_text');
				$table->boolean('is_visible');
				$table->string('type');

				$table->foreign('quest_id')
					->references('id')
					->on('quests')
					->onDelete('cascade');

				$table->foreign('user_id')
					->references('id')
					->on('users')
					->onDelete('set null');

				$table->foreign('step_id')
					->references('id')
					->on('steps')
					->onDelete('set null');

				$table->foreign('resource_id')
					->references('id')
					->on('resources')
					->onDelete('set null');
			}
		);

		Schema::create(
			'user_can_talk_as_resource',
			function (Blueprint $table) {
				$table->unsignedBigInteger('user_id');
				$table->unsignedBigInteger('resource_id');

				$table->foreign('user_id')
					->references('id')
					->on('users')
					->onDelete('cascade');

				$table->foreign('resource_id')
					->references('id')
					->on('resources')
					->onDelete('cascade');
			}
		);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('user_can_talk_as_resource');
		Schema::dropIfExists('comments');
		Schema::dropIfExists('resources');
		Schema::dropIfExists('steps');
		Schema::dropIfExists('quests');
		Schema::dropIfExists('campaign_user');
		Schema::dropIfExists('campaigns');
	}
}
