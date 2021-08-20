<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'contacts',
		'file_name',
		'contract_end',
		'contract_conclusion',
		'contract_termination',

	];

	public function user() {
		return $this->belongsTo('App\User');
	}
}
