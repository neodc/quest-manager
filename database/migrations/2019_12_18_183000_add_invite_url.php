<?php

use App\Models\Campaign;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInviteUrl extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('campaigns', function (Blueprint $table) {
			$table->char('invite_id', 8)->after('name');
		});

		Campaign::each(
			function(Campaign $campaign)
			{
				$campaign->generateInviteId();
				$campaign->save();
			}
		);

		Schema::table('campaigns', function (Blueprint $table) {
			$table->unique('invite_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('campaigns', function (Blueprint $table) {
			$table->dropColumn('invite_id');
		});
	}
}
