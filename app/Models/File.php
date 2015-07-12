<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model {

    use BaseModelTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'files';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['file'];

}
