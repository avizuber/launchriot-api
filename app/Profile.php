<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Encryptable;

class Profile extends Model implements Auditable
{

	use \OwenIt\Auditing\Auditable, Encryptable;

	/**
	 * The attributes that are encrypted.
	 *
	 * @var array
	 */
	protected $encryptable = [
		'gender',
		'dob', 
		'city',
		'bio', 
		'avatar',
	];

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'user_id',
		'gender',
		'dob', 
		'city', 
		'bio', 
		'avatar',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'dob' => 'date',
	];

	protected $dates = [
        'created_at',
        'updated_at',
        'dob'
    ];

	public function user() {
		return $this->belongsTo('App\User');
	}

}