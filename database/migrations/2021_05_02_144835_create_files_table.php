<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('files', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name');
			$table->string('file_name');
			$table->bigInteger('user_id')->unsigned();
			$table->string('contacts');
			$table->timestamp('contract_end');
			$table->timestamp('contract_conclusion');
			$table->timestamp('contract_termination');

			$table->timestamps();
		});

		Schema::table('files', function($table) {
			$table->foreign('user_id')->references('id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('files');
	}
}
