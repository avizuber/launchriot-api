<?php

namespace App;
use App\User;
use App\Thing;
use Auth;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Encryptable;

class Thing extends Model implements Auditable
{

	use \OwenIt\Auditing\Auditable, Encryptable;

	/**
	 * The attributes that are encrypted.
	 *
	 * @var array
	 */
	protected $encryptable = [
		'user_id',
		'title',
		'description',
	];

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'user_id',
		'title',
		'description', 
		'a_string',
	];

	public function user() {
		return $this->belongsTo('App\User');
	}

	public function scopeForCurrentUser($query)
	{
		$things = User::find(Auth::user()->id)->getAllUserThings();
		return $things;
	}

}
